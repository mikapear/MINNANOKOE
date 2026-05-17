@extends('layouts.site')

@section('title', $section->name.' | '.config('app.name'))

@section('content')
    <h1 class="text-2xl font-bold text-gray-900">{{ $section->name }}</h1>

    <ul class="mt-8 space-y-3">
        @forelse($columns as $column)
            <li>
                <a
                    href="{{ route('learn.show', [$section->slug, $column->slug]) }}"
                    class="block rounded-lg border border-gray-200 bg-white p-4 shadow-sm hover:border-indigo-300"
                >
                    <div class="flex items-center gap-3">
                        @if($column->character)
                            <img
                                src="{{ asset($column->character->icon_path) }}"
                                alt="{{ $column->character->name }}"
                                class="h-12 w-12 rounded-full object-cover"
                            >
                        @endif

                        <span class="font-medium text-indigo-800">
                            {{ $column->title }}
                        </span>
                    </div>
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
