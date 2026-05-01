<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(): RedirectResponse
    {
        $googleUser = Socialite::driver('google')->user();

        $account = SocialAccount::query()->where('provider', 'google')
            ->where('provider_user_id', $googleUser->getId())
            ->first();

        if ($account) {
            Auth::login($account->user, true);

            return $this->afterLogin($account->user);
        }

        $user = User::query()->where('email', $googleUser->getEmail())->first();

        if ($user) {
            $user->socialAccounts()->create([
                'provider' => 'google',
                'provider_user_id' => $googleUser->getId(),
            ]);
            Auth::login($user, true);

            return $this->afterLogin($user);
        }

        $user = User::query()->create([
            'name' => $googleUser->getName() ?: 'ユーザー',
            'email' => $googleUser->getEmail(),
            'password' => null,
            'email_verified_at' => now(),
        ]);

        $user->socialAccounts()->create([
            'provider' => 'google',
            'provider_user_id' => $googleUser->getId(),
        ]);

        Auth::login($user, true);

        return $this->afterLogin($user);
    }

    protected function afterLogin(User $user): RedirectResponse
    {
        if ($user->birth_date === null || $user->diagnosed_at === null
            || $user->treatment_types === null || $user->privacy_consented_at === null) {
            return redirect()
                ->route('profile.edit')
                ->with('status', 'complete-profile');
        }

        return redirect()->intended(route('home', absolute: false));
    }
}
