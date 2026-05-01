@extends('layouts.site')

@section('title', 'みんなの声辞典 | '.config('app.name'))

@section('content')
    <div class="text-center space-y-6">
        <div class="flex justify-center">
            <img src="{{ asset('logo.jpg') }}" alt="ロゴ" class="h-24 w-auto rounded-lg object-contain sm:h-32" width="200" height="200" />
        </div>
        <p class="text-lg text-indigo-900 font-medium">あなたの日常、あなたの声</p>
        <p class="text-sm text-gray-600">プロジェクト <span class="font-semibold">Survivor+</span></p>
    </div>

    <div class="mt-12 grid gap-4 sm:grid-cols-3">
        <a href="{{ route('share.create') }}" class="block rounded-xl border-2 border-indigo-200 bg-white p-6 text-center font-medium text-indigo-800 shadow-sm transition hover:border-indigo-400">
            物語のシェア
        </a>
        <a href="{{ route('stories.index') }}" class="block rounded-xl border-2 border-indigo-200 bg-white p-6 text-center font-medium text-indigo-800 shadow-sm transition hover:border-indigo-400">
            物語を探す
        </a>
        <a href="{{ route('learn.index') }}" class="block rounded-xl border-2 border-indigo-200 bg-white p-6 text-center font-medium text-indigo-800 shadow-sm transition hover:border-indigo-400">
            学んで成長
        </a>
    </div>

    <p class="mt-10 text-center text-xs text-gray-500">
        <a href="{{ route('terms') }}" class="underline">利用規約</a>
        ・
        <a href="{{ route('privacy') }}" class="underline">プライバシー</a>
    </p>
@endsection
