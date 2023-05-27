<?php

namespace App\Http\Controllers;

use App\Http\Requests\OperatorProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class OperatorProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('admin.profile.edit', [
            'user' => Auth::guard('admin')->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(OperatorProfileUpdateRequest $request): RedirectResponse
    {
        Auth::guard('admin')->user()->update($request->validated());

        session()->flash('f-success', 'Informações do perfil atualizadas com sucesso!');

        return Redirect::route('admin.profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $operator = Auth::guard('admin')->user();
        abort_if($operator->isAdmin, 401);
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);
        Auth::guard('user')->logout();
        try {
            $operator->delete();
        } catch (\Exception $e) {
            $operator->update([
                'name' => 'Operador deletado',
                'email' => 'operator@email',
                'password' => 'operator@password',
                'phone' => '(XX) XXXXX-XXXX',
            ]);
        }
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
