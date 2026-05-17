@extends('layouts.site')

@section('title', '管理 | 投稿 #'.$post->id)

@section('content')
    <h1 class="text-2xl font-bold text-gray-900">投稿の確認・編集</h1>

    @if(session('status') === 'saved')
        <p class="mt-4 rounded-md bg-green-50 p-3 text-sm text-green-800">保存しました。</p>
    @endif
    @if(session('status') === 'published')
        <p class="mt-4 rounded-md bg-green-50 p-3 text-sm text-green-800">公開しました。</p>
    @endif
    @if(session('status') === 'unpublished')
        <p class="mt-4 rounded-md bg-amber-50 p-3 text-sm text-amber-900">非表示にしました。</p>
    @endif

    <section class="mt-6 rounded-lg border border-gray-200 bg-gray-50 p-4">
        <h2 class="text-sm font-semibold text-gray-700">ユーザー原文</h2>
        <div class="mt-2 whitespace-pre-wrap text-sm text-gray-900">{{ $post->body_original }}</div>
    </section>

    <form id="admin-post-form" method="post" action="{{ route('admin.posts.update', $post) }}" class="mt-8 space-y-6">
        @csrf

        <div>
            <label for="body_published" class="block text-sm font-medium text-gray-700">公開用本文（編集・伏せ字後）</label>
            <textarea id="body_published" name="body_published" rows="14"
                class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('body_published', $post->body_published ?? $post->body_original) }}</textarea>
            <x-input-error :messages="$errors->get('body_published')" class="mt-2" />
        </div>

        <div>
            <label for="summary" class="block text-sm font-medium text-gray-700">要約・ひとこと（任意）</label>
            <textarea id="summary" name="summary" rows="3"
                class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('summary', $post->summary) }}</textarea>
            <div class="mt-1 text-right text-xs text-gray-500">
                <span id="char-count">0</span> / 3000文字
            </div>
            
        </div>

        <div>
            <label for="admin_comment" class="block text-sm font-medium text-gray-700">
                ユーザーへのコメント（修正提案時）
            </label>
            <textarea id="admin_comment" name="admin_comment" rows="3"
                class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('admin_comment', $post->rejection_reason) }}</textarea>
            <x-input-error :messages="$errors->get('admin_comment')" class="mt-2" />
        </div>

        <fieldset>
            <legend class="text-sm font-medium text-gray-700">タグ（公開一覧に反映）</legend>

            @php $sel = collect(old('tag_ids', $post->tags->pluck('id')->all())); @endphp

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
                                :checked="$sel->contains($tag->id)"
                            />
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </fieldset>

        <div class="flex flex-wrap gap-3">
            <button type="submit" name="action" value="save" class="rounded-md bg-gray-800 px-4 py-2 text-sm font-medium text-white hover:bg-gray-900">
                下書き保存
            </button>
            <button type="submit" name="action" value="publish" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                公開する
            </button>
            <button type="submit" name="action" value="suggest" class="rounded-md bg-amber-500 px-4 py-2 text-sm font-medium text-white hover:bg-amber-600">
                修正案として送る
            </button>
        </div>
    </form>

    @if($post->status->value !== 'rejected')
        <form method="post" action="{{ route('admin.posts.reject', $post) }}" class="mt-10 space-y-3 rounded-lg border border-red-200 bg-red-50 p-4">
            @csrf
            <label for="rejection_reason" class="block text-sm font-medium text-red-900">掲載見送り理由（必須）</label>
            <textarea id="rejection_reason" name="rejection_reason" rows="3" required
                class="w-full rounded-md border border-red-200 px-3 py-2 text-sm">{{ old('rejection_reason') }}</textarea>
            <button type="submit" class="rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">
                掲載見送りする
            </button>
        </form>
    @endif

    @if($post->status->value === 'published')
        <form method="post" action="{{ route('admin.posts.unpublish', $post) }}" class="mt-6">
            @csrf
            <button type="submit" class="text-sm text-amber-800 underline">公開を取りやめる（非表示）</button>
        </form>
    @endif

    @if($post->slug)
        <p class="mt-8 text-sm">
            公開URL:
            <a href="{{ route('stories.show', $post->slug) }}" class="text-indigo-600 hover:underline">{{ url(route('stories.show', $post->slug, false)) }}</a>
        </p>
    @endif

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
