@extends('layouts.site')

@section('title', $pageTitle.' | '.config('app.name'))

@section('content')
    <h1 class="text-2xl font-bold text-gray-900">{{ $pageTitle }}</h1>
    <p class="mt-2 text-sm text-gray-600">項目を選ぶと該当する物語一覧へ進みます。</p>

    <ul class="mt-8 space-y-3">
        @foreach($tags as $tag)
            <li>
                @php
                    $href = match ($groupSlug) {
                        'worry' => route('stories.worry.show', $tag->slug),
                        'age' => route('stories.age.show', $tag->slug),
                        'situation' => route('stories.situation.show', $tag->slug),
                        default => route('stories.tag', $tag->slug),
                    };
                @endphp
                <a href="{{ $href }}" class="block rounded-lg border border-gray-200 bg-white p-4 font-medium text-indigo-800 shadow-sm hover:border-indigo-300">
                    {{ $tag->name }}
                </a>
            </li>
        @endforeach
    </ul>

    <p class="mt-8">
        <a href="{{ route('stories.index') }}" class="text-sm text-indigo-600 hover:underline">一覧へ戻る</a>
    </p>
@endsection
