<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Theme;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function index()
    {
        $themes = Theme::orderBy('sort_order')->get();

        return view('admin.themes.index', compact('themes'));
    }

    public function create()
    {
        return view('admin.themes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'max:255'],
            'description' => ['nullable'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable'],
        ]);

        Theme::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.themes.index')
            ->with('success', 'テーマを作成しました');
    }

    public function edit(Theme $theme)
    {
        return view('admin.themes.edit', compact('theme'));
    }

    public function update(Request $request, Theme $theme)
    {
        $validated = $request->validate([
            'title' => ['required', 'max:255'],
            'description' => ['nullable'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable'],
        ]);

        $theme->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.themes.index')
            ->with('success', 'テーマを更新しました');
    }

    public function destroy(Theme $theme)
    {
        $theme->delete();

        return redirect()
            ->route('admin.themes.index')
            ->with('success', 'テーマを削除しました');
    }
}