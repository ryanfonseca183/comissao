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

        return Redirect::route('admin.profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::guard('admin')->user();
        abort_if($user->isAdmin, 401);
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);
        Auth::guard('user')->logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
