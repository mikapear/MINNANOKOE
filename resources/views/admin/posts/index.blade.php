@extends('layouts.site')

@section('title', '管理 | 投稿一覧')

@section('content')
    <h1 class="text-2xl font-bold text-gray-900">投稿の管理</h1>

    <form method="get" class="mt-4 flex flex-wrap gap-2 text-sm">
        <label>
            ステータス
            <select name="status" class="ml-1 rounded border-gray-300 text-sm" onchange="this.form.submit()">
                <option value="">すべて</option>
                <option value="pending" @selected(($status ?? '') === 'pending')>公開準備待ち</option>
                <option value="published" @selected(($status ?? '') === 'published')>公開</option>
                <option value="rejected" @selected(($status ?? '') === 'rejected')>掲載見送り</option>
                <option value="hidden" @selected(($status ?? '') === 'hidden')>非表示</option>
            </select>
        </label>
    </form>

    @if(session('status') === 'rejected')
        <p class="mt-4 rounded-md bg-amber-50 p-3 text-sm text-amber-900">投稿を掲載見送りしました。</p>
    @endif

    <ul class="mt-8 divide-y divide-gray-200 rounded-lg border border-gray-200 bg-white">
        @foreach($posts as $post)
            <li class="flex flex-col gap-2 p-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-start gap-3">
                    @if($post->character)
                        <img
                            src="{{ asset($post->character->icon_path) }}"
                            alt="{{ $post->character->name }}"
                            class="mt-1 h-10 w-10 shrink-0"
                        >
                    @endif

                    <div>
                        <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium
                            @switch($post->status->value)
                                @case('published') bg-green-100 text-green-800 @break
                                @case('pending') bg-yellow-100 text-yellow-800 @break
                                @case('rejected') bg-red-100 text-red-800 @break
                                @case('hidden') bg-gray-100 text-gray-700 @break
                                @default bg-gray-100 text-gray-700
                            @endswitch
                        ">
                            @switch($post->status->value)
                                @case('pending') 公開準備待ち @break
                                @case('published') 公開中 @break
                                @case('rejected') 掲載見送り @break
                                @case('hidden') 非表示 @break
                                @default 状態不明
                            @endswitch
                        </span>
                       
                        @if($post->user)
                            <div class="mt-2 rounded-md bg-gray-50 p-2 text-xs text-gray-600">
                                <p>
                                    投稿者：
                                    <span class="font-medium text-gray-800">
                                        {{ $post->user->name }}
                                    </span>
                                    /
                                    {{ $post->user->email }}
                                </p>

                                <p class="mt-1">
                                    状態：
                                    @if($post->user->is_active)
                                        <span class="rounded-full bg-green-100 px-2 py-0.5 text-green-700">
                                            有効
                                        </span>
                                    @else
                                        <span class="rounded-full bg-red-100 px-2 py-0.5 text-red-700">
                                            停止中
                                        </span>
                                    @endif

                                    <span class="ml-2 text-gray-400">
                                        更新：{{ $post->updated_at->format('Y/m/d H:i') }}
                                    </span>
                                </p>

                                @if(!$post->user->is_admin && $post->user->is_active)
                                    <form
                                        method="POST"
                                        action="{{ route('admin.users.stop', $post->user) }}"
                                        class="mt-2"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="rounded bg-red-600 px-3 py-1 text-xs text-white hover:bg-red-700"
                                            onclick="return confirm('この投稿者を停止しますか？')"
                                        >
                                            この投稿者を停止
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endif

                        @if($post->user)

                            @php
                                $treatmentLabels = config('minnanokoe.treatment_types');

                                $treatments = collect((array) $post->user->treatment_types)
                                    ->map(fn ($t) => $treatmentLabels[$t] ?? $t)
                                    ->implode('・');
                            @endphp

                            <p class="mt-1 text-xs text-gray-500">

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
                    </div>
                </div>
                <a href="{{ route('admin.posts.edit', $post) }}" class="text-sm font-medium text-indigo-600 hover:underline">確認・編集</a>
            </li>
        @endforeach
    </ul>

    <div class="mt-6">{{ $posts->links() }}</div>
@endsection
