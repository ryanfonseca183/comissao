<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Enums\IndicationStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIndicationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DataTables;

class IndicationController extends Controller
{
    public function index()
    {
        return view('admin.indications.index');
    }

    public function datatable(Request $request)
    {
        $indications = Company::query()
            ->join('services', 'services.id', '=', 'companies.service_id')
            ->leftJoin('users', 'companies.user_id', '=', 'users.id')
            ->select('companies.id', 'corporate_name', 'companies.doc_num', 'companies.status', 'users.name as username', 'services.name as service');
        
        return Datatables::of($indications)
            ->filterColumn('status', function($query, $keyword){
                $status = collect(IndicationStatusEnum::array())->map(function($status, $index) use($keyword){
                    return strpos(strtolower($status), strtolower($keyword)) !== FALSE
                        ? $index
                        : null;
                })
                ->filter();
                $query->whereIn('companies.status', $status);
            })
            ->filterColumn('users.name', function($query, $keyword){
                $searchingByNullName = strpos("cadastro interno", strtolower($keyword)) !== FALSE;
                $query->where('users.name', 'like', "%{$keyword}%")
                      ->when($searchingByNullName, function($query) {
                            return $query->orWhereNull('user_id');
                      });
            })
            ->editColumn('username', function(Company $company){
                return $company->username ?: "Cadastro Interno";
            })
            ->editColumn('status', function(Company $company){
                return IndicationStatusEnum::label($company->status);
            })
            ->addColumn('actions', function(Company $company) {
                $actions = "<div class='flex items-center'>";
                $actions .= view('components.buttons.edit', [
                    'route' => route('admin.indications.edit', $company->id)
                ])->render();
                $actions .= view('components.buttons.show', [
                    'route' => route('admin.indications.budget.create', $company->id)
                ])->render();
                if($company->statusEqualTo('PENDENTE')) {
                    $actions .= view('components.buttons.delete', [
                        'route' => route('admin.indications.destroy', $company->id)
                    ])->render(); 
                }
                $actions .= "</div>";
                return $actions;
            })
            ->rawColumns(['actions'])
            ->make();
    }

    public function create()
    {
        return view('user.companies.create', ['context' => 'admin.']);
    }

    public function store(StoreIndicationRequest $request)
    {
        $indication = Company::create($request->validated());

        session()->flash('f-success', __('messages.store:success', ['Entity' => __('Indication')]));
        
        return redirect()->route('admin.indications.index');
    }

    public function edit(Company $company)
    {
        return view('user.companies.edit', ['company' => $company, 'context' => 'admin.']);
    }

    public function update(StoreIndicationRequest $request, Company $company)
    {
        $company->update($request->validated());

        session()->flash('f-success', __('messages.update:success', ['Entity' => __('Indication')]));
        
        return redirect()->route('admin.indications.index');
    }

    public function destroy(Company $company)
    {
        try {
            $company->delete();

            session()->flash('f-success', __('messages.destroy:success', ['Entity' => __('Indication')]));

        } catch (\Exception $e) {
            session()->flash('f-success', __('messages.destroy:error', ['Entity' => __('Indication')]));
        }
        return redirect()->route('admin.indications.index');
    }
}
