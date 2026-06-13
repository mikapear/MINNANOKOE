@extends('layouts.site')

@section('title', '管理 | 募集中テーマ')

@section('content')

    @include('admin.partials.nav')
    
    <div class="max-w-5xl mx-auto py-8">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">
                募集中テーマ管理
            </h1>

            <a href="{{ route('admin.themes.create') }}"
               class="px-4 py-2 bg-yellow-400 rounded-lg">
                新規作成
            </a>
        </div>

        @foreach($themes as $theme)
            <div class="bg-white rounded-xl p-4 mb-3 shadow">

                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1">
                        <div class="font-bold">
                            {{ $theme->title }}
                        </div>

                        <div class="text-sm text-gray-500 mt-1">
                            {{ $theme->description }}
                        </div>
                    </div>

                    <div class="flex items-center gap-3 whitespace-nowrap">
                        @if($theme->is_active)
                            <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">
                                募集中
                            </span>
                        @else
                            <span class="text-xs bg-gray-100 text-gray-500 px-2 py-1 rounded-full">
                                停止中
                            </span>
                        @endif

                        <a href="{{ route('admin.themes.edit', $theme) }}"
                           class="text-sm text-blue-600 hover:underline">
                            編集
                        </a>

                        <form method="POST"
                            action="{{ route('admin.themes.destroy', $theme) }}"
                            onsubmit="return confirm('このテーマを削除しますか？');">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="text-sm text-red-600 hover:underline">
                                削除
                            </button>
                        </form>     
                    </div>
                </div>

            </div>
        @endforeach

    </div>
@endsection