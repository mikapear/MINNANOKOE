<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::query()
            ->withCount('posts')
            ->latest()
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function stop(User $user): RedirectResponse
    {
        if ($user->is_admin) {
            return back()->with('error', '管理者は停止できません');
        }

        $user->update([
            'is_active' => false,
        ]);

        return back()->with('status', 'user-stopped');
    }

    public function activate(User $user): RedirectResponse
    {
        $user->update([
            'is_active' => true,
        ]);

        return back()->with('status', 'user-activated');
    }
}