<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('user.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->update($request->validated());

        session()->flash('f-success', 'Informações do perfil atualizadas com sucesso!');

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);
        $user = $request->user();
        Auth::guard('user')->logout();
        try {
            $user->delete();
        } catch (\Exception $e) {
            $user->update([
                'name' => 'Usuário deletado',
                'doc_num' => $user->doc_type == 1 ? 'XX.XXX.XXX/XXXX-XX' : 'XXX.XXX.XXX-XX',
                'email' => 'user@email',
                'password' => 'user@password',
                'phone' => '(XX) XXXXX-XXXX',
            ]);
        }
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
