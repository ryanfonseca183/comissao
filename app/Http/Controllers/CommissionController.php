<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Company;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.commissions.index');
    }

    public function datatable(Request $request)
    {
        $payments = Payment::query()
            ->when($request->day, function($query, $day){
                return $query->whereDay('payment_date', strlen($day) == 1 ? "0" . $day : $day);
            })
            ->when($request->month, function($query, $month){
                return $query->whereMonth('payment_date', $month);
            })
            ->when($request->year, function($query, $year){
                return $query->whereYear('payment_date', 'like', "%{$year}%");
            })
            ->join('companies', 'companies.id', '=', 'payments.indication_id')
            ->join('budgets', 'budgets.company_id', '=', 'companies.id')
            ->join('services', 'services.id', '=', 'companies.service_id')
            ->select('payments.*', 'budgets.payment_term', 'services.name', 'companies.corporate_name');
        
        return Datatables::of($payments)
            ->filterColumn('paid', function($query, $keyword) {
                $needle = strtolower($keyword);
                $isFilteringByStatus = in_array($needle, ['sim', 'não', 'nao']);

                $query->when($isFilteringByStatus, function($query) use ($needle) {
                    return $query->where('paid', $needle == 'sim' ? 1 : 0);
                });
            })
            ->filterColumn('installment', function($query, $keyword){
                $tokens = explode('/', $keyword);
                $query->where('installment', 'like', "%{$tokens[0]}%")
                      ->when(count($tokens) > 1, function($query) use ($tokens){
                        return $query->where('payment_term', 'like', "%{$tokens[1]}%");
                      }, function($query) use($tokens){
                        return $query->orWhere('payment_term', 'like', "%{$tokens[0]}%");
                      });
            })
            ->filterColumn('value', function($query, $keyword){
                $value = str_replace('.', '', $keyword);
                $value = str_replace(',', '.', $value);
                $query->where('payments.value', 'like', "%{$value}%");
            })
            ->filterColumn('payment_date', function(){
                return false;
            })
            ->editColumn('installment', function(Payment $payment){
                return $payment->installment . "/" . $payment->payment_term;
            })
            ->editColumn('value', function(Payment $payment){
                return "R$ " . number_format($payment->value, 2, ',', '.');
            })
            ->editColumn('payment_date', function(Payment $payment){
                return $payment->payment_date->format('d/m/Y');
            })
            ->editColumn('paid', function(Payment $payment){
                return $payment->paid == 1
                    ? '<span style="color:green">Sim</span>'
                    : '<span style="color:red">Não</span>';
            })
            ->rawColumns(['paid'])
            ->make();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        return view('admin.commissions.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
}
