<?php

namespace App\Http\Controllers;

use App\Enums\PostStatus;
use App\Models\Post;
use App\Models\TagGroup;
use App\Models\Character;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShareController extends Controller
{
    public function create(): View
    {
    $tagGroups = TagGroup::with('tags')
        ->orderBy('sort_order')
        ->get();
    $characters = Character::where('type', 'story')
        ->get();

    return view('share.create', compact('tagGroups', 'characters'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'min:5', 'max:3000'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['integer', 'exists:tags,id'],
            'action' => ['required', 'in:draft,submit'],
            'character_id' => ['nullable', 'integer', 'exists:characters,id'],
        ]);

        $status = $validated['action'] === 'draft'
            ? PostStatus::Draft
            : PostStatus::Pending;
        
        $post = Post::query()->create([
            'user_id' => $request->user()->id,
            'character_id' => $validated['character_id'] ?? null,
            'body_original' => $validated['body'],
            'status' => $status,
        ]);

        if (! empty($validated['tag_ids'])) {
            $post->tags()->sync($validated['tag_ids']);
        }

        return redirect()->route('me.posts')->with('status', 'posted');
    }
}
