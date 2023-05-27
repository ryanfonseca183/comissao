<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUpdateOperatorRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;

class OperatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $operators = Operator::where('isAdmin', 0)->get();

        return view('admin.operators.index', compact('operators'));
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
        DB::beginTransaction();
        try {
            $operator = Operator::create(array_merge(
                ['password' => Hash::make(Str::random(8))],
                $request->validated()
            ));
            $operator->sendPasswordResetNotification(
                Password::createToken($operator),
                $signUp = true
            );
            session()->flash('f-success', __('messages.store:success', ['Entity' => __('Operator')]));
            DB::commit();
            return redirect()->route('admin.operators.index');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Não foi possível criar a conta do operador. ' . $e->getMessage());
            session()->flash('f-error', __('messages.store:error', ['Entity' => __('Operator')]));
            return redirect()->route('admin.operators.create');
        }
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

        session()->flash('f-success', __('messages.update:success', ['Entity' => __('Operator')]));

        return redirect()->route('admin.operators.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Operator $operator)
    {
        try {
            $operator->delete();
            session()->flash('f-success', __('messages.destroy:success', ['Entity' => __('Operator')]));
        } catch (\Exception $e) {
            Log::error('Não foi possível deletar a conta do operador. ' . $e->getMessage());
            session()->flash('f-error', __('messages.destroy:error.reference', ['Entity' => __('Operator')]));
        }
        return redirect()->route('admin.operators.index');
    }
}
