@extends('layouts.site')

@section('title', 'みんなの声辞典 | '.config('app.name'))

@section('content')
    <div class="text-center space-y-6">
        <div class="flex justify-center">
            <img src="{{ asset('logo.png') }}" alt="ロゴ" class="h-40 w-auto object-contain sm:h-64"/>
        </div>
        <p class="text-base text-indigo-900 font-medium sm:text-2xl">あなたの日常、あなたの声</p>
        <div class="mx-auto max-w-2xl space-y-3 text-center">
            <p class="hidden sm:block text-lg font-medium leading-relaxed text-indigo-900">
                不安だったこと、
                頑張ったこと、
                助けられた言葉や日々の工夫。
            </p>

            <p class="text-sm font-medium leading-relaxed text-indigo-900 sm:text-lg">
                「みんなの声辞典」は
                乳がん経験者の声と記憶を残し、
                次の誰かを支えるための場所です。
            </p>
        </div>
    </div>

    @if($themes->isNotEmpty())
        <div class="mt-10 rounded-2xl text-center">
            <p class="text-sm font-semibold text-indigo-900">
                今、募集しているテーマ
            </p>

            <div class="mt-3 flex flex-wrap justify-center gap-2">
                @foreach($themes as $theme)
                    <a href="{{ route('share.create') }}?theme={{ $theme->id }}" 
                        class="rounded-full border border-stone-200/80 bg-white/90 px-4 py-2 text-sm font-medium text-stone-700 shadow-sm transition-all duration-200 hover:border-yellow-300 hover:bg-yellow-50 hover:shadow">
                            {{ $theme->title }}
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <div class="mt-12 grid gap-4 sm:grid-cols-3">
        <a href="{{ route('share.create') }}" class="block rounded-xl border-2 border-indigo-200 bg-white p-4 sm:p-6 text-center font-medium text-indigo-800 shadow-sm transition hover:border-indigo-400">
            <div class="space-y-4">
                <div class="text-lg font-semibold">
                    声を投稿する
                </div>
                <div class="flex h-40 items-center justify-center">
                    <img
                        src="{{ asset('images/icons/write.png') }}"
                        alt="シェア"
                        class="mx-auto h-32 w-auto object-contain"
                    >
                </div>

                <p class="mx-auto max-w-[220px] text-sm text-indigo-800 leading-relaxed">
                    あなたの経験や想いを届けます
                </p>
            </div>
        </a>
        <a href="{{ route('stories.index') }}" class="block rounded-xl border-2 border-indigo-200 bg-white p-4 sm:p-6 text-center font-medium text-indigo-800 shadow-sm transition hover:border-indigo-400">
            <div class="space-y-4">
                <div class="text-lg font-semibold">
                    みんなの声を読む
                </div>
                <div class="flex h-40 items-center justify-center">
                    <img
                        src="{{ asset('images/icons/read.png') }}"
                        alt="探す"
                        class="mx-auto h-32 w-auto object-contain"
                    >
                </div>
                
                <p class="mx-auto max-w-[220px] text-sm text-indigo-800 leading-relaxed">
                    同じ経験を持つ人の声を探せます
                </p>

            </div>
        </a>
        <a href="{{ route('learn.index') }}" class="block rounded-xl border-2 border-indigo-200 bg-white p-4 sm:p-6 text-center font-medium text-indigo-800 shadow-sm transition hover:border-indigo-400">
            <div class="space-y-4">
                <div class="text-lg font-semibold">
                    学んで安心
                </div>
                <div class="flex h-40 items-center justify-center">
                    <img
                        src="{{ asset('images/icons/learn.png') }}"
                        alt="学ぶ"
                        class="mx-auto h-40 w-auto object-contain"
                    >
                </div>
                
                <p class="mx-auto max-w-[220px] text-sm text-indigo-800 leading-relaxed">
                    治療や生活に役立つ情報を学べます
                </p>

            </div>
        </a>
    </div>

@endsection
