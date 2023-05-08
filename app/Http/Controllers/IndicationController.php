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
        $indications = auth()->guard('user')->user()->indications()->create($request->validated());

        return redirect()->route('indications.index');
    }
}
