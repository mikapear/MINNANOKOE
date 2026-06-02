@extends('layouts.site')

@section('title', 'ユーザー管理')

@section('content')

<h1 class="text-2xl font-bold text-gray-900 mb-6">
    ユーザー管理
</h1>

@if(session('status') === 'user-stopped')
    <p class="mb-4 rounded-md bg-red-50 p-3 text-sm text-red-800">
        ユーザーを停止しました。
    </p>
@endif

@if(session('status') === 'user-activated')
    <p class="mb-4 rounded-md bg-green-50 p-3 text-sm text-green-800">
        ユーザーを再開しました。
    </p>
@endif

<div class="overflow-x-auto rounded-lg border border-gray-200 bg-white">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="p-3 text-left">ユーザー</th>
                <th class="p-3 text-left">投稿数</th>
                <th class="p-3 text-left">登録日</th>
                <th class="p-3 text-left">状態</th>
                <th class="p-3 text-left">操作</th>
            </tr>
        </thead>

        <tbody>
            @forelse($users as $user)
                <tr class="border-t align-top">
                    <td class="p-3">
                        <div class="font-medium text-gray-900">
                            {{ $user->name }}
                        </div>
                        <div class="mt-1 text-xs text-gray-500">
                            {{ $user->email }}
                        </div>

                        @if($user->is_admin)
                            <div class="mt-2">
                                <span class="rounded-full bg-indigo-100 px-2 py-0.5 text-xs text-indigo-700">
                                    管理者
                                </span>
                            </div>
                        @endif
                    </td>

                    <td class="p-3 text-gray-700">
                        {{ $user->posts_count }}件
                    </td>

                    <td class="p-3 text-xs text-gray-500">
                        {{ optional($user->created_at)->timezone(config('app.timezone'))->format('Y/m/d H:i') }}
                    </td>

                    <td class="p-3">
                        @if($user->is_active)
                            <span class="rounded-full bg-green-100 px-2 py-1 text-xs text-green-700">
                                有効
                            </span>
                        @else
                            <span class="rounded-full bg-red-100 px-2 py-1 text-xs text-red-700">
                                停止中
                            </span>
                        @endif
                    </td>

                    <td class="p-3">
                        @if($user->is_admin)
                            <span class="text-xs text-gray-400">
                                操作不可
                            </span>
                        @elseif($user->is_active)
                            <form method="POST" action="{{ route('admin.users.stop', $user) }}">
                                @csrf
                                @method('PATCH')

                                <button
                                    type="submit"
                                    class="rounded bg-red-600 px-3 py-1 text-xs text-white hover:bg-red-700"
                                    onclick="return confirm('このユーザーを停止しますか？')"
                                >
                                    停止
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.users.activate', $user) }}">
                                @csrf
                                @method('PATCH')

                                <button
                                    type="submit"
                                    class="rounded bg-green-600 px-3 py-1 text-xs text-white hover:bg-green-700"
                                    onclick="return confirm('このユーザーを再開しますか？')"
                                >
                                    再開
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-6 text-center text-gray-500">
                        ユーザーはまだいません。
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $users->links() }}
</div>

@endsection