@extends('layouts.site')

@section('title', ($pageTitle ?? '物語を探す').' | '.config('app.name'))

@section('content')
    <h1 class="text-2xl font-bold text-gray-900">{{ $pageTitle ?? '物語を探す' }}</h1>

    <form method="get" action="{{ route('stories.index') }}" class="mt-6 flex flex-col gap-2 sm:flex-row">
        <input type="search" name="q" value="{{ $searchQuery ?? '' }}" placeholder="キーワードで検索"
            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
        <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">検索</button>
    </form>

    <div class="mt-6 flex flex-wrap gap-2 text-sm">
        <a href="{{ route('stories.worry.index') }}" class="rounded-full bg-amber-100 px-3 py-1 text-amber-900">悩みで選ぶ</a>
        <a href="{{ route('stories.age.index') }}" class="rounded-full bg-amber-100 px-3 py-1 text-amber-900">年齢で選ぶ</a>
        <a href="{{ route('stories.situation.index') }}" class="rounded-full bg-amber-100 px-3 py-1 text-amber-900">状況で選ぶ</a>
    </div>

    <div class="mt-4">
        <p class="text-sm text-gray-600">タグで絞り込み</p>
        <div class="mt-2 flex flex-wrap gap-2">
            @foreach($tags as $tag)
                <a href="{{ route('stories.tag', $tag->slug) }}"
                    class="rounded-md border px-2 py-1 text-xs {{ isset($activeTag) && $activeTag->id === $tag->id ? 'border-indigo-600 bg-indigo-50' : 'border-gray-200 bg-white' }}">
                    #{{ $tag->name }}
                </a>
            @endforeach
        </div>
    </div>

    <ul class="mt-8 space-y-4">
        @forelse($posts as $post)
            <li class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                <a href="{{ route('stories.show', $post->slug) }}" class="font-medium text-indigo-700 hover:underline">
                    {{ \Illuminate\Support\Str::limit(strip_tags($post->body_published), 80) }}
                </a>
                <p class="mt-2 text-xs text-gray-500">{{ optional($post->published_at)->timezone(config('app.timezone'))->format('Y/m/d') }}</p>
                @if($post->tags->isNotEmpty())
                    <div class="mt-2 flex flex-wrap gap-1">
                        @foreach($post->tags as $t)
                            <span class="rounded bg-gray-100 px-2 py-0.5 text-xs text-gray-700">#{{ $t->name }}</span>
                        @endforeach
                    </div>
                @endif
            </li>
        @empty
            <li class="text-gray-600">該当する物語がまだありません。</li>
        @endforelse
    </ul>

    <div class="mt-6">{{ $posts->links() }}</div>
@endsection
