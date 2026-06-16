@extends('layouts.site')

@section('title', 'コラム編集 | '.config('app.name'))

@section('content')
    @include('admin.partials.nav')
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">
            コラム編集
        </h1>

        @if ($errors->any())
            <div class="mt-4 rounded bg-red-50 p-4 text-sm text-red-800">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('status') === 'updated')
            <p class="mt-4 rounded-md bg-green-50 p-3 text-sm text-green-800">
                更新しました。
            </p>
        @endif

        <form method="POST"
            action="{{ route('admin.learn-columns.destroy', $learnColumn) }}"
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

    <form method="POST"
        action="{{ route('admin.learn-columns.update', $learnColumn) }}"
        class="mt-8 space-y-6">

        @csrf
        @method('PATCH')

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
                    <option
                        value="{{ $section->id }}"
                        @selected(old('learn_section_id', $learnColumn->learn_section_id) == $section->id)
                    >
                        {{ $section->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <x-character-select
            :characters="$characters"
            :selected-character-id="$learnColumn->character_id"
        />

        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">
                タイトル
            </label>

            <input
                type="text"
                id="title"
                name="title"
                value="{{ old('title', $learnColumn->title) }}"
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
                value="{{ old('slug', $learnColumn->slug) }}"
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
                サブタイトルと本文を組み合わせて、記事を編集できます。
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
            $oldBlocks = old('blocks', $learnColumn->blocks->map(fn ($block) => [
                'subtitle' => $block->subtitle,
                'body' => $block->body,
            ])->values()->all());

            if (empty($oldBlocks)) {
                $oldBlocks = [['subtitle' => '', 'body' => $learnColumn->body]];
            }
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
                $selected = collect(old('tag_ids', $learnColumn->tags->pluck('id')->all()));
            @endphp

            <div class="mt-4 space-y-5">
                @foreach($tagGroups as $group)
                    <div class="rounded-lg border border-gray-200 bg-white p-4">
                        <h3 class="mb-3 text-sm font-semibold text-gray-800">
                            {{ $group->name }}
                        </h3>

                        <div class="flex flex-wrap gap-2">
                            @foreach($group->tags as $tag)
                                <x-tag-checkbox
                                    :tag="$tag"
                                    :checked="$selected->contains($tag->id)"
                                />
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </fieldset>

        <label class="inline-flex items-center gap-2">
            <input
                type="checkbox"
                name="is_published"
                value="1"
                @checked(old('is_published', $learnColumn->is_published))
            >
            <span class="text-sm text-gray-700">
                公開する
            </span>
        </label>

        <div>
            <button
                type="submit"
                class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700"
            >
                更新
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