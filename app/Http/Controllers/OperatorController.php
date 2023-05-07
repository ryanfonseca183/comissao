<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUpdateOperatorRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OperatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.operators.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.operators.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateOperatorRequest $request)
    {
        $operator = Operator::create(array_merge(
            ['password' => Hash::make(Str::random(8))],
            $request->validated()
        ));
        return redirect()->route('admin.operators.edit', $operator);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Operator $operator)
    {
        return view('admin.operators.edit', compact('operator'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateOperatorRequest $request, Operator $operator)
    {
        $operator->update($request->validated());

        return redirect()->route('admin.operators.edit', $operator)->with('message', 'Saved');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Operator $operator)
    {
        $operator->delete();

        return redirect()->route('admin.operators.index');
    }
}
