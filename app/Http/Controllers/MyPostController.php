<?php

namespace App\Http\Controllers;

use App\Enums\PostStatus;
use App\Models\Post;
use App\Models\TagGroup;
use App\Models\Character;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;
use App\Models\Theme;

class MyPostController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');
        $posts = Post::query()
            ->where('user_id', $request->user()->id)
            ->with(['tags', 'user', 'likes', 'character', 'theme'])
            
            ->latest()
            ->paginate(20);

        return view('my-posts.index', compact('posts', 'status'));
    }

    private function ensureUserCanEdit(Post $post): void
    {
        $editableStatuses = [
            PostStatus::Draft,
            PostStatus::Suggested,
            PostStatus::Published,
        ];

        abort_unless(
            in_array($post->status, $editableStatuses, true),
            Response::HTTP_FORBIDDEN
        );
    }

    public function edit(Request $request, Post $post): View|RedirectResponse
    {
        if ($post->user_id !== $request->user()->id) {
            abort(403);
        }

        if (! $request->user()->is_active) {
            return redirect()
                ->route('me.posts')
                ->with('error', 'このアカウントでは現在、投稿の編集はできません。');
        }

        $this->ensureUserCanEdit($post);
        $tagGroups = TagGroup::with('tags')
            ->orderBy('sort_order')
            ->get();
        $characters = Character::where('type', 'story')->get();
        $themes = Theme::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        $pastThemes = Theme::where('is_active', false)
            ->orderByDesc('updated_at')
            ->get();

        return view('my-posts.edit', [
            'post' => $post,
            'tagGroups' => $tagGroups,
            'characters' => $characters,
            'themes' => $themes,
            'pastThemes' => $pastThemes,
        ]);
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        if ($post->user_id !== $request->user()->id) {
            abort(403);
        }

        if (! $request->user()->is_active) {
            return redirect()
                ->route('me.posts')
                ->with('error', 'このアカウントでは現在、投稿の編集はできません。');
        }

        $this->ensureUserCanEdit($post);
        $validated = $request->validate([
            'body' => ['required', 'string', 'min:10', 'max:3000'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['integer', 'exists:tags,id'],
            'theme_id' => ['nullable', 'integer', 'exists:themes,id'],
            'action' => ['required', 'in:draft,submit'],
            'character_id' => ['required', 'integer', 'exists:characters,id'],
        ]);
        $status = $validated['action'] === 'draft'
            ? PostStatus::Draft
            : PostStatus::Pending;
        
        $post->update([
            'body_original' => $validated['body'],
            'body_published' => null,
            'summary' => null,
            'status' => $status,
            'published_at' => null,
            'rejection_reason' => null,
            'reviewed_by' => null,
            'reviewed_at' => null,
            'character_id' => $validated['character_id'],
            'theme_id' => $validated['theme_id'] ?? null,
        ]);

        $post->tags()->sync($validated['tag_ids'] ?? []);

        return redirect()->route('me.posts')->with('status', 'updated');
    }
    public function destroy(Request $request, Post $post): RedirectResponse
    {
        if ($post->user_id !== $request->user()->id) {
            abort(403);
            }

        $post->delete();

        return redirect()
            ->route('me.posts')
            ->with('status', 'deleted');
    }

    public function acceptSuggestion(Post $post): RedirectResponse
    {
        if (! auth()->user()->is_active) {
            return redirect()
                ->route('me.posts')
                ->with('error', 'このアカウントでは現在、再投稿はできません。');
        }
        abort_unless($post->user_id === auth()->id(), 403);

        abort_unless($post->status === PostStatus::Suggested, 403);

        $post->update([
            'status' => PostStatus::Pending,
        ]);

        return redirect()
            ->route('me.posts.edit', $post)
            ->with('status', 'resubmitted');
    }

}
