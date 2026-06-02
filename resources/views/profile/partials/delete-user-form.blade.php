<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            アカウントの削除
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            アカウントを削除すると、投稿内容や登録情報はすべて削除され、元に戻すことはできません。必要な情報がある場合は、削除前に保存してください。
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >アカウントを削除する</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                本当にアカウントを削除しますか？
            </h2>

            @if($user->password)
                <p class="mt-1 text-sm text-gray-600">
                    アカウントを削除すると、投稿内容や登録情報はすべて削除されます。内容を確認のうえ、現在のパスワードを入力してください。
                </p>

                <div class="mt-6">
                    <x-input-label for="password" value="現在のパスワード" class="sr-only" />

                    <x-text-input
                        id="password"
                        name="password"
                        type="password"
                        class="mt-1 block w-3/4"
                        placeholder="現在のパスワード"
                    />

                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>
            @else
                <p class="mt-1 text-sm text-gray-600">
                    Google 等でログイン中の方は、下の欄に <strong>削除する</strong> と正確に入力して確定してください。
                </p>
                <div class="mt-6">
                    <x-input-label for="confirm_delete" value="確認のため「削除する」と入力" class="text-left" />
                    <x-text-input
                        id="confirm_delete"
                        name="confirm_delete"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="削除する"
                    />
                    <x-input-error :messages="$errors->userDeletion->get('confirm_delete')" class="mt-2" />
                </div>
            @endif

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    キャンセル
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    削除する
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
