@extends('layouts.site')

@section('title', 'お問い合わせ | '.config('app.name'))

@section('content')
<div class="mx-auto max-w-3xl">
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-indigo-900">
            お問い合わせ
        </h1>

        <p class="mt-3 text-sm text-gray-500">
            みんなの声辞典に関するお問い合わせはこちらからお願いいたします。
        </p>
    </div>

    <section class="rounded-xl border border-indigo-100 bg-white p-6 shadow-sm">
        <div class="space-y-4 leading-7 text-gray-700">
            <p>
                本サービスに関するご意見、ご要望、不具合のご報告、投稿内容に関するお問い合わせは、下記までご連絡ください。
            </p>

            <div class="rounded-lg bg-indigo-50 p-4 text-sm text-indigo-900">
                <p class="font-semibold">お問い合わせ先</p>
                <p class="mt-2">
                    Survivor+事務局
                </p>
                <p>
                    メールアドレス：
                    <a href="mailto:surviorplus.project@gmail.com" class="text-indigo-700 underline">
                        surviorplus.project@gmail.com
                    </a>
                </p>
            </div>

            <p class="text-sm text-gray-500">
                お問い合わせ内容によっては、回答までお時間をいただく場合があります。
            </p>
        </div>
    </section>
</div>
@endsection