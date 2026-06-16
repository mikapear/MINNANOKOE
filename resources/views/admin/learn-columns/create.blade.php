@extends('layouts.site')

@section('title', 'コラム作成 | '.config('app.name'))

@section('content')
    @include('admin.partials.nav')
    <h1 class="text-2xl font-bold text-gray-900">
        コラム作成
    </h1>

    <form method="POST"
        action="{{ route('admin.learn-columns.store') }}"
        class="mt-8 space-y-6">

        @csrf

        @if ($errors->any())
            <div class="rounded-md border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                <p class="font-semibold">入力内容を確認してください。</p>

                <ul class="mt-2 list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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

        <x-character-select
            :characters="$characters"
            :selected-character-id="null"
        />

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
    <div class="mb-3 flex items-center justify-between">
        <div>
            <h2 class="text-sm font-medium text-gray-700">
                本文ブロック
            </h2>
            <p class="mt-1 text-xs text-gray-500">
                サブタイトルと本文を組み合わせて、記事を作成できます。
            </p>
        </div>

        <button
            type="button"
            id="add-block"
            class="rounded-md border border-indigo-200 bg-white px-3 py-2 text-sm font-medium text-indigo-700 hover:bg-indigo-50"
        >
            ＋ ブロックを追加
        </button>
    </div>

    <div id="blocks" class="space-y-4">
        @php
            $oldBlocks = old('blocks', [
                ['subtitle' => '', 'body' => ''],
            ]);
        @endphp

        @foreach($oldBlocks as $index => $block)
            <div class="block-item rounded-lg border border-gray-200 bg-white p-4">
                <div class="mb-3 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-gray-800">
                        ブロック {{ $index + 1 }}
                    </h3>

                    <button
                        type="button"
                        class="remove-block text-sm text-red-600 hover:text-red-800"
                    >
                        削除
                    </button>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        サブタイトル
                    </label>

                    <input
                        type="text"
                        name="blocks[{{ $index }}][subtitle]"
                        value="{{ $block['subtitle'] ?? '' }}"
                        class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                    >
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">
                        本文
                    </label>

                    <textarea
                        name="blocks[{{ $index }}][body]"
                        rows="8"
                        class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                    >{{ $block['body'] ?? '' }}</textarea>
                </div>
            </div>
        @endforeach
    </div>
</div>

        <fieldset>
            <legend class="text-sm font-medium text-gray-700">
                タグ
            </legend>

            @php
                $selected = collect(old('tag_ids', []));
            @endphp

            <div class="mt-4 space-y-5">
                @foreach($tagGroups as $group)
                    <details open class="rounded-lg border border-gray-200 bg-white p-4">
                        <summary class="cursor-pointer text-sm font-semibold text-gray-800">
                        {{ $group->name }}
                    </summary>

                        <div class="mt-3 flex flex-wrap gap-2">
                            @foreach($group->tags as $tag)
                                <x-tag-checkbox
                                    :tag="$tag"
                                    :checked="$selected->contains($tag->id)"
                                />
                            @endforeach
                        </div>
                    </details>
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

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const blocks = document.getElementById('blocks');
        const addButton = document.getElementById('add-block');

        addButton.addEventListener('click', () => {
            const index = blocks.querySelectorAll('.block-item').length;

            const html = `
                <div class="block-item rounded-lg border border-gray-200 bg-white p-4">
                    <div class="mb-3 flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-gray-800">
                            ブロック ${index + 1}
                        </h3>

                        <button
                            type="button"
                            class="remove-block text-sm text-red-600 hover:text-red-800"
                        >
                            削除
                        </button>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            サブタイトル
                        </label>

                        <input
                            type="text"
                            name="blocks[${index}][subtitle]"
                            class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                        >
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">
                            本文
                        </label>

                        <textarea
                            name="blocks[${index}][body]"
                            rows="8"
                            class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
                        ></textarea>
                    </div>
                </div>
            `;

            blocks.insertAdjacentHTML('beforeend', html);
        });

        blocks.addEventListener('click', (event) => {
            if (!event.target.classList.contains('remove-block')) {
                return;
            }

            if (blocks.querySelectorAll('.block-item').length <= 1) {
                alert('ブロックは最低1つ必要です。');
                return;
            }

            event.target.closest('.block-item').remove();
        });
    });
</script>
@endsection