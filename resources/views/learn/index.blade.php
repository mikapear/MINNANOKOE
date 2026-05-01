@extends('layouts.site')

@section('title', '学んで成長 | '.config('app.name'))

@section('content')
    <h1 class="text-2xl font-bold text-gray-900">学んで成長</h1>
    <p class="mt-2 text-sm text-gray-600">テーマを選んでコラムを読み、関連するみんなの声にも進めます。</p>

    <ul class="mt-8 space-y-3">
        @foreach($sections as $section)
            <li>
                <a href="{{ route('learn.section', $section->slug) }}" class="block rounded-lg border border-gray-200 bg-white p-4 font-medium text-indigo-800 shadow-sm hover:border-indigo-300">
                    {{ $section->name }}
                </a>
            </li>
        @endforeach
    </ul>
@endsection
