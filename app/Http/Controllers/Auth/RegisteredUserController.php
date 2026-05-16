<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'birth_year' => ['required', 'integer', 'min:1920', 'max:'.date('Y')],
            'birth_month' => ['required', 'integer', 'min:1', 'max:12'],
            'diagnosed_year' => ['required', 'integer', 'min:1980', 'max:'.date('Y')],
            'diagnosed_month' => ['required', 'integer', 'min:1', 'max:12'],
            'treatment_types.*' => ['string'],
            'privacy' => ['accepted'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'birth_date' => $request->birth_year . '-' . str_pad($request->birth_month, 2, '0', STR_PAD_LEFT) . '-01',
            'diagnosed_at' => $request->diagnosed_year . '-' . str_pad($request->diagnosed_month, 2, '0', STR_PAD_LEFT) . '-01',
            'treatment_types' => $request->treatment_types,
            'privacy_consented_at' => now(),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('home', absolute: false));
    }
}
