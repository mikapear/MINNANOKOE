<x-app-layout>
    <div class="max-w-3xl mx-auto py-8">

        <h1 class="text-2xl font-bold mb-6">
            テーマ作成
        </h1>

        <form method="POST" action="{{ route('admin.themes.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block font-medium mb-2">
                    テーマ名
                </label>

                <input
                    type="text"
                    name="title"
                    value="{{ old('title') }}"
                    class="w-full rounded-lg border-stone-300"
                    required
                >
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-2">
                    テーマの説明（任意）
                </label>

                <textarea
                    name="description"
                    rows="4"
                    class="w-full rounded-lg border-stone-300"
                >{{ old('description') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-2">
                    表示順
                </label>

                <input
                    type="number"
                    name="sort_order"
                    value="{{ old('sort_order', 0) }}"
                    class="w-full rounded-lg border-stone-300"
                >
            </div>

            <label class="flex items-center gap-2 mb-6">
                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                >
                <span>募集中にする</span>
            </label>

            <button
                class="px-5 py-2 bg-yellow-400 hover:bg-yellow-500 rounded-lg font-medium"
            >
                保存
            </button>

        </form>

    </div>
</x-app-layout>