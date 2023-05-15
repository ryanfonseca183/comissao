<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Enums\IndicationStatusEnum;

class AdminDashboard extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $indications = Company::with('service')->whereNotIn('status', [
            IndicationStatusEnum::FECHADO,
            IndicationStatusEnum::RECUSADO,
        ])->get();

        return view('admin.dashboard', compact('indications'));
    }
}
