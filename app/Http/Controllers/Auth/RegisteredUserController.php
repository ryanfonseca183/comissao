<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function person(): View
    {
        session(['doc_type' => 0]);

        return view('auth.register');
    }

    /**
     * Display the registration view.
     */
    public function corporate(): View
    {
        session(['doc_type' => 1]);

        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $doc_type = session()->get('doc_type', 0);
        $validated = $request->validate([
            'name' => 'string|max:255',
            'phone' => 'string|min:14|max:15',
            'doc_num' => ['string', ($doc_type == 0 ? 'cpf' : 'cnpj'), 'unique:users'],
            'email' => 'email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $user = new User($validated);
        $user->password = Hash::make($request->password);
        $user->doc_type = $doc_type;
        $user->save();
        event(new Registered($user));
        Auth::guard('user')->login($user);
        session()->forget('doc_type');
        return redirect(RouteServiceProvider::HOME);
    }
}
