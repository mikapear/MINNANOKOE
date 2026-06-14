@extends('layouts.site')

@section('title', '管理 | テーマ編集')

@section('content')

@include('admin.partials.nav')
<a href="{{ route('admin.themes.index') }}"
   class="inline-flex items-center gap-1 text-sm text-indigo-600 hover:text-indigo-800 mb-4">
    <span>←</span>
    <span>テーマ一覧へ戻る</span>
</a>
     <div class="bg-white rounded-xl shadow p-6">
        <h1 class="text-2xl font-bold mb-6">
            テーマ編集
        </h1>

        <form method="POST" action="{{ route('admin.themes.update', $theme) }}">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label class="block font-medium mb-2">タイトル</label>
                <input
                    type="text"
                    name="title"
                    value="{{ old('title', $theme->title) }}"
                    class="w-full rounded-lg border-stone-300"
                    required
                >
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-2">説明</label>
                <textarea
                    name="description"
                    rows="4"
                    class="w-full rounded-lg border-stone-300"
                >{{ old('description', $theme->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-2">表示順</label>
                <input
                    type="number"
                    name="sort_order"
                    value="{{ old('sort_order', $theme->sort_order) }}"
                    class="w-full rounded-lg border-stone-300"
                >
            </div>

            <label class="flex items-center gap-2 mb-6">
                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    @checked(old('is_active', $theme->is_active))
                >
                <span>募集中にする</span>
            </label>

            <button class="px-5 py-2 bg-yellow-400 hover:bg-yellow-500 rounded-lg font-medium">
                更新
            </button>
        </form>
    </div>
</div>

@endsection