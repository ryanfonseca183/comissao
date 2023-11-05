<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Http\Requests\StoreUpdateUserRequest;
use App\Models\User;
use DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.users.index');
    }

    public function datatable(Request $request)
    {
        $users = User::query();
        
        return Datatables::of($users)
            ->addColumn('actions', function(User $user) {
                $actions = "<div class='flex items-center'>";
                $actions .= view('components.buttons.edit', [
                    'route' => route('admin.users.edit', $user->id),
                    'icon' => true,
                ])->render();
                $actions .= view('components.buttons.delete', [
                    'route' => route('admin.users.destroy', $user->id),
                    'icon' => true,
                ])->render(); 
                $actions .= "</div>";
                return $actions;
            })
            ->rawColumns(['actions'])
            ->make();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateUserRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::create(array_merge(
                ['password' => Hash::make(Str::random(8))],
                $request->validated()
            ));
            $user->sendPasswordResetNotification(
                Password::createToken($user),
                $signUp = true
            );
            session()->flash('f-success', __('messages.store:success', ['Entity' => __('Partner')]));
            DB::commit();
            return redirect()->route('admin.users.index');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Não foi possível criar a conta do parceiro. ' . $e->getMessage());
            session()->flash('f-error', __('messages.store:error', ['Entity' => __('Partner')]));
            return redirect()->route('admin.users.create');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
