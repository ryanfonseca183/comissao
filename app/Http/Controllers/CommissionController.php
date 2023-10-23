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
                return $query->whereDay('expiration_date', strlen($day) == 1 ? "0" . $day : $day);
            })
            ->when($request->month, function($query, $month){
                return $query->whereMonth('expiration_date', $month);
            })
            ->when($request->year, function($query, $year){
                return $query->whereYear('expiration_date', 'like', "%{$year}%");
            })
            ->join('companies', 'companies.id', '=', 'payments.indication_id')
            ->join('budgets', 'budgets.company_id', '=', 'companies.id')
            ->join('services', 'services.id', '=', 'companies.service_id')
            ->select('payments.*', 'budgets.payment_term', 'services.name', 'companies.corporate_name');
        
        return Datatables::of($payments)
            ->filterColumn('paid', function($query, $keyword) {
                $needle = strtolower($keyword);
                $pending = strpos('pendente', $needle) !== false;
                $paid = strpos('pago', $needle) !== false;
                
                $query->when($pending || $paid, function($query) use ($paid) {
                    return $query->where('paid', $paid ? 1 : 0);
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
            ->filterColumn('expiration_date', function(){
                return false;
            })
            ->editColumn('installment', function(Payment $payment){
                return $payment->installment . "/" . $payment->payment_term;
            })
            ->editColumn('value', function(Payment $payment){
                return "R$ " . number_format($payment->value, 2, ',', '.');
            })
            ->editColumn('expiration_date', function(Payment $payment){
                return $payment->expiration_date->format('d/m/Y');
            })
            ->editColumn('paid', function(Payment $payment){
                return $payment->paid == 1
                    ? '<span style="color:green">Pago</span>'
                    : '<span style="color:red">Pendente</span>';
            })
            ->addColumn('actions', function(Payment $payment){
                $actions = "<div class='flex items-center'>";
                $actions .= view('components.buttons.show', [
                    'route' => route('admin.indications.budget.show', $payment->indication_id)
                ])->render();
                if(! $payment->paid) {
                    $actions .= view('components.buttons.payment', compact('payment'))->render();
                }
                $actions .= "</div>";
                return $actions;
            })
            ->rawColumns(['paid', 'actions'])
            ->make();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $installment = $company->payments()->findOrFail($request->installment);
        abort_if($installment->paid, 403);
        $installment->update([
            'receipt' => $request->file('file')->store('receipts'),
            'payment_date' => now()->format('Y-m-d H:i:s'),
            'paid' => 1
        ]);
        session()->flash('f-success', 'Pagamento registrado com sucesso!');
        if($request->origin == 'budgets') {
            return redirect()->route('admin.indications.budget.show', $company);
        }
        return redirect()->route('admin.commissions.index');
    }
}
