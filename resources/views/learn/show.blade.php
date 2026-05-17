@extends('layouts.site')

@section('title', $column->title.' | '.config('app.name'))

@section('content')
    <nav class="text-xs text-gray-500">
        <a href="{{ route('learn.index') }}" class="hover:underline">学んで安心</a>
        <span class="mx-1">/</span>
        <a href="{{ route('learn.section', $section->slug) }}" class="hover:underline">{{ $section->name }}</a>
    </nav>

    <article class="mt-4 rounded-lg bg-white p-6 shadow-sm ring-1 ring-gray-100">

        @if($column->character)
            <div class="flex items-center gap-3">
                <img
                    src="{{ asset($column->character->icon_path) }}"
                    alt="{{ $column->character->name }}"
                    class="h-16 w-16 rounded-full"
                >

                <h1 class="text-2xl font-bold text-gray-900">
                    {{ $column->title }}
                </h1>
            </div>
        @else
            <h1 class="text-2xl font-bold text-gray-900">
                {{ $column->title }}
        </h1>
        @endif

        <x-like-button
            :action="route('learn-columns.like', $column)"
            :count="$column->likes->count()"
            class="mt-4"
        />

        <div class="prose prose-indigo mt-6 max-w-none text-gray-800">
            {!! $column->body !!}
        </div>
        @if($column->tags->isNotEmpty())
            <div class="mt-6 flex flex-wrap gap-2">
                @foreach($column->tags as $t)
                    <a href="{{ route('stories.tag', $t->slug) }}" class="rounded-full bg-gray-100 px-3 py-1 text-xs text-gray-800 hover:bg-gray-200">#{{ $t->name }}</a>
                @endforeach
            </div>
        @endif
    </article>

    @if($relatedPosts->isNotEmpty())
        <section class="mt-10">
            <h2 class="text-lg font-semibold text-gray-900">このテーマに近いみんなの声</h2>
            <ul class="mt-4 space-y-3">
                @foreach($relatedPosts as $post)
                    <li class="rounded-lg border border-gray-200 bg-white p-4">
                        <a href="{{ route('stories.show', $post->slug) }}" class="font-medium text-indigo-700 hover:underline">
                            {{ \Illuminate\Support\Str::limit(strip_tags($post->body_published), 100) }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </section>
    @endif
@endsection
