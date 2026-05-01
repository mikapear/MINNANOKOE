@extends('layouts.site')

@section('title', 'マイ投稿 | '.config('app.name'))

@section('content')
    <h1 class="text-2xl font-bold text-gray-900">マイ投稿</h1>

    @if(session('status') === 'posted')
        <p class="mt-4 rounded-md bg-green-50 p-3 text-sm text-green-800">投稿を受け付けました。公開までお待ちください。</p>
    @endif
    @if(session('status') === 'updated')
        <p class="mt-4 rounded-md bg-green-50 p-3 text-sm text-green-800">更新しました。</p>
    @endif

    <ul class="mt-8 space-y-4">
        @foreach($posts as $post)
            <li class="rounded-lg border border-gray-200 bg-white p-4">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium
                        @switch($post->status->value)
                            @case('published') bg-green-100 text-green-800 @break
                            @case('pending') bg-amber-100 text-amber-900 @break
                            @case('rejected') bg-red-100 text-red-800 @break
                            @default bg-gray-100 text-gray-800
                        @endswitch
                    ">
                        @switch($post->status->value)
                            @case('published') 公開中 @break
                            @case('pending') 審査中 @break
                            @case('rejected') 却下 @break
                            @case('hidden') 非表示 @break
                            @default {{ $post->status->value }}
                        @endswitch
                    </span>
                    <span class="text-xs text-gray-500">{{ $post->updated_at->timezone(config('app.timezone'))->format('Y/m/d H:i') }}</span>
                </div>
                <p class="mt-2 text-sm text-gray-800">{{ \Illuminate\Support\Str::limit($post->body_original, 120) }}</p>
                @if($post->status->value === 'rejected' && $post->rejection_reason)
                    <p class="mt-2 rounded bg-red-50 p-2 text-xs text-red-900">
                        <span class="font-medium">却下理由:</span> {{ $post->rejection_reason }}
                    </p>
                @endif
                @if(in_array($post->status->value, ['pending', 'rejected'], true))
                    <a href="{{ route('me.posts.edit', $post) }}" class="mt-3 inline-block text-sm text-indigo-600 hover:underline">編集・再提出</a>
                @endif
                @if($post->status->value === 'published' && $post->slug)
                    <a href="{{ route('stories.show', $post->slug) }}" class="mt-3 ml-4 inline-block text-sm text-gray-600 hover:underline">公開ページを見る</a>
                @endif
            </li>
        @endforeach
    </ul>

    <div class="mt-6">{{ $posts->links() }}</div>
@endsection
