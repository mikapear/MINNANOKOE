@extends('layouts.site')

@section('title', $section->name.' | '.config('app.name'))

@section('content')
    <h1 class="text-2xl font-bold text-gray-900">{{ $section->name }}</h1>

    <ul class="mt-8 space-y-3">
        @forelse($columns as $column)
            <li>
                <a href="{{ route('learn.show', [$section->slug, $column->slug]) }}" class="block rounded-lg border border-gray-200 bg-white p-4 font-medium text-indigo-800 shadow-sm hover:border-indigo-300">
                    {{ $column->title }}
                </a>
            </li>
        @empty
            <li class="text-gray-600">公開中のコラムはまだありません。</li>
        @endforelse
    </ul>

    <p class="mt-8">
        <a href="{{ route('learn.index') }}" class="text-sm text-indigo-600 hover:underline">一覧へ戻る</a>
    </p>
@endsection
