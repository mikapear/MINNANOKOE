<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', config('app.name'))</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-50 text-gray-900">
        <div class="min-h-screen flex flex-col">

            @include('partials.site-nav')

            <main class="flex-1 max-w-4xl mx-auto w-full px-4 py-8">
                @yield('content')
            </main>

            <footer class="border-t border-gray-200 bg-white py-6">
                <div class="mx-auto max-w-4xl px-4 text-center text-xs  text-gray-500">
                    <a href="{{ route('terms') }}" class="hover:text-indigo-600 hover:underline">
                    利用規約
                    </a>

                    <span class="mx-2">|</span>

                    <a href="{{ route('privacy') }}" class="hover:text-indigo-600 hover:underline">
                        プライバシーポリシー
                    </a>
                    
                    <span class="mx-2">|</span>
                    <a href="{{ route('contact') }}" class="hover:text-indigo-600 hover:underline">
                        お問い合わせ
                    </a>
                </div>
            </footer>

        </div>

        @include('partials.character')
        @stack('scripts')
    </body>
</html>
