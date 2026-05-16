@extends('layouts.site')

@section('title', '管理 | 投稿一覧')

@section('content')
    <h1 class="text-2xl font-bold text-gray-900">投稿の管理</h1>

    <form method="get" class="mt-4 flex flex-wrap gap-2 text-sm">
        <label>
            ステータス
            <select name="status" class="ml-1 rounded border-gray-300 text-sm" onchange="this.form.submit()">
                <option value="">すべて</option>
                <option value="pending" @selected(($status ?? '') === 'pending')>審査待ち</option>
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
                <div>
                    <span class="text-xs font-medium uppercase text-gray-500">{{ $post->status->value }}</span>
                    <p class="mt-1 text-sm text-gray-900">{{ \Illuminate\Support\Str::limit($post->body_original, 100) }}</p>
                    <p class="text-xs text-gray-500">{{ $post->user->email }} · {{ $post->updated_at->format('Y/m/d H:i') }}</p>

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
                <a href="{{ route('admin.posts.edit', $post) }}" class="text-sm font-medium text-indigo-600 hover:underline">確認・編集</a>
            </li>
        @endforeach
    </ul>

    <div class="mt-6">{{ $posts->links() }}</div>
@endsection
