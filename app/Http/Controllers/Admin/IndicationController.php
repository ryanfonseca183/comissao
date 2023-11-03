<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Enums\IndicationStatusEnum;
use App\Http\Controllers\Controller;
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
            ->select('corporate_name', 'doc_num', 'companies.status', 'services.name');
        
        return Datatables::of($indications)
            ->editColumn('status', function(Company $company){
                return IndicationStatusEnum::label($company->status);
            })
            ->addColumn('actions', function() {
                return "";
            })
            ->rawColumns(['actions'])
            ->make();
    }
}
