@extends('layouts.site')

@section('title', '物語 | '.config('app.name'))

@section('content')
    <article class="prose prose-indigo max-w-none">
        <div class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-100">

            @if($post->user)
                @php
                    $treatmentLabels = config('minnanokoe.treatment_types');

                    $treatments = collect((array) $post->user->treatment_types)
                        ->map(fn ($t) => $treatmentLabels[$t] ?? $t)
                        ->implode('・');
                @endphp

                <div class="mb-4 border-b border-gray-100 pb-3 text-xs text-gray-500">
                    @if($post->user->birth_date)
                        現在{{ floor(\Carbon\Carbon::parse($post->user->birth_date)->age / 10) * 10 }}代
                    @endif

                    @if($post->user->birth_date && $post->user->diagnosed_at)
                        ｜診断時{{ floor(\Carbon\Carbon::parse($post->user->birth_date)->diffInYears(\Carbon\Carbon::parse($post->user->diagnosed_at)) / 10) * 10 }}代
                    @endif

                    @if($treatments)
                        ｜{{ $treatments }}
                    @endif
                </div>
            @endif

            @if($post->theme)
                <div class="mb-4">
                    <a href="{{ route('stories.index', ['theme_id' => $post->theme->id]) }}"
                       class="inline-flex rounded-full border border-yellow-200 bg-[#fff8df] px-3 py-1 text-xs font-medium text-stone-700 hover:border-yellow-300 hover:bg-yellow-50">
                        {{ $post->theme->title }}
                    </a>
                </div>
            @endif
            
            <div class="flex items-center gap-2">
                @if($post->character)
                    <img
                        src="{{ asset($post->character->icon_path) }}"
                        alt="{{ $post->character->name }}"
                        class="h-10 w-10 shrink-0"
                    >
                @endif

                <div class="text-gray-900">{{ trim($post->body_published) }}</div>
            </div>

            @if($post->medical_disclaimer)
                <div class="mt-4 rounded-lg bg-amber-50 p-3 text-xs leading-relaxed text-amber-800">
                    ※この内容は投稿者個人の体験や意見であり、医療上の助言ではありません。
                </div>
            @endif

            

            @if($post->summary)
                <aside class="mt-6 border-l-4 border-indigo-200 pl-4 text-sm text-gray-700">
                    <p class="font-medium text-indigo-900">医療者からの補足</p>
                    <p class="mt-1">{{ $post->summary }}</p>
                </aside>
            @endif
            @if($post->tags->isNotEmpty())
                <div class="mt-6 flex flex-wrap gap-2">
                    @foreach($post->tags as $t)
                        <a href="{{ route('stories.tag', $t->slug) }}" class="rounded-full bg-gray-100 px-3 py-1 text-xs text-gray-800 hover:bg-gray-200">#{{ $t->name }}</a>
                    @endforeach
                </div>
            @endif
            <x-like-button
                :action="route('posts.like', $post)"
                :count="$post->likes->count()"
            />
            
        </div>
    </article>

    @if($relatedColumns->isNotEmpty())
        <section class="mt-10" x-data="{ openId: null }">
            <h2 class="text-lg font-semibold text-gray-900">関連コラム</h2>
            <ul class="mt-4 space-y-2">
                @foreach($relatedColumns as $col)
                    <li class="rounded-lg border border-gray-200 bg-white">
                        <button type="button"
                            class="flex w-full items-center justify-between px-4 py-3 text-left font-medium text-indigo-800"
                            @click="openId = openId === {{ $col->id }} ? null : {{ $col->id }}">
                            {{ $col->title }}
                            <span class="text-gray-400" x-text="openId === {{ $col->id }} ? '−' : '+'"></span>
                        </button>
                        <div x-show="openId === {{ $col->id }}" x-cloak class="border-t border-gray-100 px-4 py-3 text-sm text-gray-700">
                            {!! $col->body !!}
                        </div>
                    </li>
                @endforeach
            </ul>
        </section>
    @endif

    <p class="mt-8 text-sm">
        <a href="{{ route('stories.index') }}" class="text-indigo-600 hover:underline">物語一覧へ</a>
    </p>
@endsection
