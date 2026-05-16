@extends('layouts.site')

@section('title', '学びカテゴリ編集 | '.config('app.name'))

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">
            学びカテゴリ編集
        </h1>

        <form method="POST"
              action="{{ route('admin.learn-sections.destroy', $learnSection) }}"
              onsubmit="return confirm('削除してよろしいですか？');">

            @csrf
            @method('DELETE')

            <button
                type="submit"
                class="text-sm text-red-600 hover:underline"
            >
                削除
            </button>
        </form>
    </div>

    @if ($errors->any())
        <div class="mt-4 rounded-md bg-red-50 p-4 text-sm text-red-800">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ route('admin.learn-sections.update', $learnSection) }}"
          class="mt-8 space-y-6">

        @csrf
        @method('PATCH')

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">
                カテゴリ名
            </label>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $learnSection->name) }}"
                class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
            >
        </div>

        <div>
            <label for="slug" class="block text-sm font-medium text-gray-700">
                slug
            </label>

            <input
                type="text"
                id="slug"
                name="slug"
                value="{{ old('slug', $learnSection->slug) }}"
                class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
            >
        </div>

        <div>
            <label for="sort_order" class="block text-sm font-medium text-gray-700">
                表示順
            </label>

            <input
                type="number"
                id="sort_order"
                name="sort_order"
                value="{{ old('sort_order', $learnSection->sort_order) }}"
                class="mt-1 w-32 rounded-md border border-gray-300 px-3 py-2 text-sm"
            >
        </div>

        <button
            type="submit"
            class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700"
        >
            更新
        </button>
    </form>
@endsection