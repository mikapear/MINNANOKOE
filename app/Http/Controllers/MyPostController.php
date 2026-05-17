<?php

namespace App\Http\Controllers;

use App\Enums\PostStatus;
use App\Models\Post;
use App\Models\TagGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;

class MyPostController extends Controller
{
    public function index(Request $request): View
    {
        $posts = Post::query()
            ->where('user_id', $request->user()->id)
            ->with(['tags', 'user', 'likes'])
            ->latest()
            ->paginate(20);

        return view('my-posts.index', compact('posts'));
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

    public function edit(Request $request, Post $post): View
    {
        if ($post->user_id !== $request->user()->id) {
            abort(403);
        }
        $this->ensureUserCanEdit($post);
        $tagGroups = TagGroup::with('tags')
            ->orderBy('sort_order')
            ->get();

        return view('my-posts.edit', [
            'post' => $post,
            'tagGroups' => $tagGroups,
        ]);
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        if ($post->user_id !== $request->user()->id) {
            abort(403);
        }

        $this->ensureUserCanEdit($post);
        $validated = $request->validate([
            'body' => ['required', 'string', 'min:10', 'max:3000'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['integer', 'exists:tags,id'],
            'action' => ['required', 'in:draft,submit'],
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
