<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\StoreIndicationRequest;

class IndicationController extends Controller
{
    public function index()
    {
        return view('user.companies.index');
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

        return redirect()->route('indications.edit', $indication);
    }

    /**
     * Show the form for editing a new resource.
     */
    public function edit($id)
    {
        $company = Company::find($id);

        return view('user.companies.edit', compact('company'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function update(StoreIndicationRequest $request, $id)
    {
        Company::where('id', $id)->update($request->validated());

        return redirect()->route('indications.index');
    }

    public function destroy($id)
    {
        Company::where('id', $id)->delete();

        return redirect()->route('indications.index');
    }
}
