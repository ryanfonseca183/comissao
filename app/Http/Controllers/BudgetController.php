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
use DataTables;
use Carbon\Carbon;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.budgets.index');
    }

    public function datatable(Request $request)
    {
        $budgets = Budget::query()
            ->when(isset($request->status), function($query) use($request){
                return $query->where('companies.status', $request->status);
            })
            ->join('companies', 'companies.id', '=', 'budgets.company_id')
            ->join('users', 'users.id', '=', 'companies.user_id')
            ->select('budgets.expiration_date', 'budgets.value', 'budgets.employees_number', 'budgets.measuring_area', 'budgets.number', 'budgets.company_id', 'companies.corporate_name', 'companies.doc_num', 'companies.status', 'users.name as username');
        
        return Datatables::of($budgets)
            ->filterColumn('companies.status', function($query, $keyword){
                $status = collect(IndicationStatusEnum::array())->map(function($status, $index) use($keyword){
                    return strpos(strtolower($status), strtolower($keyword)) !== FALSE
                        ? $index
                        : null;
                })
                ->filter();
                $query->whereIn('companies.status', $status);
            })
            ->filterColumn('expiration_date', function($query, $keyword){
                return false;
            })
            ->filterColumn('value', function($query, $keyword){
                return false;
            })
            ->editColumn('expiration_date', function(Budget $budget){
                if($budget->expiredOrCloseToExpire) {
                    return "<span class='text-red-400'>{$budget->expiration_date->format('d/m/Y')}</span>";
                }
                return $budget->expiration_date->format('d/m/Y');
            })
            ->editColumn('value', function(Budget $budget){
                return "R$ " . number_format($budget->totalValue, '2', ',', '.');
            })
            ->editColumn('status', function(Budget $budget){
                return IndicationStatusEnum::label($budget->status);
            })
            ->addColumn('actions', function(Budget $budget) {
                return view('components.buttons.show', [
                        'route' => route('admin.indications.budget.edit', [
                            'company' => $budget->company_id,
                            'origin' => 'admin.budgets.index'
                        ])])->render();
            })
            ->rawColumns(['expiration_date', 'actions'])
            ->make();
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
        $expiration_date = Carbon::createFromFormat('Y-m-d', $request->first_payment_date)
            ->addMonths($request->payment_term);

        $budget = $company->budget()->create(array_merge(
            $request->validated(), [
                'operator_id' => auth()->guard('admin')->user()->id,
                'expiration_date' => $expiration_date
            ]
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
        $company->update([
            'status' => IndicationStatusEnum::RESCINDIDO,
        ]);
        //Deleta as parcelas que ainda não venceram
        $company->payments()
            ->whereDate('expiration_date', '>', now())
            ->where('paid', 0)
            ->delete();
        //Atualiza as informações do orçamento
        $company->budget->update([
            'expiration_date' => now(),
            'payment_term' => $company->payments()->count()
        ]);
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
        $company->payments()
            ->whereDate('expiration_date', '>', now())
            ->where('paid', 0)
            ->update(compact('value'));
        //Registra a mensagem de sucesso
        session()->flash('f-success', __('messages.update:success', ['Entity' => __('Budget')]));
        return redirect()->back();
    }
}
