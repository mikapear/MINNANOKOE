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
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $user = $request->user();

        $birthDate = $user->birth_date;

        if (! empty($data['birth_year']) && ! empty($data['birth_month'])) {
            $birthDate = $data['birth_year'].'-'.str_pad($data['birth_month'], 2, '0', STR_PAD_LEFT).'-01';
        }

        $diagnosedAt = $user->diagnosed_at;

        if (! empty($data['diagnosed_year']) && ! empty($data['diagnosed_month'])) {
            $diagnosedAt = $data['diagnosed_year'].'-'.str_pad($data['diagnosed_month'], 2, '0', STR_PAD_LEFT).'-01';
        }

        $user->fill([
            'name' => $data['name'],
            'email' => $data['email'],
            'birth_date' => $birthDate,
            'diagnosed_at' => $diagnosedAt,
            'roles' => array_values($data['roles'] ?? []),
            'treatment_status' => $data['treatment_status'] ?? null,
            'treatment_types' => array_values($data['treatment_types'] ?? []),
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->password) {
            $request->validateWithBag('userDeletion', [
                'password' => ['required', 'current_password'],
            ]);
        } else {
            $request->validateWithBag('userDeletion', [
                'confirm_delete' => ['required', 'in:削除する'],
            ]);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
