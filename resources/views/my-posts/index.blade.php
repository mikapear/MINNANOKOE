@extends('layouts.site')

@section('title', 'マイ投稿 | '.config('app.name'))

@section('content')
    <h1 class="text-2xl font-bold text-gray-900">マイ投稿</h1>
    @if(session('error'))
        <p class="mt-4 rounded-md bg-red-50 p-3 text-sm text-red-800">
            {{ session('error') }}
        </p>
    @endif
    
    @if(in_array(session('status'), ['posted', 'updated'], true))
        <div class="mt-4 flex items-end gap-3">
            <img
                src="{{ asset('images/characters/bird-guide.png') }}"
                alt="MINNANOKOEの案内役"
                class="h-20 w-16 shrink-0 object-contain sm:h-24 sm:w-20"
            >

            <div class="relative mb-2 rounded-2xl border border-indigo-100 bg-indigo-50 px-4 py-3 text-indigo-900 shadow-sm">
                <span
                    class="absolute -left-2 bottom-5 h-4 w-4 rotate-45 border-b border-l border-indigo-100 bg-indigo-50"
                    aria-hidden="true"
                ></span>

                <p class="text-sm font-medium leading-relaxed">
                    @if(session('status') === 'posted')
                        投稿を受け付けたよ。公開まで少し待っていてね。
                    @elseif(session('status') === 'updated')
                        更新したよ。ありがとう。
                    @endif
                </p>
            </div>
        </div>
    @else
        <div class="mt-4 flex items-end gap-3">
            <img
                src="{{ asset('images/characters/bird-guide.png') }}"
                alt="MINNANOKOEの案内役"
                class="h-20 w-16 shrink-0 object-contain sm:h-24 sm:w-20"
            >

            <div class="relative mb-2 rounded-2xl border border-indigo-100 bg-indigo-50 px-4 py-3 text-indigo-900 shadow-sm">
                <span
                    class="absolute -left-2 bottom-5 h-4 w-4 rotate-45 border-b border-l border-indigo-100 bg-indigo-50"
                    aria-hidden="true"
                ></span>

                <p class="text-sm font-medium leading-relaxed">
                    投稿した声の確認や編集ができるよ。
                </p>
            </div>
        </div>
    @endif
    @if(session('status') === 'deleted')
        <p class="mt-4 rounded-md bg-red-50 p-3 text-sm text-red-800">
            投稿を削除しました。
        </p>
    @endif
<form method="get" class="mt-4 flex flex-wrap gap-2 text-sm">
    <label>
        ステータス
        <select name="status"
            class="ml-1 rounded border-gray-300 text-sm"
            onchange="this.form.submit()">
            <option value="">すべて</option>
            <option value="draft" @selected(($status ?? '') === 'draft')>下書き</option>
            <option value="pending" @selected(($status ?? '') === 'pending')>公開準備中</option>
            <option value="published" @selected(($status ?? '') === 'published')>公開中</option>
            <option value="suggested" @selected(($status ?? '') === 'suggested')>修正提案あり</option>
            <option value="rejected" @selected(($status ?? '') === 'rejected')>掲載見送り</option>
            <option value="hidden" @selected(($status ?? '') === 'hidden')>非表示</option>
        </select>
    </label>
</form>

    <ul class="mt-8 space-y-4">
        @foreach($posts as $post)
            <li class="rounded-lg border border-gray-200 bg-white p-4">
                <div class="flex flex-wrap items-center justify-between gap-2">
                     <div class="flex flex-wrap items-center gap-2">
                        <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium
                            @switch($post->status->value)
                                @case('published') bg-green-100 text-green-800 @break
                                @case('pending') bg-amber-100 text-amber-900 @break
                                @case('suggested') bg-amber-100 text-amber-800 @break
                                @case('rejected') bg-red-100 text-red-800 @break
                                @default bg-gray-100 text-gray-800
                            @endswitch
                        ">
                            @switch($post->status->value)
                                @case('published') 公開中 @break
                                @case('pending') 公開準備中 @break
                                @case('draft') 下書き @break
                                @case('suggested') 修正提案あり 
                                @break
                                @case('rejected') 掲載見送り @break
                                @case('hidden') 非表示 @break
                                @default {{ $post->status->value }}
                            @endswitch
                        </span>
                        @if($post->theme)
                            <span class="inline-flex rounded-full border border-yellow-200 bg-[#fff8df] px-3 py-1 text-xs font-medium text-stone-700">
                                {{ $post->theme->title }}
                            </span>
                        @endif
                    </div>
                        <span class="text-xs text-gray-500">{{ $post->updated_at->timezone(config('app.timezone'))->format('Y/m/d H:i') }}</span>
                </div>
                    <div class="flex items-center gap-3 mt-2">
                        @if($post->character)
                            <img
                                src="{{ asset($post->character->icon_path) }}"
                                alt="{{ $post->character->name }}"
                                class="h-10 w-10 shrink-0"
                            >
                        @endif
                        <div class="flex-1">

                            <p class="text-sm text-gray-800">
                                {{ \Illuminate\Support\Str::limit($post->body_original, 120) }}
                            </p>
                        </div>
                    </div>
                
                <div class="mt-2 text-xs text-pink-600">
                    ♡ {{ $post->likes->count() }}
                </div>

                @if($post->tags->isNotEmpty())
                    <div class="mt-2 flex flex-wrap gap-1">
                        @foreach($post->tags as $tag)
                            <span class="rounded bg-gray-100 px-2 py-0.5 text-xs text-gray-700">
                                #{{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                @endif

                @if($post->status->value === 'rejected' && $post->rejection_reason)
                    <p class="mt-2 rounded bg-red-50 p-2 text-xs text-red-900">
                        <span class="font-medium">掲載見送り理由:</span> {{ $post->rejection_reason }}
                    </p>
                @endif
                @if(in_array($post->status->value, ['draft', 'suggested','rejected', 'published'], true))
                    <a href="{{ route('me.posts.edit', $post) }}"
                        class="mt-3 inline-block text-sm text-indigo-600 hover:underline">
                        編集
                    </a>
                @else

                    <span class="mt-3 inline-block text-sm text-gray-400">
                        編集不可
                    </span>
                @endif

                <form method="post"
                    action="{{ route('me.posts.destroy', $post) }}"
                    class="mt-3 ml-4 inline-block"
                    onsubmit="return confirm('この投稿を削除してもよろしいですか？');">

                @csrf
                @method('delete')

                <button type="submit"
                    class="text-sm text-red-600 hover:underline">
                    削除
                </button>

            </form>

                @if($post->status->value === 'published' && $post->slug)
                    <a href="{{ route('stories.show', $post->slug) }}" class="mt-3 ml-4 inline-block text-sm text-gray-600 hover:underline">公開ページを見る</a>
                @endif
            </li>
        @endforeach
    </ul>

    <div class="mt-6">{{ $posts->links() }}</div>
@endsection
