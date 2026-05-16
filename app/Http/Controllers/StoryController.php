<?php

namespace App\Http\Controllers;

use App\Models\LearnColumn;
use App\Models\Post;
use App\Models\Tag;
use App\Models\TagGroup;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));

        $posts = Post::query()
            ->published()
            ->with(['tags', 'user'])
            ->when($q !== '', function ($query) use ($q) {
                $like = '%'.addcslashes($q, '%_\\').'%';
                $query->where(function ($qry) use ($like) {
                    $qry->where('body_published', 'like', $like)
                        ->orWhere('summary', 'like', $like);
                });
            })
            ->latest('published_at')
            ->paginate(15)
            ->withQueryString();

        $tagGroups = TagGroup::with('tags')
            ->orderBy('sort_order')
            ->get();

        return view('stories.index', [
            'posts' => $posts,
            'tagGroups' => $tagGroups,
            'searchQuery' => $q,
            'pageTitle' => '物語を探す',
        ]);
    }

    public function search(Request $request): RedirectResponse
    {
        return redirect()->route('stories.index', ['q' => $request->query('q')]);
    }

    public function byWorryIndex(): View
    {
        $group = TagGroup::query()->where('slug', 'worry')->firstOrFail();

        return view('stories.by-group-index', [
            'pageTitle' => '悩みで選ぶ',
            'tags' => $group->tags,
            'groupSlug' => 'worry',
        ]);
    }

    public function byWorry(string $slug): View
    {
        return $this->postsForGroupSlug('worry', $slug, '悩みで選ぶ');
    }

    public function byAgeIndex(): View
    {
        $group = TagGroup::query()->where('slug', 'age')->firstOrFail();

        return view('stories.by-group-index', [
            'pageTitle' => '年齢で選ぶ',
            'tags' => $group->tags,
            'groupSlug' => 'age',
        ]);
    }

    public function byAge(string $slug): View
    {
        return $this->postsForGroupSlug('age', $slug, '年齢で選ぶ');
    }

    public function bySituationIndex(): View
    {
        $group = TagGroup::query()->where('slug', 'situation')->firstOrFail();

        return view('stories.by-group-index', [
            'pageTitle' => '状況で選ぶ',
            'tags' => $group->tags,
            'groupSlug' => 'situation',
        ]);
    }

    public function bySituation(string $slug): View
    {
        return $this->postsForGroupSlug('situation', $slug, '状況で選ぶ');
    }

    public function byTag(string $slug): View
    {
        $tag = Tag::query()->where('slug', $slug)->firstOrFail();

        $posts = Post::query()
            ->published()
            ->with(['tags', 'user'])
            ->whereHas('tags', fn ($q) => $q->where('tags.id', $tag->id))
            ->latest('published_at')
            ->paginate(15);

        $tagGroups = TagGroup::with('tags')
            ->orderBy('sort_order')
            ->get();

        return view('stories.index', [
            'posts' => $posts,
            'tagGroups' => $tagGroups,
            'searchQuery' => '',
            'pageTitle' => 'タグ: '.$tag->name,
            'activeTag' => $tag,
        ]);
    }

    public function show(string $slug): View
    {
        $post = Post::query()
            ->published()
            ->where('slug', $slug)
            ->with(['tags', 'user'])
            ->firstOrFail();

        $tagIds = $post->tags->pluck('id');

        $relatedColumns = LearnColumn::query()
            ->where('is_published', true)
            ->whereHas('tags', fn ($q) => $q->whereIn('tags.id', $tagIds))
            ->with('section')
            ->get()
            ->unique('id');

        return view('stories.show', [
            'post' => $post,
            'relatedColumns' => $relatedColumns,
        ]);
    }

    protected function postsForGroupSlug(string $groupSlug, string $tagSlug, string $label): View
    {
        $group = TagGroup::query()->where('slug', $groupSlug)->firstOrFail();
        $tag = Tag::query()
            ->where('slug', $tagSlug)
            ->where('tag_group_id', $group->id)
            ->firstOrFail();
        $tagGroups = TagGroup::with('tags')
            ->orderBy('sort_order')
            ->get();

        $posts = Post::query()
            ->published()
            ->with(['tags', 'user'])
            ->whereHas('tags', fn ($q) => $q->where('tags.id', $tag->id))
            ->latest('published_at')
            ->paginate(15);


        return view('stories.index', [
            'posts' => $posts,
            'tagGroups' => $tagGroups,
            'searchQuery' => '',
            'pageTitle' => $label.' · '.$tag->name,
            'activeTag' => $tag,
        ]);
    }
}
