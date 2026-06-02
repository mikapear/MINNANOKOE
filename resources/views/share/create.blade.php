@extends('layouts.site')

@section('title', '物語のシェア | '.config('app.name'))

@section('content')
    <h1 class="text-2xl font-bold text-gray-900">物語のシェア</h1>
    
    <div class="mt-5 rounded-2xl border border-indigo-100 bg-indigo-50/70 p-4 text-indigo-900">
        <p class="text-sm font-semibold">
            何を書いてもいいです。たとえば、
            <span class="text-sm font-semibold">
                治療中の気持ち、不安、助けられた言葉、日々の工夫、今だから思うこと。
            </span>
        </p>

        <p class="mt-2 text-xs leading-relaxed text-indigo-800">
            きれいにまとめなくても大丈夫です。あなたの言葉が、次の誰かの支えになるかもしれません。
        </p>
    </div>

    <form method="post" action="{{ route('share.store') }}" class="mt-8 space-y-6">
        @csrf
        <div>
            <label for="body" class="block text-sm font-medium text-gray-700">あなたの体験・工夫・いま思うこと</label>

            <div class="story-magic-box mt-1">
                <textarea id="body" name="body" rows="12" required
                    class="story-textarea"
                    placeholder="ここに、あなたの物語を書いてください">{{ old('body') }}</textarea>

            </div>
            <div class="mt-1 text-right text-xs text-gray-500">
                <span id="char-count">0</span> / 3000文字
            </div>
            <x-input-error :messages="$errors->get('body')" class="mt-2" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">
                今の気持ちに近い鳥を選んでください
            </label>

            <div class="mt-3 flex flex-wrap gap-4">
                @foreach ($characters as $character)
                    <label class="cursor-pointer">
                        <input
                            type="radio"
                            name="character_id"
                            value="{{ $character->id }}"
                            class="mb-2"
                            @checked(old('character_id') == $character->id)
                        >

                        <div class="rounded-2xl border border-gray-200 bg-white p-3 text-center shadow-sm transition hover:bg-yellow-50 peer-checked:border-yellow-300 peer-checked:bg-yellow-50 peer-checked:ring-2 peer-checked:ring-yellow-200">
                            <img
                                src="{{ asset($character->icon_path) }}"
                                alt="{{ $character->name }}"
                                class="mx-auto h-16 w-16"
                            >

                            <div class="mt-2 text-sm text-gray-700">
                                {{ $character->name }}
                            </div>
                        </div>
                    </label>
                @endforeach
            </div>

            <x-input-error :messages="$errors->get('character_id')" class="mt-2" />
        </div>

        <fieldset>
            <legend class="text-sm font-medium text-gray-700">
                タグ（任意・複数選択）
            </legend>

            @php
                $selected = collect(old('tag_ids', []));
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

        <p class="mt-2 text-sm text-gray-600">
            ※投稿は管理者の確認後に公開されます。個人が特定される情報は書かないでください。
        </p>

        <div class="flex gap-3">
            <button
                type="submit"
                name="action"
                value="draft"
                class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
                下書き保存
            </button>

            <button
                type="submit"
                name="action"
                value="submit"
                class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700"
            >
                シェアする
            </button>
        </div>
    </form>
<script>
    const textarea = document.getElementById('body');
    const charCount = document.getElementById('char-count');

    let glowTimer;

    textarea.addEventListener('input', function () {

        charCount.textContent = textarea.value.length;

        textarea.classList.add('typing-glow');

        clearTimeout(glowTimer);

        glowTimer = setTimeout(function () {
            textarea.classList.remove('typing-glow');
        }, 400);
    });

    charCount.textContent = textarea.value.length;
</script>

<style>
    .story-textarea:focus {
        outline: none !important;
        box-shadow:
            0 0 18px rgba(255, 220, 120, 0.45),
            0 0 48px rgba(255, 245, 200, 0.28) !important;
    }
    .story-textarea {
        width: 100%;
        min-height: 320px;
        padding: 24px;

        border: none;
        border-radius: 20px;

        resize: vertical;
        outline: none;

        font-size: 15px;
        line-height: 1.9em;

        color: #4b3b2a;

        background: rgba(255,255,255,0.96);
        backdrop-filter: blur(2px);

        transition:
            box-shadow 0.25s ease,
            background 0.25s ease;

        box-shadow:
            0 0 12px rgba(255, 225, 160, 0.12);
    }

    .story-textarea.typing-glow {
        box-shadow:
            0 0 20px rgba(255, 245, 220, 0.9),
            0 0 50px rgba(255, 240, 200, 0.7),
            0 0 90px rgba(255, 255, 240, 0.45) !important;
    }
</style>

@endsection
