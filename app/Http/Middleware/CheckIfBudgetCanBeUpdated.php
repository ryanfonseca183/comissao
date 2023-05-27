<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIfBudgetCanBeUpdated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $company = $request->company;
        //Verifica se o orçamento ainda está dentro do prazo editável
        if($company->statusIn(['FECHADO', 'RECUSADO']))
            return redirect()->route('admin.indications.budget.show', compact('company'));

        return $next($request);
    }
}
