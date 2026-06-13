@extends('layouts.site')

@section('title', 'タグ管理 | '.config('app.name'))

@section('content')
    @include('admin.partials.nav')
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">タグ管理</h1>

        <a href="{{ route('admin.tags.create') }}"
           class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
            新規作成
        </a>
    </div>

    @if(session('status') === 'created')
        <p class="mt-4 rounded-md bg-green-50 p-3 text-sm text-green-800">タグを作成しました。</p>
    @endif

    @if(session('status') === 'updated')
        <p class="mt-4 rounded-md bg-green-50 p-3 text-sm text-green-800">タグを更新しました。</p>
    @endif

    @if(session('status') === 'deleted')
        <p class="mt-4 rounded-md bg-red-50 p-3 text-sm text-red-800">タグを削除しました。</p>
    @endif

    @foreach($tagGroups as $group)
        <section class="mt-8">
            <h2 class="text-lg font-bold text-gray-900">{{ $group->name }}</h2>

            <ul class="mt-4 space-y-3">
                @forelse($group->tags as $tag)
                    <li class="rounded-lg border border-gray-200 bg-white p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-semibold text-gray-900">
                                    #{{ $tag->name }}
                                </p>
                                <p class="mt-1 text-xs text-gray-500">
                                    表示順: {{ $tag->sort_order }}
                                </p>
                            </div>

                            <a href="{{ route('admin.tags.edit', $tag) }}"
                               class="text-sm text-indigo-600 hover:underline">
                                編集
                            </a>
                        </div>
                    </li>
                @empty
                    <li class="text-sm text-gray-500">タグはまだありません。</li>
                @endforelse
            </ul>
        </section>
    @endforeach
@endsection