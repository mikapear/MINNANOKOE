<?php

namespace App\Http\Controllers;

use App\Models\LearnColumn;
use App\Models\Post;
use App\Models\Tag;
use App\Models\TagGroup;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Theme;

class StoryController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));
        $sort = $request->query('sort', 'new');
        $themes = Theme::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        $pastThemes = Theme::where('is_active', false)
            ->orderByDesc('updated_at')
            ->get();
        $activeThemeId = $request->query('theme_id');
        $tagIds = collect($request->query('tag_ids', []))
            ->map(fn ($id) => (int) $id)
            ->filter()
            ->values()
            ->all();

        $posts = Post::query()
            ->published()
            ->with(['tags', 'character', 'user', 'theme'])
            ->when($activeThemeId, function ($query) use ($activeThemeId) {
                $query->where('theme_id', $activeThemeId);
            })
            ->when($q !== '', function ($query) use ($q) {
                $like = '%'.addcslashes($q, '%_\\').'%';
                $query->where(function ($qry) use ($like) {
                    $qry->where('body_published', 'like', $like)
                        ->orWhere('summary', 'like', $like);
                });
            })
            ->when(! empty($tagIds), function ($query) use ($tagIds) {
                $query->whereHas('tags', function ($q) use ($tagIds) {
                    $q->whereIn('tags.id', $tagIds);
                });
            })
            
            
            ->when($sort === 'old', fn ($query) => $query->oldest('published_at'))
            ->when($sort === 'likes', fn ($query) => $query->withCount('likes')->orderByDesc('likes_count'))
            ->when(! in_array($sort, ['old', 'likes'], true), fn ($query) => $query->latest('published_at'))
            ->paginate(15)
            ->withQueryString();

        $tagGroups = TagGroup::with('tags')
            ->orderBy('sort_order')
            ->get();

        return view('stories.index', [
            'posts' => $posts,
            'tagGroups' => $tagGroups,
            'searchQuery' => $q,
            'sort' => $sort,
            'pageTitle' => 'みんなの声を読む',
            'tagIds' => $tagIds,
            'themes' => $themes,
            'pastThemes' => $pastThemes,
            'activeThemeId' => $activeThemeId,
        ]);
    }

    public function search(Request $request): RedirectResponse
    {
        return redirect()->route('stories.index', ['q' => $request->query('q')]);
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
            ->with(['tags', 'character', 'user', 'theme'])
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

            'themes' => Theme::where('is_active', true)
                ->orderBy('sort_order')
                ->get(),
            'activeThemeId' => null,
            'sort' => 'new',
            'tagIds' => [],
        ]);
    }

    public function show(string $slug): View
    {
        $post = Post::query()
            ->published()
            ->where('slug', $slug)
            ->with(['tags', 'user', 'character', 'likes', 'theme'])
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
            ->with(['tags', 'user', 'character', 'theme'])
            ->whereHas('tags', fn ($q) => $q->where('tags.id', $tag->id))
            ->latest('published_at')
            ->paginate(15);


        return view('stories.index', [
            'posts' => $posts,
            'tagGroups' => $tagGroups,
            'searchQuery' => '',
            'pageTitle' => $label.' · '.$tag->name,
            'activeTag' => $tag,

            'themes' => Theme::where('is_active', true)
                ->orderBy('sort_order')
                ->get(),
            'activeThemeId' => null,
            'sort' => 'new',
            'tagIds' => [],
        ]);
    }
}
