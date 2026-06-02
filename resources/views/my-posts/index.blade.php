@extends('layouts.site')

@section('title', 'マイ投稿 | '.config('app.name'))

@section('content')
    <h1 class="text-2xl font-bold text-gray-900">マイ投稿</h1>
    @if(session('error'))
        <p class="mt-4 rounded-md bg-red-50 p-3 text-sm text-red-800">
            {{ session('error') }}
        </p>
    @endif
    
    @if(session('status') === 'posted')
        <p class="mt-4 rounded-md bg-green-50 p-3 text-sm text-green-800">投稿を受け付けました。公開までお待ちください。</p>
    @endif
    @if(session('status') === 'updated')
        <p class="mt-4 rounded-md bg-green-50 p-3 text-sm text-green-800">更新しました。</p>
    @endif

    @if(session('status') === 'deleted')
    <p class="mt-4 rounded-md bg-red-50 p-3 text-sm text-red-800">
        投稿を削除しました。
    </p>
    @endif

    <ul class="mt-8 space-y-4">
        @foreach($posts as $post)
            <li class="rounded-lg border border-gray-200 bg-white p-4">
                <div class="flex flex-wrap items-center justify-between gap-2">
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
                    <span class="text-xs text-gray-500">{{ $post->updated_at->timezone(config('app.timezone'))->format('Y/m/d H:i') }}</span>
                </div>
                <p class="mt-2 text-sm text-gray-800">
                    <div class="flex items-start gap-3 mt-2">
                        @if($post->character)
                            <img
                                src="{{ asset($post->character->icon_path) }}"
                                alt="{{ $post->character->name }}"
                                class="mt-1 h-10 w-10 shrink-0"
                            >
                        @endif

                        <div class="flex-1">
                            <p class="text-sm text-gray-800">
                                {{ \Illuminate\Support\Str::limit($post->body_original, 120) }}
                            </p>
                        </div>
                    </div>
                </p>

                <div class="mt-2 text-xs text-pink-600">
                    ♡ {{ $post->likes->count() }}
                </div>

                @if($post->user)
                    @php
                        $treatmentLabels = config('minnanokoe.treatment_types');

                        $treatments = collect((array) $post->user->treatment_types)
                            ->map(fn ($t) => $treatmentLabels[$t] ?? $t)
                            ->implode('・');
                    @endphp

                    <p class="mt-2 text-xs text-gray-500">

                        @if($post->user->birth_date)
                            現在{{ floor(\Carbon\Carbon::parse($post->user->birth_date)->age / 10) * 10 }}代
                        @endif

                        @if($post->user->birth_date && $post->user->diagnosed_at)
                            ｜診断時{{ floor(\Carbon\Carbon::parse($post->user->birth_date)->diffInYears(\Carbon\Carbon::parse($post->user->diagnosed_at)) / 10) * 10 }}代
                        @endif

                        @if($treatments)
                            ｜治療: {{ $treatments }}
                        @endif

                    </p>
                @endif

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
