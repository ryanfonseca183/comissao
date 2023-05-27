<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Operator;
use Illuminate\Http\Request;
use App\Http\Requests\StoreIndicationRequest;
use App\Notifications\IndicationCreated;
use Illuminate\Support\Facades\Notification;

class IndicationController extends Controller
{
    public function index()
    {
        $indications = auth()->guard('user')->user()->indications()
                        ->select('id', 'corporate_name', 'doc_num', 'service_id', 'status')
                        ->with('service:id,name')
                        ->get();

        return view('user.companies.index', compact('indications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIndicationRequest $request)
    {
        $indication = auth()->guard('user')->user()->indications()->create($request->validated());

        Notification::send(Operator::where('status', 1)->get(), new IndicationCreated($indication));

        return redirect()->route('indications.edit', $indication);
    }

    /**
     * Show the resource.
     */
    public function show($id)
    {
        $company = Company::find($id);

        return view('user.companies.show', compact('company'));
    }

    /**
     * Show the form for editing a new resource.
     */
    public function edit($id)
    {
        $company = Company::find($id);

        if($company->statusDiffFrom('PENDENTE')) {
            return redirect()->route('indications.show', $id);
        }
        return view('user.companies.edit', compact('company'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function update(StoreIndicationRequest $request, $id)
    {
        $company = Company::find($id);

        abort_if($company->statusDiffFrom('PENDENTE'), 403);

        $company->update($request->validated());

        return redirect()->route('indications.index');
    }

    public function destroy($id)
    {
        Company::where('id', $id)->delete();

        return redirect()->route('indications.index');
    }
}
