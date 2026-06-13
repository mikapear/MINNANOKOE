<nav class="mb-6 text-sm text-stone-600">
    <a href="{{ route('admin.posts.index') }}"
       class="{{ request()->routeIs('admin.posts.*') ? 'font-semibold text-indigo-700' : 'hover:text-stone-900' }}">
        投稿管理
    </a>

    <span class="mx-2 text-stone-300">｜</span>

    <a href="{{ route('admin.themes.index') }}"
       class="{{ request()->routeIs('admin.themes.*') ? 'font-semibold text-indigo-700' : 'hover:text-stone-900' }}">
        募集中テーマ
    </a>

    <span class="mx-2 text-stone-300">｜</span>

    <a href="{{ route('admin.tags.index') }}"
       class="{{ request()->routeIs('admin.tags.*') ? 'font-semibold text-indigo-700' : 'hover:text-stone-900' }}">
        タグ管理
    </a>

    <span class="mx-2 text-stone-300">｜</span>

    <a href="{{ route('admin.learn-columns.index') }}"
       class="{{ request()->routeIs('admin.learn-columns.*') ? 'font-semibold text-indigo-700' : 'hover:text-stone-900' }}">
        コラム管理
    </a>

    <span class="mx-2 text-stone-300">｜</span>

    <a href="{{ route('admin.learn-sections.index') }}"
       class="{{ request()->routeIs('admin.learn-sections.*') ? 'font-semibold text-indigo-700' : 'hover:text-stone-900' }}">
        学びカテゴリ
    </a>

    <span class="mx-2 text-stone-300">｜</span>

    <a href="{{ route('admin.users.index') }}"
       class="{{ request()->routeIs('admin.users.*') ? 'font-semibold text-indigo-700' : 'hover:text-stone-900' }}">
        ユーザー管理
    </a>
</nav>