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

        <div class="mt-4 space-y-4">

            @foreach($tagGroups as $group)

                <div>

                    <h3 class="mb-2 text-sm font-semibold text-gray-800">
                    {{ $group->name }}
                    </h3>

                    <div class="flex flex-wrap gap-2">

                        @foreach($group->tags as $tag)

                            <a href="{{ route('stories.tag', $tag->slug) }}"
                            class="rounded-md border px-2 py-1 text-xs {{ isset($activeTag) && $activeTag->id === $tag->id ? 'border-indigo-600 bg-indigo-50' : 'border-gray-200 bg-white' }}">

                                #{{ $tag->name }}

                            </a>

                        @endforeach

                    </div>

                </div>

            @endforeach

        </div>
    </div>

    <ul class="mt-8 space-y-4">
        @forelse($posts as $post)
            <li class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">

                <div class="flex items-start gap-3">
                    @if($post->character)
                        <img
                            src="{{ asset($post->character->icon_path) }}"
                            alt="{{ $post->character->name }}"
                            class="mt-1 h-10 w-10 shrink-0"
                        >
                    @endif

                    <div>
                        <a href="{{ route('stories.show', $post->slug) }}"
                            class="font-medium text-indigo-700 hover:underline">

                            {{ \Illuminate\Support\Str::limit(strip_tags($post->body_published), 80) }}

                        </a>
                    </div>
                </div>
                    {{ \Illuminate\Support\Str::limit(strip_tags($post->body_published), 80) }}
                </a>
                <p class="mt-2 text-xs text-gray-500">{{ optional($post->published_at)->timezone(config('app.timezone'))->format('Y/m/d') }}</p>

                @if($post->user)
                    @php
                        $birthDate =$post->user->birth_date
                            ? \Carbon\Carbon::parse($post->user->birth_date)
                            : null;

                        $diagnosedAt = $post->user->diagnosed_at
                            ? \Carbon\Carbon::parse($post->user->diagnosed_at)
                            : null;

                        $currentAge = $birthDate ? $birthDate->age : null;

                        $diagnosedAge = ($birthDate && $diagnosedAt)
                            ? $birthDate->diffInYears($diagnosedAt)
                            : null;
                    @endphp

                    <p class="mt-1 text-xs text-gray-500">

                        @if($currentAge)
                            現在{{ floor($currentAge / 10) * 10 }}代
                        @endif

                        @if($diagnosedAge)
                            ｜診断時{{ floor($diagnosedAge / 10) * 10 }}代
                        @endif

                        @php
                            $treatmentLabels = config('minnanokoe.treatment_types');

                            $treatments = collect((array) $post->user->treatment_types)
                                ->map(fn ($t) => $treatmentLabels[$t] ?? $t)
                                ->implode('・');
                        @endphp

                        @if($post->user->treatment_types)
                            ｜治療: {{ $treatments }}
                        @endif

                    </p>
                @endif

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
