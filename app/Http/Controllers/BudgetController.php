<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Company;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUpdateBudgetRequest;
use App\Enums\IndicationStatusEnum;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $budgets = Budget::all();

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
        $budget = $company->budget()->create($request->validated());
        $this->createPayments($budget);
        $company->update(['status' => IndicationStatusEnum::ORCADO]);

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
        //Se o prazo ou a data do primeiro pagamento for alterada, recria as parcelas de pagamento
        if($company->budget->wasChanged(['first_payment_date', 'payment_term'])) {
            $company->payments()->delete();
            $this->createPayments($company->budget);
        }
        return redirect()->back();
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


    /**
     * Show the form for editing the specified resource.
     */
    public function show(Company $company)
    {
        return view('admin.budgets.show', compact('company'));
    }
}
