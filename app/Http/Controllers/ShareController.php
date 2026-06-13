<?php

namespace App\Http\Controllers;

use App\Enums\PostStatus;
use App\Models\Post;
use App\Models\TagGroup;
use App\Models\Character;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Theme;

class ShareController extends Controller
{
    public function create(Request $request): View|RedirectResponse
    {
        if (! $request->user()->is_active) {
        return redirect()
            ->route('me.posts')
            ->with('error', 'このアカウントでは現在、新規投稿はできません。');
        }
        $tagGroups = TagGroup::with('tags')
            ->orderBy('sort_order')
            ->get();
        $characters = Character::where('type', 'story')
            ->get();
        $themes = Theme::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        $pastThemes = Theme::where('is_active', false)
            ->orderByDesc('updated_at')
            ->get();

        return view('share.create', compact('tagGroups', 'characters', 'themes', 'pastThemes'));
    }

    public function store(Request $request): RedirectResponse
    {   
        if (! $request->user()->is_active) {
            return redirect()
                ->route('me.posts')
                ->with('error', 'このアカウントでは現在、新規投稿はできません。');
        }

        $validated = $request->validate([
            'body' => ['required', 'string', 'min:5', 'max:3000'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['integer', 'exists:tags,id'],
            'action' => ['required', 'in:draft,submit'],
            'character_id' => ['nullable', 'integer', 'exists:characters,id'],
            'theme_id' => ['nullable', 'integer', 'exists:themes,id'],
        ]);

        $status = $validated['action'] === 'draft'
            ? PostStatus::Draft
            : PostStatus::Pending;
        
        $post = Post::query()->create([
            'user_id' => $request->user()->id,
            'character_id' => $validated['character_id'] ?? null,
            'theme_id' => $validated['theme_id'] ?? null,
            'body_original' => $validated['body'],
            'status' => $status,
        ]);

        if (! empty($validated['tag_ids'])) {
            $post->tags()->sync($validated['tag_ids']);
        }

        return redirect()->route('me.posts')->with('status', 'posted');
    }
}
