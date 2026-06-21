@extends('layouts.site')

@section('title', 'プロフィール編集 | '.config('app.name'))

@section('content')
    <h1 class="text-2xl font-bold text-gray-900">プロフィールを編集する</h1>
        <p class="mt-2 text-sm text-gray-500">
            ※プロフィール情報は現在の状況として更新できます。過去の投稿に表示される立場・治療状況・治療内容などは、投稿時点の情報として保持されます。
        </p>
        
    <div class="mt-8 space-y-6">
        <div class="rounded-lg bg-white p-4 shadow sm:p-8">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="rounded-lg bg-white p-4 shadow sm:p-8">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="rounded-lg bg-white p-4 shadow sm:p-8">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection