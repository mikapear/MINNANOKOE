@extends('layouts.site')

@section('title', 'コラム作成 | '.config('app.name'))

@section('content')
    <h1 class="text-2xl font-bold text-gray-900">
        コラム作成
    </h1>

    <form method="POST"
        action="{{ route('admin.learn-columns.store') }}"
        class="mt-8 space-y-6">

        @csrf

        <div>
            <label for="learn_section_id" class="block text-sm font-medium text-gray-700">
                カテゴリ
            </label>

            <select
                id="learn_section_id"
                name="learn_section_id"
                class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
            >
                @foreach($sections as $section)
                    <option value="{{ $section->id }}">
                        {{ $section->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">
                タイトル
            </label>

            <input
                type="text"
                id="title"
                name="title"
                value="{{ old('title') }}"
                class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
            >
        </div>

        <div>
            <label for="slug" class="block text-sm font-medium text-gray-700">
                slug（任意）
            </label>

            <input
                type="text"
                id="slug"
                name="slug"
                value="{{ old('slug') }}"
                class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
            >
        </div>

        <div>
            <label for="body" class="block text-sm font-medium text-gray-700">
                本文
            </label>

            <textarea
                id="body"
                name="body"
                rows="16"
                class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
            >{{ old('body') }}</textarea>
        </div>

        <fieldset>
            <legend class="text-sm font-medium text-gray-700">
                タグ
            </legend>

            <div class="mt-4 space-y-5">
                @foreach($tagGroups as $group)
                    <div class="rounded-lg border border-gray-200 bg-white p-4">
                        <h3 class="mb-3 text-sm font-semibold text-gray-800">
                            {{ $group->name }}
                        </h3>

                        <div class="flex flex-wrap gap-2">
                            @foreach($group->tags as $tag)
                                <label class="inline-flex items-center gap-2 rounded-full border border-gray-300 px-3 py-1.5 text-sm">
                                    <input
                                        type="checkbox"
                                        name="tag_ids[]"
                                        value="{{ $tag->id }}"
                                    >
                                    <span>#{{ $tag->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </fieldset>

        <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="is_published" value="1">
            <span class="text-sm text-gray-700">公開する</span>
        </label>

        <div>
            <button
                type="submit"
                class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700"
            >
                保存
            </button>
        </div>
    </form>
@endsection