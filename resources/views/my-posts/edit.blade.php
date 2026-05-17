@extends('layouts.site')

@section('title', '投稿を編集 | '.config('app.name'))

@section('content')
    <h1 class="text-2xl font-bold text-gray-900">投稿を編集</h1>
@if($post->status === \App\Enums\PostStatus::Suggested && $post->rejection_reason)
    <div class="mt-6 rounded-lg border border-amber-200 bg-amber-50 p-4">
        <h2 class="text-sm font-semibold text-amber-900">
            管理者からのコメント
        </h2>
        <p class="mt-2 text-sm text-amber-900 whitespace-pre-wrap">
            {{ $post->rejection_reason }}
        </p>
    </div>
@endif

@if($post->status === \App\Enums\PostStatus::Suggested)

    <div>
        <label class="block text-sm font-medium text-gray-700">
            あなたの元の投稿
        </label>

        <div class="mt-1 rounded-md border border-gray-200 bg-gray-50 px-3 py-3 text-sm whitespace-pre-wrap text-gray-700">
            {{ $post->body_original }}
        </div>
    </div>

@endif

    <form method="post" action="{{ route('me.posts.update', $post) }}" class="mt-8 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="body" class="block text-sm font-medium text-gray-700">
                @if($post->status === \App\Enums\PostStatus::Suggested)
                修正提案本文（編集できます）
            @else
                本文
            @endif
            </label>
            <textarea id="body" name="body" rows="12" required
                class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('body', $post->status === \App\Enums\PostStatus::Suggested ? $post->body_published : $post->body_original) }}</textarea>
            <div class="mt-1 text-right text-xs text-gray-500">
                <span id="char-count">0</span> / 3000文字
            </div>
            
            <x-input-error :messages="$errors->get('body')" class="mt-2" />
        </div>

        <fieldset>
            <legend class="text-sm font-medium text-gray-700">
                タグ
            </legend>

            @php
                $selected = collect(old('tag_ids', $post->tags->pluck('id')->all()));
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
            class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
            @if($post->status === \App\Enums\PostStatus::Suggested)
        この内容で再投稿する
            @else
                投稿する
            @endif
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
