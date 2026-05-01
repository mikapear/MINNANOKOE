<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="name" value="ニックネーム（表示名）" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="nickname" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" value="メールアドレス" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="パスワード" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="パスワード（確認）" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="birth_date" value="生年月日" />
            <x-text-input id="birth_date" class="block mt-1 w-full" type="date" name="birth_date" :value="old('birth_date')" required />
            <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="diagnosed_at" value="診断された日" />
            <x-text-input id="diagnosed_at" class="block mt-1 w-full" type="date" name="diagnosed_at" :value="old('diagnosed_at')" required />
            <x-input-error :messages="$errors->get('diagnosed_at')" class="mt-2" />
        </div>

        <fieldset class="space-y-2">
            <legend class="text-sm font-medium text-gray-700">治療内容（複数選択可）</legend>
            @foreach(config('minnanokoe.treatment_types') as $key => $label)
                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="treatment_types[]" value="{{ $key }}"
                        @checked(collect(old('treatment_types', []))->contains($key)) />
                    <span>{{ $label }}</span>
                </label>
            @endforeach
            <x-input-error :messages="$errors->get('treatment_types')" class="mt-2" />
        </fieldset>

        <label class="flex items-start gap-2 text-sm">
            <input type="checkbox" name="privacy" value="1" class="mt-1 rounded border-gray-300" @checked(old('privacy')) required />
            <span>個人情報の取り扱いに同意します。</span>
        </label>
        <x-input-error :messages="$errors->get('privacy')" class="mt-2" />

        <div class="flex items-center justify-end gap-4 pt-2">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">ログインへ</a>
            <x-primary-button>登録する</x-primary-button>
        </div>
    </form>
</x-guest-layout>
