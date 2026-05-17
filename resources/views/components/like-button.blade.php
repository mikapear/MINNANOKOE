@auth
    <form
        method="POST"
        action="{{ $action }}"
        class="{{ $class ?? 'mt-6' }}"
    >
        @csrf

        <button
            type="submit"
            class="rounded-full border border-pink-200 px-4 py-2 text-sm text-pink-600 hover:bg-pink-50"
        >
            ♡ {{ $count }}
        </button>
    </form>
@else
    <p class="{{ $class ?? 'mt-6' }} text-sm text-gray-500">
        ログインすると共感できます ♡ {{ $count }}
    </p>
@endauth