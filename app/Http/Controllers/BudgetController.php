<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Company;
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
        //Verifica se um orçamento já foi realizado
        if($company->budget)
            return redirect()->route('admin.indications.budget.edit', compact('company'));

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

        return redirect()->route('admin.indications.budget.edit', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        //Verifica se um orçamento já foi realizado
        if(! $company->budget)
            return redirect()->route('admin.indications.budget.create', compact('company'));

        //Verifica se o orçamento ainda está dentro do prazo editável
        if($company->budget->created_at->diffInHours(now()) > 1)
            return view('admin.budgets.show', compact('company'));

        return view('admin.budgets.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateBudgetRequest $request, Company $company)
    {
        $company->budget->update($request->validated());

        return redirect()->back();
    }
}
