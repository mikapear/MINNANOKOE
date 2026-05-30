@extends('layouts.site')

@section('title', 'みんなの声辞典 | '.config('app.name'))

@section('content')
    <div class="text-center space-y-6">
        <div class="flex justify-center">
            <img src="{{ asset('logo.png') }}" alt="ロゴ" class="h-40 w-auto object-contain sm:h-64"/>
        </div>
        <p class="text-lg text-indigo-900 font-medium">あなたの日常、あなたの声</p>
        <p class="text-sm text-gray-600">プロジェクト <span class="font-semibold">Survivor+</span></p>
        <div class="mx-auto max-w-2xl space-y-3 text-center">
            <p class="text-lg font-medium leading-relaxed text-indigo-900 sm:text-lg">
                治療中に感じたこと、不安だったこと、
                助けられた言葉や日々の工夫。
            </p>

            <p class="text-lg font-medium leading-relaxed text-indigo-900 sm:text-lg">
                「みんなの声辞典」は、
                がん経験者の声を残し、
                次の誰かを支えるための場所です。
            </p>
        </div>
    </div>

    <div class="mt-12 grid gap-4 sm:grid-cols-3">
        <a href="{{ route('share.create') }}" class="block rounded-xl border-2 border-indigo-200 bg-white p-6 text-center font-medium text-indigo-800 shadow-sm transition hover:border-indigo-400">
            <div class="space-y-4">
                <div class="text-lg font-semibold">
                    物語のシェア
                </div>
                <div class="flex h-40 items-center justify-center">
                    <img
                        src="{{ asset('images/icons/write.png') }}"
                        alt="シェア"
                        class="mx-auto h-32 w-auto object-contain"
                    >
                </div>

                <p class="mx-auto max-w-[220px]" text-sm text-indigo-800 leading-relaxed>
                    あなたの経験や想いを次の誰かへ
                    届けます
                </p>
            </div>
        </a>
        <a href="{{ route('stories.index') }}" class="block rounded-xl border-2 border-indigo-200 bg-white p-6 text-center font-medium text-indigo-800 shadow-sm transition hover:border-indigo-400">
            <div class="space-y-4">
                <div class="text-lg font-semibold">
                    物語を探す
                </div>
                <div class="flex h-40 items-center justify-center">
                    <img
                        src="{{ asset('images/icons/read.png') }}"
                        alt="探す"
                        class="mx-auto h-32 w-auto object-contain"
                    >
                </div>
                
                <p class="mx-auto max-w-[220px]" text-sm text-indigo-800 leading-relaxed>
                    同じ悩みや経験を持つ人の声を
                    探せます
                </p>

            </div>
        </a>
        <a href="{{ route('learn.index') }}" class="block rounded-xl border-2 border-indigo-200 bg-white p-6 text-center font-medium text-indigo-800 shadow-sm transition hover:border-indigo-400">
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
                
                <p class="mx-auto max-w-[220px]" text-sm text-indigo-800 leading-relaxed>
                    治療や生活に役立つ情報を優しく学べます
                </p>

            </div>
        </a>
    </div>

    <p class="mt-10 text-center text-xs text-gray-500">
        <a href="{{ route('terms') }}" class="underline">利用規約</a>
        ・
        <a href="{{ route('privacy') }}" class="underline">プライバシー</a>
    </p>
@endsection
