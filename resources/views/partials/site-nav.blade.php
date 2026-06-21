<header class="bg-white border-b border-gray-200" x-data="{
        open: false,
        isDesktop: window.matchMedia('(min-width: 768px)').matches,
        init() {
            this.mq = window.matchMedia('(min-width: 768px)');
            this.onMqChange = () => {
                this.isDesktop = this.mq.matches;
                if (this.isDesktop) this.open = false;
            };
            this.mq.addEventListener('change', this.onMqChange);
        },
    }">
    <div class="max-w-4xl mx-auto px-4 py-3">
        <div class="flex items-center justify-between gap-3">
            <a href="{{ route('home') }}" class="text-lg font-semibold text-indigo-700">みんなの声辞典</a>

            <button type="button" x-cloak x-show="!isDesktop"
                class="site-nav-mobile-trigger inline-flex items-center justify-center rounded-md p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700"
                @click="open = !open" :aria-expanded="open" aria-label="メニューを開く">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            {{-- PC（768px 以上） --}}
            <div x-cloak x-show="isDesktop" class="site-nav-desktop flex items-center gap-8 text-gray-700">
                <a href="{{ route('stories.index') }}" class="flex flex-col items-center hover:text-indigo-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5A4.5 4.5 0 003 9.5v9.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V9.5A4.5 4.5 0 0016.5 5c-1.746 0-3.332.477-4.5 1.253z" />
                    </svg>
                    <span class="mt-1 text-xs leading-tight text-center">声を読む</span>
                </a>
                <a href="{{ route('share.create') }}" class="flex flex-col items-center hover:text-indigo-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M16.862 4.487a2.25 2.25 0 113.182 3.182L7.5 20.213 3 21l.787-4.5L16.862 4.487z" />
                    </svg>
                    <span class="mt-1 text-xs leading-tight text-center">声を投稿</span>
                </a>
                <a href="{{ route('learn.index') }}" class="flex flex-col items-center hover:text-indigo-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M12 14.25L3.75 9.75 12 5.25l8.25 4.5L12 14.25zm0 0v4.5m0-4.5l6.75-3.682v5.182c0 1.381-3.022 2.5-6.75 2.5s-6.75-1.119-6.75-2.5v-5.182L12 14.25z" />
                    </svg>
                    <span class="mt-1 text-xs leading-tight text-center">学んで安心</span>
                </a>
                <a href="{{ route('me.posts') }}" class="flex flex-col items-center hover:text-indigo-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M9 12h6m-6 4h6M9 8h6m-7.5 13.5h9A2.25 2.25 0 0018.75 19.25V4.75A2.25 2.25 0 0016.5 2.5h-9A2.25 2.25 0 005.25 4.75v14.5A2.25 2.25 0 007.5 21.5z" />
                    </svg>
                    <span class="mt-1 text-xs leading-tight text-center">マイ投稿</span>
                </a>
                <a href="{{ route('profile.edit') }}"
                    class="flex flex-col items-center text-gray-700 hover:text-indigo-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0" />
                    </svg>
                    <span class="mt-1 text-xs leading-tight text-center">プロフィール</span>
                </a>

                @auth
                @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.posts.index') }}"
                    class="flex flex-col items-center text-gray-700 hover:text-amber-700">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M10.325 4.317a1.724 1.724 0 013.35 0l.172.688a1.724 1.724 0 002.591 1.066l.61-.366a1.724 1.724 0 012.372.63l.344.596a1.724 1.724 0 01-.63 2.372l-.596.344a1.724 1.724 0 00-.822 1.49v.726c0 .615.33 1.183.862 1.49l.556.322a1.724 1.724 0 01.63 2.372l-.344.596a1.724 1.724 0 01-2.372.63l-.61-.366a1.724 1.724 0 00-2.591 1.066l-.172.688a1.724 1.724 0 01-3.35 0l-.172-.688a1.724 1.724 0 00-2.591-1.066l-.61.366a1.724 1.724 0 01-2.372-.63l-.344-.596a1.724 1.724 0 01.63-2.372l.556-.322a1.724 1.724 0 00.862-1.49v-.726a1.724 1.724 0 00-.822-1.49l-.596-.344a1.724 1.724 0 01-.63-2.372l.344-.596a1.724 1.724 0 012.372-.63l.61.366a1.724 1.724 0 002.591-1.066l.172-.688z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M12 15.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z" />
                    </svg>
                    <span class="mt-1 text-xs leading-tight text-center">管理</span>
                </a>
                @endif

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

        {{-- スマホ（767px 以下） --}}
        <div x-show="open && !isDesktop" x-cloak x-transition @click.outside="open = false"
            class="site-nav-mobile-panel border-t border-gray-100 mt-3 pt-3 space-y-1">
            <a href="{{ route('stories.index') }}" @click="open = false"
                class="flex items-center gap-3 rounded-lg px-3 py-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">
                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5A4.5 4.5 0 003 9.5v9.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V9.5A4.5 4.5 0 0016.5 5c-1.746 0-3.332.477-4.5 1.253z" />
                </svg>
                <span>声を読む</span>
            </a>
            <a href="{{ route('share.create') }}" @click="open = false"
                class="flex items-center gap-3 rounded-lg px-3 py-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">
                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M16.862 4.487a2.25 2.25 0 113.182 3.182L7.5 20.213 3 21l.787-4.5L16.862 4.487z" />
                </svg>
                <span>声を投稿</span>
            </a>
            <a href="{{ route('learn.index') }}" @click="open = false"
                class="flex items-center gap-3 rounded-lg px-3 py-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">
                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M12 14.25L3.75 9.75 12 5.25l8.25 4.5L12 14.25zm0 0v4.5m0-4.5l6.75-3.682v5.182c0 1.381-3.022 2.5-6.75 2.5s-6.75-1.119-6.75-2.5v-5.182L12 14.25z" />
                </svg>
                <span>学んで安心</span>
            </a>
            <a href="{{ route('me.posts') }}" @click="open = false"
                class="flex items-center gap-3 rounded-lg px-3 py-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">
                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M9 12h6m-6 4h6M9 8h6m-7.5 13.5h9A2.25 2.25 0 0018.75 19.25V4.75A2.25 2.25 0 0016.5 2.5h-9A2.25 2.25 0 005.25 4.75v14.5A2.25 2.25 0 007.5 21.5z" />
                </svg>
                <span>マイ投稿</span>
            </a>
            <a href="{{ route('profile.edit') }}" @click="open = false"
                class="flex items-center gap-3 rounded-lg px-3 py-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">
                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0" />
                </svg>
                <span>プロフィール</span>
            </a>

            @auth
            @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.posts.index') }}" @click="open = false"
                class="flex items-center gap-3 rounded-lg px-3 py-2 text-gray-700 hover:bg-amber-50 hover:text-amber-700">
                <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M10.325 4.317a1.724 1.724 0 013.35 0l.172.688a1.724 1.724 0 002.591 1.066l.61-.366a1.724 1.724 0 012.372.63l.344.596a1.724 1.724 0 01-.63 2.372l-.596.344a1.724 1.724 0 00-.822 1.49v.726c0 .615.33 1.183.862 1.49l.556.322a1.724 1.724 0 01.63 2.372l-.344.596a1.724 1.724 0 01-2.372.63l-.61-.366a1.724 1.724 0 00-2.591 1.066l-.172.688a1.724 1.724 0 01-3.35 0l-.172-.688a1.724 1.724 0 00-2.591-1.066l-.61.366a1.724 1.724 0 01-2.372-.63l-.344-.596a1.724 1.724 0 01.63-2.372l.556-.322a1.724 1.724 0 00.862-1.49v-.726a1.724 1.724 0 00-.822-1.49l-.596-.344a1.724 1.724 0 01-.63-2.372l.344-.596a1.724 1.724 0 012.372-.63l.61.366a1.724 1.724 0 002.591-1.066l.172-.688z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M12 15.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z" />
                </svg>
                <span>管理</span>
            </a>
            @endif

            <div class="border-t border-gray-100 mt-3 pt-3 px-3 space-y-2">
                <p class="text-sm text-gray-600">{{ Auth::user()->name }}</p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-indigo-600 hover:underline">ログアウト</button>
                </form>
            </div>
            @else
            <div class="border-t border-gray-100 mt-3 pt-3 px-3 flex flex-col gap-2">
                <a href="{{ route('login') }}" @click="open = false" class="text-indigo-600 hover:underline">ログイン</a>
                <a href="{{ route('register') }}" @click="open = false" class="text-indigo-600 hover:underline">新規登録</a>
            </div>
            @endauth
        </div>
    </div>
</header>