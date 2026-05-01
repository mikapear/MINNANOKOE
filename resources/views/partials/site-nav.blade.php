<header class="bg-white border-b border-gray-200">
    <div class="max-w-4xl mx-auto flex flex-wrap items-center justify-between gap-3 px-4 py-3">
        <a href="{{ route('home') }}" class="text-lg font-semibold text-indigo-700">みんなの声辞典</a>
        <div class="flex flex-wrap items-center gap-3 text-sm">
            <a href="{{ route('stories.index') }}" class="text-gray-700 hover:text-indigo-600">物語を探す</a>
            <a href="{{ route('learn.index') }}" class="text-gray-700 hover:text-indigo-600">学んで成長</a>
            <a href="{{ route('share.create') }}" class="text-gray-700 hover:text-indigo-600">物語のシェア</a>
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.posts.index') }}" class="text-amber-700 font-medium">管理</a>
                @endif
                <a href="{{ route('me.posts') }}" class="text-gray-700 hover:text-indigo-600">マイ投稿</a>
                <span class="text-gray-400">|</span>
                <span class="text-gray-600">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-indigo-600 hover:underline">ログアウト</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">ログイン</a>
                <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">新規登録</a>
            @endauth
        </div>
    </div>
</header>
