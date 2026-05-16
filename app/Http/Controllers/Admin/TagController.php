<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\TagGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TagController extends Controller
{
    public function index(): View
    {
        $tagGroups = TagGroup::query()
            ->with(['tags' => fn ($query) => $query->orderBy('sort_order')])
            ->orderBy('sort_order')
            ->get();

        return view('admin.tags.index', compact('tagGroups'));
    }

    public function create(): View
    {
        $tagGroups = TagGroup::query()
            ->orderBy('sort_order')
            ->get();

        return view('admin.tags.create', compact('tagGroups'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tag_group_id' => ['required', 'integer', 'exists:tag_groups,id'],
            'name' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        Tag::create([
            'tag_group_id' => $validated['tag_group_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']) ?: 'tag-' . uniqid(),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()
            ->route('admin.tags.index')
            ->with('status', 'created');
    }

    public function edit(Tag $tag): View
    {
        $tagGroups = TagGroup::query()
            ->orderBy('sort_order')
            ->get();

        return view('admin.tags.edit', compact('tag', 'tagGroups'));
    }

    public function update(Request $request, Tag $tag): RedirectResponse
    {
        $validated = $request->validate([
            'tag_group_id' => ['required', 'integer', 'exists:tag_groups,id'],
            'name' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $tag->update([
            'tag_group_id' => $validated['tag_group_id'],
            'name' => $validated['name'],
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()
            ->route('admin.tags.index')
            ->with('status', 'updated');
    }

    public function destroy(Tag $tag): RedirectResponse
    {
        $tag->delete();

        return redirect()
            ->route('admin.tags.index')
            ->with('status', 'deleted');
    }
}