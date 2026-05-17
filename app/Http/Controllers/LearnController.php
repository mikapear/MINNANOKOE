<?php

namespace App\Http\Controllers;

use App\Models\LearnColumn;
use App\Models\LearnSection;
use App\Models\Post;
use Illuminate\View\View;

class LearnController extends Controller
{
    public function index(): View
    {
        $sections = LearnSection::query()->orderBy('sort_order')->get();

        return view('learn.index', compact('sections'));
    }

    public function section(string $sectionSlug): View
    {
        $section = LearnSection::query()->where('slug', $sectionSlug)->firstOrFail();
        $columns = $section->columns()->where('is_published', true)->orderBy('sort_order')->get();

        return view('learn.section', compact('section', 'columns'));
    }

    public function show(string $sectionSlug, string $columnSlug): View
    {
        $section = LearnSection::query()->where('slug', $sectionSlug)->firstOrFail();
        $column = LearnColumn::query()
            ->where('learn_section_id', $section->id)
            ->where('slug', $columnSlug)
            ->where('is_published', true)
            ->with(['section', 'tags','character','likes'])
            ->firstOrFail();

        $tagIds = $column->tags->pluck('id');

        $relatedPosts = Post::query()
            ->published()
            ->with('tags')
            ->whereHas('tags', fn ($q) => $q->whereIn('tags.id', $tagIds))
            ->latest('published_at')
            ->limit(12)
            ->get();

        return view('learn.show', compact('section', 'column', 'relatedPosts'));
    }
}
