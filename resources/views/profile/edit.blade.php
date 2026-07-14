@extends('layouts.site')

@section('title', 'プロフィール編集 | '.config('app.name'))

@section('content')
    <h1 class="text-2xl font-bold text-gray-900">プロフィールを編集する</h1>
    <div class="mt-5 flex items-end gap-3">
        <img
            src="{{ asset('images/characters/bird-guide.png') }}"
            alt="MINNANOKOEの案内役"
            class="h-20 w-16 shrink-0 object-contain sm:h-24 sm:w-20"
        >

        <div class="relative mb-2 max-w-2xl rounded-2xl border border-indigo-100 bg-indigo-50 px-4 py-3 text-indigo-900 shadow-sm">
            <span
                class="absolute -left-2 bottom-5 h-4 w-4 rotate-45 border-b border-l border-indigo-100 bg-indigo-50"
                aria-hidden="true"
            ></span>
            @if(session('status') === 'profile-updated')
            <p class="text-sm font-medium leading-relaxed">
                プロフィールを保存したよ。
            </p>
            @else
            <p class="text-sm font-medium leading-relaxed">
                プロフィールは、今の状況に合わせて更新できるよ。<br>
                過去の投稿には、投稿した時点の立場や治療状況、治療内容がそのまま残ります。
            </p>
            @endif

        </div>
    </div>
        
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