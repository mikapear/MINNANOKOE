<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\TagGroup;
use App\Models\Theme;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');

        $posts = Post::query()
            ->with(['user', 'tags', 'theme', 'character'])
            ->when($status, fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(25)
            ->withQueryString();

        return view('admin.posts.index', compact('posts', 'status'));
    }

    public function edit(Post $post): View
    {
        $post->load(['theme', 'tags', 'user', 'character']);
        $tagGroups = TagGroup::with('tags')
            ->orderBy('sort_order')
            ->get();
        $themes = Theme::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        $pastThemes = Theme::where('is_active', false)
            ->orderByDesc('updated_at')
            ->get();

        return view('admin.posts.edit', compact('post', 'tagGroups', 'themes', 'pastThemes'));
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $action = $request->input('action', 'save');

        if ($action === 'publish') {
            return $this->handlePublish($request, $post);
        }

        if ($action === 'suggest') {
            return $this->suggest($request, $post);
        }

        $validated = $request->validate([
            'body_published' => ['nullable', 'string', 'max:3000'],
            'medical_disclaimer' => ['nullable', 'boolean'],
            'summary' => ['nullable', 'string', 'max:1000'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['integer', 'exists:tags,id'],
            'theme_id' => ['nullable', 'integer', 'exists:themes,id'],
        ]);

        $post->update([
            'body_published' => $validated['body_published'],
            'summary' => $validated['summary'] ?? null,
            'medical_disclaimer' => $request->boolean('medical_disclaimer'),
            'theme_id' => $request->has('theme_id')
                ? ($validated['theme_id'] ?? null)
                : $post->theme_id,
        ]);
        $post->tags()->sync($validated['tag_ids'] ?? []);

        return redirect()->route('admin.posts.edit', $post)->with('status', 'saved');
    }

    public function suggest(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'body_published' => ['required', 'string', 'min:1', 'max:3000'],
            'summary' => ['nullable', 'string', 'max:1000'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['integer', 'exists:tags,id'],
            'admin_comment' => ['nullable', 'string', 'max:2000'],
            'medical_disclaimer' => ['nullable', 'boolean'],
            'theme_id' => ['nullable', 'integer', 'exists:themes,id'],
        ]);

        if ($post->status !== PostStatus::Suggested) {
            $post->increment('review_count');
        }

        $post->update([
            'body_published' => $validated['body_published'],
            'summary' => $validated['summary'] ?? null,
            'status' => PostStatus::Suggested,
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
            'rejection_reason' => $validated['admin_comment'] ?? null,
            'medical_disclaimer' => $request->boolean('medical_disclaimer'),
            'theme_id' => $request->has('theme_id')
                ? ($validated['theme_id'] ?? null)
                : $post->theme_id,
        ]);

        $post->tags()->sync($validated['tag_ids'] ?? []);

        return redirect()
            ->route('admin.posts.index')
            ->with('status', 'suggested');
    }

    protected function handlePublish(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'body_published' => ['required', 'string', 'min:1', 'max:3000'],
            'summary' => ['nullable', 'string', 'max:1000'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['integer', 'exists:tags,id'],
            'medical_disclaimer' => ['nullable', 'boolean'],
            'theme_id' => ['nullable', 'integer', 'exists:themes,id'],
    ]);
        $body = $validated['body_published'];
        $slug = $post->slug ?? Post::makeUniqueSlug($body, $post->id);

        $post->update([
            'body_published' => $body,
            'summary' => $validated['summary'] ?? null,
            'slug' => $slug,
            'status' => PostStatus::Published,
            'published_at' => $post->published_at ?? now(),
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
            'rejection_reason' => null,
            'medical_disclaimer' => $request->boolean('medical_disclaimer'),
            'theme_id' => $validated['theme_id'] ?? null
                ? ($validated['theme_id'] ?? null)
                : $post->theme_id,
        ]);
        $post->tags()->sync($validated['tag_ids'] ?? []);

        return redirect()->route('admin.posts.edit', $post)->with('status', 'published');
    }

    public function unpublish(Request $request, Post $post): RedirectResponse
    {
        $post->update([
            'status' => PostStatus::Hidden,
        ]);

        return redirect()->route('admin.posts.edit', $post)->with('status', 'unpublished');
    }

    public function reject(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:2000'],
        ]);

        $post->update([
            'status' => PostStatus::Rejected,
            'rejection_reason' => $validated['rejection_reason'],
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
        ]);

        return redirect()->route('admin.posts.index')->with('status', 'rejected');
    }
}
