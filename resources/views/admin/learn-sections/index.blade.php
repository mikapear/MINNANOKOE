@extends('layouts.site')

@section('title', '学びカテゴリ管理 | '.config('app.name'))

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">学びカテゴリ管理</h1>

        <a href="{{ route('admin.learn-sections.create') }}"
           class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
            新規作成
        </a>
    </div>

    @if(session('status') === 'created')
        <p class="mt-4 rounded-md bg-green-50 p-3 text-sm text-green-800">作成しました。</p>
    @endif

    @if(session('status') === 'updated')
        <p class="mt-4 rounded-md bg-green-50 p-3 text-sm text-green-800">更新しました。</p>
    @endif

    @if(session('status') === 'deleted')
        <p class="mt-4 rounded-md bg-red-50 p-3 text-sm text-red-800">削除しました。</p>
    @endif

    <ul class="mt-8 space-y-3">
        @foreach($sections as $section)
            <li class="rounded-lg border border-gray-200 bg-white p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-semibold text-gray-900">{{ $section->name }}</p>
                        <p class="mt-1 text-xs text-gray-500">
                            slug: {{ $section->slug }} ／ 表示順: {{ $section->sort_order }}
                        </p>
                    </div>

                    <a href="{{ route('admin.learn-sections.edit', $section) }}"
                       class="text-sm text-indigo-600 hover:underline">
                        編集
                    </a>
                </div>
            </li>
        @endforeach
    </ul>
@endsection