@extends('layouts.site')

@section('title', ($pageTitle ?? 'みんなの声を読む').' | '.config('app.name'))

@section('content')
    <h1 class="text-2xl font-bold text-gray-900">{{ $pageTitle ?? 'みんなの声を読む' }}</h1>

    <form method="get"
      action="{{ route('stories.index') }}"
      class="mt-6 flex flex-wrap items-center gap-2">

        <input
            type="search"
            name="q"
            value="{{ $searchQuery ?? '' }}"
            placeholder="キーワードで検索"
            class="min-w-[220px] flex-1 rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        />

        <select
            name="sort"
            class="w-32 rounded-md border border-gray-300 px-3 py-2 pr-8 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            onchange="this.form.submit()"
        >
            <option value="new" @selected(($sort ?? 'new') === 'new')>新しい順</option>
            <option value="old" @selected(($sort ?? '') === 'old')>古い順</option>
            <option value="likes" @selected(($sort ?? '') === 'likes')>いいね順</option>
        </select>

        <button
            type="submit"
            class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700"
        >
            検索
        </button>
    </form>

    @if(($themes ?? collect())->isNotEmpty())
        <div class="mt-5">
            <p class="text-sm font-medium text-gray-700">
                テーマから探す
            </p>

            <div class="mt-3 flex flex-wrap gap-2">
                @foreach($themes as $theme)

                    @php
                        $isActive = (string)($activeThemeId ?? '') === (string)$theme->id;
                    @endphp
                    @php
                        $params = request()->except(['page', 'theme_id']);

                        if (! $isActive) {
                            $params['theme_id'] = $theme->id;
                        }
                    @endphp

                    <a
                        href="{{ route('stories.index', $params) }}"
                    
                        class="
                            rounded-full border px-4 py-2 text-sm font-medium transition-all duration-200
                            {{ $isActive
                                ? 'border-yellow-300 bg-[#fff8df] text-stone-800 ring-2 ring-yellow-200'
                                : 'border-stone-200/80 bg-white/90 text-stone-700 hover:border-yellow-300 hover:bg-[#fff8df]'
                            }}
                        "
                    >
                        {{ $theme->title }}
                    </a>

                @endforeach

            </div>
        </div>
    @endif

    @if(($pastThemes ?? collect())->isNotEmpty())
        <div class="mt-3">
            <button
                type="button"
                class="text-xs text-gray-500 underline"
                onclick="document.getElementById('past-themes').classList.toggle('hidden')"
            >
                過去のテーマも表示する
            </button>

            <div id="past-themes" class="mt-3 hidden flex flex-wrap gap-2">
                @foreach($pastThemes as $theme)
                    <label class="cursor-pointer">
                        <input
                            type="radio"
                            name="theme_id"
                            value="{{ $theme->id }}"
                            class="peer sr-only"
                            @checked(old('theme_id') == $theme->id || request('theme') == $theme->id)
                        >

                        <span class="inline-flex items-center rounded-full border border-stone-200/80 bg-white/90 px-4 py-2 text-sm font-medium text-stone-700 transition-all duration-200 hover:border-yellow-300 hover:bg-[#fff8df] peer-checked:border-yellow-200 peer-checked:bg-[#fff8df] peer-checked:text-stone-800">
                            {{ $theme->title }}
                        </span>
                    </label>
                @endforeach
            </div>
        </div>
    @endif

    @include('partials.tag-filter', [
        'tagGroups' => $tagGroups,
        'activeTag' => $activeTag ?? null,
    ])

    <ul class="mt-8 space-y-4">
        @forelse($posts as $post)
            <li class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                @if($post->author_roles || $post->author_birth_date || $post->author_treatment_types)
                    @php
                        $roleLabels = [
                        'patient' => '患者',
                        'family' => '家族',
                        'friend' => '友人・職場',
                        'medical' => '医療者',
                    ];

                    $statusLabels = [
                        'under_treatment' => '治療中',
                        'completed' => '治療終了',
                        'recurrence' => '再発治療中',
                        'metastatic' => '転移治療中',
                    ];

                    $ageLabel = function ($age) {
                        if ($age < 30) return '20代';
                        if ($age < 35) return '30代前半';
                        if ($age < 40) return '30代後半';
                        if ($age < 45) return '40代前半';
                        if ($age < 50) return '40代後半';
                        if ($age < 55) return '50代前半';
                        if ($age < 60) return '50代後半';
                        return '60代以上';
                    };

                    $roles = collect((array) $post->author_roles)
                        ->map(fn ($r) => $roleLabels[$r] ?? $r)
                        ->implode('・');

                    $status = $statusLabels[$post->author_treatment_status] ?? null;

                    $birthDate = $post->author_birth_date
                        ? \Carbon\Carbon::parse($post->author_birth_date)
                        : null;

                    $diagnosedAt = $post->author_diagnosed_at
                        ? \Carbon\Carbon::parse($post->author_diagnosed_at)
                        :null;

                    $currentAge = $birthDate ? $ageLabel($birthDate->age) : null;

                    $diagnosedAge = ($birthDate && $diagnosedAt)
                        ? $ageLabel($birthDate->diffInYears($diagnosedAt))
                        : null;

                    $treatmentLabels = config('minnanokoe.treatment_types');

                    $treatments = collect((array) $post->author_treatment_types)
                        ->map(fn ($t) => $treatmentLabels[$t] ?? $t)
                        ->implode('・');
                @endphp

                <div class="mb-3 text-xs text-gray-500">
                    {{ optional($post->published_at)->timezone(config('app.timezone'))->format('Y/m/d') }}

                    @if($roles)
                        ｜{{ $roles }}
                    @endif

                    @if($currentAge)
                        ｜現在{{ $currentAge }}
                    @endif

                    @if($diagnosedAge)
                        ｜診断時{{ $diagnosedAge }}
                    @endif

                    @if($status)
                        ｜{{ $status }}
                    @endif

                    @if($treatments)
                        ｜{{ $treatments }}
                    @endif
                </div>
                @endif

                @if($post->theme)
                    <div class="mb-3">
                        <span class="inline-flex rounded-full border border-yellow-200 bg-[#fff8df] px-3 py-1 text-xs font-medium text-stone-700">
                            {{ $post->theme->title }}
                        </span>
                    </div>
                @endif

                <div class="flex items-start gap-3">
                    @if($post->character)
                        <img
                            src="{{ asset($post->character->icon_path) }}"
                            alt="{{ $post->character->name }}"
                            class="mt-1 h-10 w-10 shrink-0"
                        >
                    @endif

                    <div>
                        <a href="{{ route('stories.show', $post->slug) }}"
                            class="text-gray-900 hover:text-indigo-700">
                            {{ \Illuminate\Support\Str::limit(strip_tags($post->body_published), 80) }}
                        </a>
                    </div>
                </div>
                

                @if($post->tags->isNotEmpty())
                    <div class="mt-3 flex flex-wrap gap-1">
                        @foreach($post->tags as $t)
                            <span class="rounded bg-gray-100 px-2 py-0.5 text-xs text-gray-700">
                                #{{ $t->name }}
                            </span>
                        @endforeach
                    </div>
                @endif
            </li>
        @empty
            <li class="text-gray-600">該当する物語がまだありません。</li>
        @endforelse
    </ul>

    <div class="mt-6">{{ $posts->links() }}</div>
@endsection
