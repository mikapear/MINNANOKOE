<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LearnSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LearnSectionController extends Controller
{
    public function index(): View
    {
        $sections = LearnSection::query()
            ->orderBy('sort_order')
            ->get();

        return view('admin.learn-sections.index', compact('sections'));
    }

    public function create(): View
    {
        return view('admin.learn-sections.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:learn_sections,slug'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        LearnSection::create([
            'name' => $validated['name'],
            'slug' => $validated['slug']?: Str::slug($validated['name'])?: 'section-' . uniqid(),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()
            ->route('admin.learn-sections.index')
            ->with('status', 'created');
    }

    public function edit(LearnSection $learnSection): View
    {
        return view('admin.learn-sections.edit', compact('learnSection'));
    }

    public function update(Request $request, LearnSection $learnSection): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:learn_sections,slug,' . $learnSection->id],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $learnSection->update([
            'name' => $validated['name'],
            'slug' => $validated['slug'] ?: $learnSection->slug,
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()
            ->route('admin.learn-sections.index')
            ->with('status', 'updated');
    }

    public function destroy(LearnSection $learnSection): RedirectResponse
    {
        $learnSection->delete();

        return redirect()
            ->route('admin.learn-sections.index')
            ->with('status', 'deleted');
    }
}