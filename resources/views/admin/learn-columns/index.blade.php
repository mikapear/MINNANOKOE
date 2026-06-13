@extends('layouts.site')

@section('title', 'コラム管理 | '.config('app.name'))

@section('content')
    @include('admin.partials.nav')
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">コラム管理</h1>

        @if(session('status') === 'created')
            <p class="mt-4 rounded-md bg-green-50 p-3 text-sm text-green-800">
                コラムを作成しました。
            </p>
        @endif

        <a href="{{ route('admin.learn-columns.create') }}"
            class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
            新規作成
        </a>
    </div>

    @if(session('status') === 'deleted')
        <p class="mt-4 rounded-md bg-red-50 p-3 text-sm text-red-800">
            削除しました。
        </p>
    @endif

    <ul class="mt-8 space-y-4">
        @foreach($sections as $section)
            <section class="mt-8">
                <h2 class="text-lg font-bold text-gray-900">
                    {{ $section->name }}
                </h2>

                <ul class="mt-4 space-y-3">
                    @forelse($section->columns as $column)
                        <li class="rounded-lg border border-gray-200 bg-white p-4">
                            <div class="flex items-center justify-between gap-3">
                                <div>
                                    <p class="font-semibold text-gray-900">
                                        {{ $column->title }}
                                    </p>

                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ $column->is_published ? '公開中' : '非公開' }}
                                    </p>
                                </div>

                                <a href="{{ route('admin.learn-columns.edit', $column) }}"
                                class="text-sm text-indigo-600 hover:underline">
                                    編集
                                </a>
                            </div>
                        </li>
                    @empty
                        <li class="text-sm text-gray-500">
                            コラムはまだありません。
                        </li>
                    @endforelse
                </ul>
            </section>
        @endforeach
    </ul>
@endsection