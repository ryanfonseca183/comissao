<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Company;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUpdateBudgetRequest;
use App\Http\Requests\UpdateBudgetQuantity;
use App\Enums\IndicationStatusEnum;
use App\Notifications\BudgetCreated;
use Illuminate\Support\Facades\Log;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $budgets = Budget::with('company', 'company.user')->get();

        return view('admin.budgets.index', compact('budgets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Company $company)
    {
        //Verifica se a indicação já foi posta em análise
        if($company->status != IndicationStatusEnum::ANALISE)
            $company->update(['status' => IndicationStatusEnum::ANALISE]);

        return view('admin.budgets.create', compact('company'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateBudgetRequest $request, Company $company)
    {
        $budget = $company->budget()->create(array_merge(
            $request->validated(),
            ['operator_id' => auth()->guard('admin')->user()->id]
        ));

        $company->update(['status' => IndicationStatusEnum::ORCADO]);

        session()->flash('f-success', __('messages.store:success', ['Entity' => __('Budget')]));

        try {
            $company->user->notify(new BudgetCreated($company));
        } catch (\Exception  $e) {
            Log::error('Não foi possível enviar notificação de cadastro de orçamento. '. $e->getMessage());
        }
        return redirect()->route('admin.indications.budget.edit', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        return view('admin.budgets.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateBudgetRequest $request, Company $company)
    {
        $company->budget->update($request->validated());

        session()->flash('f-success', __('messages.update:success', ['Entity' => __('Budget')]));
       
        return redirect()->back();
    }

    public function updateStatus(Request $request, Company $company)
    {
        abort_if($company->statusDiffFrom('ORCADO'), 403);

        $validated = $request->validate([
            'contract_number' => 'exclude_with:status|string|max:255',
        ]);
        $status = isset($validated['contract_number']) ? 3 : 4;
        if($status == IndicationStatusEnum::FECHADO) {
            //Cria as parcelas de pagamento de comissão
            $this->createPayments($company->budget);
            //Atualiza o número do contrato
            $company->budget->update([
                'contract_number' => $request->contract_number
            ]);
        }
        $company->update(compact('status'));
        //Atualiza o status do orçamento
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show(Company $company)
    {
        return view('admin.budgets.show', compact('company'));
    }
    
    private function createPayments(Budget $budget)
    {
        $payments = [];
        //Calcula o valor das parcelas
        $value = $budget->totalValue * ($budget->commission / 100);
        //Cria as parcelas
        for($i = 1; $i <= $budget->payment_term; $i++) {
            $payments[] = [
                'indication_id' => $budget->company_id,
                'expiration_date' => $budget->first_payment_date->addMonth($i - 1)->format('Y-m-d'),
                'installment' => $i,
                'value' => $value,
            ];
        }
        //Persiste as parcelas no banco de dados
        Payment::insert($payments);
    }

    public function revoke(Company $company)
    {
        //Verifica se o contrato está com status fechado
        abort_if($company->statusDiffFrom('FECHADO'), 403);
        //Altera o status do contrato para rescindido
        $company->update(['status' => IndicationStatusEnum::RESCINDIDO]);
        //Deleta as parcelas que ainda não venceram
        $company->payments()->whereDate('expiration_date', '>', now())->delete();
        session()->flash('f-success', 'Contrato rescindido com sucesso!');
        return redirect()->back();
    }

    public function changeQuantity(UpdateBudgetQuantity $request, Company $company)
    {
        //Atualiza a quantidade de vidas ou área medida
        $company->budget->update($request->validated());
        //Calcula o valor das parcelas
        $value = $company->budget->totalValue * ($company->budget->commission / 100);
        //Atualiza o valor das parcelas que ainda não foram pagas
        $company->payments()->whereDate('expiration_date', '>', now())->update(compact('value'));
        //Registra a mensagem de sucesso
        session()->flash('f-success', __('messages.update:success', ['Entity' => __('Budget')]));
        return redirect()->back();
    }
}
