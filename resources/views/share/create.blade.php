@extends('layouts.site')

@section('title', '物語のシェア | '.config('app.name'))

@section('content')
    <h1 class="text-2xl font-bold text-gray-900">物語のシェア</h1>
    <p class="mt-2 text-sm text-gray-600">投稿は管理者の確認後に公開されます。個人が特定される情報は書かないでください。</p>

    <form method="post" action="{{ route('share.store') }}" class="mt-8 space-y-6">
        @csrf
        <div>
            <label for="body" class="block text-sm font-medium text-gray-700">あなたの体験・工夫・いま思うこと</label>
            <textarea id="body" name="body" rows="12" required
                class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('body') }}</textarea>
            <div class="mt-1 text-right text-xs text-gray-500">
                <span id="char-count">0</span> / 3000文字
            </div>
            <x-input-error :messages="$errors->get('body')" class="mt-2" />
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

    function updateCharCount() {
        charCount.textContent = textarea.value.length;
    }

    textarea.addEventListener('input', updateCharCount);
    updateCharCount();
</script>



@endsection
