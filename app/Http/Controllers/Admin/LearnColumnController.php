<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LearnColumn;
use App\Models\LearnSection;
use App\Models\TagGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Character;

class LearnColumnController extends Controller
{
    public function index(): View
    {
        $sections = LearnSection::query()
            ->with(['columns' => function ($query) {
                $query->latest();
            }])
            ->orderBy('sort_order')
            ->get();

        return view('admin.learn-columns.index', compact('sections'));
    }

    public function create(): View
    {
        $sections = LearnSection::orderBy('sort_order')->get();
        $tagGroups = TagGroup::with('tags')->orderBy('sort_order')->get();
        $characters = Character::query()
            ->orderBy('id')
            ->get();

        return view('admin.learn-columns.create', compact('sections', 'tagGroups', 'characters'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'learn_section_id' => ['required', 'integer', 'exists:learn_sections,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:learn_columns,slug'],
            'body' => ['required', 'string'],
            'is_published' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['integer', 'exists:tags,id'],
            'character_id' => ['nullable', 'integer', 'exists:characters,id'],
        ]);

        $column = LearnColumn::create([
            'learn_section_id' => $validated['learn_section_id'],
            'title' => $validated['title'],
            'slug' => $validated['slug'] ?: 'column-' . uniqid(),
            'body' => $validated['body'],
            'character_id' => $validated['character_id'] ?? null,
            'is_published' => $request->boolean('is_published'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        $column->tags()->sync($validated['tag_ids'] ?? []);

        return redirect()
            ->route('admin.learn-columns.index')
            ->with('status', 'created');
    }

    public function edit(LearnColumn $learnColumn): View
    {
        $sections = LearnSection::orderBy('sort_order')->get();
        $tagGroups = TagGroup::with('tags')->orderBy('sort_order')->get();
        $characters = Character::query()
            ->orderBy('id')
            ->get();

        return view('admin.learn-columns.edit', compact('learnColumn', 'sections', 'tagGroups', 'characters'));
    }

    public function update(Request $request, LearnColumn $learnColumn): RedirectResponse
    {
        $validated = $request->validate([
            'learn_section_id' => ['required', 'integer', 'exists:learn_sections,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:learn_columns,slug,' . $learnColumn->id],
            'body' => ['required', 'string'],
            'is_published' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['integer', 'exists:tags,id'],
            'character_id' => ['nullable', 'integer', 'exists:characters,id'],
        ]);

        $learnColumn->update([
            'learn_section_id' => $validated['learn_section_id'],
            'title' => $validated['title'],
            'slug' => $validated['slug'] ?: $learnColumn->slug,
            'body' => $validated['body'],
            'character_id' => $validated['character_id'] ?? null,
            'is_published' => $request->boolean('is_published'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        $learnColumn->tags()->sync($validated['tag_ids'] ?? []);

        return redirect()
            ->route('admin.learn-columns.edit', $learnColumn)
            ->with('status', 'updated');
    }

    public function destroy(LearnColumn $learnColumn): RedirectResponse
    {
        $learnColumn->delete();

        return redirect()
            ->route('admin.learn-columns.index')
            ->with('status', 'deleted');
    }
}