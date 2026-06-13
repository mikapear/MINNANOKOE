<nav class="mb-6 flex flex-wrap gap-2 text-sm">
    <a href="{{ route('admin.posts.index') }}"
       class="rounded-full bg-amber-100 px-3 py-1.5 font-medium text-amber-800 hover:bg-amber-200">
        投稿管理
    </a>

    <a href="{{ route('admin.themes.index') }}"
       class="rounded-full bg-amber-100 px-3 py-1.5 font-medium text-amber-800 hover:bg-amber-200">
        募集中テーマ管理
    </a>

    <a href="{{ route('admin.tags.index') }}"
       class="rounded-full bg-amber-100 px-3 py-1.5 font-medium text-amber-800 hover:bg-amber-200">
        タグ管理
    </a>

    <a href="{{ route('admin.learn-columns.index') }}"
       class="rounded-full bg-amber-100 px-3 py-1.5 font-medium text-amber-800 hover:bg-amber-200">
        コラム管理
    </a>

    <a href="{{ route('admin.learn-sections.index') }}"
       class="rounded-full bg-amber-100 px-3 py-1.5 font-medium text-amber-800 hover:bg-amber-200">
        学びカテゴリ管理
    </a>

    <a href="{{ route('admin.users.index') }}"
       class="rounded-full bg-amber-100 px-3 py-1.5 font-medium text-amber-800 hover:bg-amber-200">
        ユーザー管理
    </a>
</nav>