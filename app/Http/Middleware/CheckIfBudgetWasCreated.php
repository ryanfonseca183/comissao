<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIfBudgetWasCreated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $company = $request->company;
        //Verifica se um orçamento já foi realizado
        if(! $company->budget) {
            return redirect()->route('admin.indications.budget.create', [
                'company' => $company,
                'origin' => 'admin.indications.index'
            ]);
        }
        return $next($request);
    }
}
