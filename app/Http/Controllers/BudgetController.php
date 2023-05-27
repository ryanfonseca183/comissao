<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Company;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUpdateBudgetRequest;
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
        $budgets = Budget::join('companies', 'companies.id', 'budgets.company_id')
            ->select('budgets.created_at', 'company_id', 'number', 'value', 'status', 'closed', 'doc_num')
            ->get();

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

        $request->validate(['status' => 'integer|in:3,4']);

        $company->update(['status' => $request->status]);

        $closed = $request->status == IndicationStatusEnum::FECHADO;

        //Cria os pagamentos de comissão, em caso de orçamento aprovado
        if ($closed) $this->createPayments($company->budget);

        //Atualiza o status do orçamento
        $company->budget->update(['closed' => $closed]);

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
        for($i = 1; $i <= $budget->payment_term; $i++) {
            $payments[] = [
                'indication_id' => $budget->company_id,
                'payment_date' => $budget->first_payment_date->addMonth($i - 1)->format('Y-m-d'),
                'installment' => $i,
            ];
        }
        Payment::insert($payments);
    }
}
