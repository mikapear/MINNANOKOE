@extends('layouts.site')

@section('title', '学んで安心 | '.config('app.name'))

@section('content')
    <h1 class="text-2xl font-bold text-gray-900">学んで安心</h1>
    <div class="mt-5 flex items-end gap-3">
        <img
            src="{{ asset('images/characters/bird-guide.png') }}"
            alt="MINNANOKOEの案内役"
            class="h-20 w-16 shrink-0 object-contain sm:h-24 sm:w-20"
        >

        <div class="relative mb-2 max-w-xl rounded-2xl border border-indigo-100 bg-indigo-50 px-4 py-3 text-indigo-900 shadow-sm">
            <span
                class="absolute -left-2 bottom-5 h-4 w-4 rotate-45 border-b border-l border-indigo-100 bg-indigo-50"
                aria-hidden="true"
            ></span>

            <p class="text-sm font-medium leading-relaxed">
                テーマを選んでコラムを読んでみよう。<br>
                関連するみんなの声も読めるよ。
            </p>
        </div>
    </div>

    <ul class="mt-8 space-y-3">
        @foreach($sections as $section)
            <li>
                <a href="{{ route('learn.section', $section->slug) }}"
                   class="block rounded-lg border border-gray-200 bg-white p-4 font-medium text-indigo-800 shadow-sm hover:border-indigo-300">
                    {{ $section->name }}
                </a>
            </li>
        @endforeach
    </ul>
@endsection