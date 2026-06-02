@extends('layouts.site')

@section('title', 'プロフィール編集 | '.config('app.name'))

@section('content')
    <h1 class="text-2xl font-bold text-gray-900">プロフィールを編集する</h1>

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