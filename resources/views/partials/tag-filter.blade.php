<form method="get" action="{{ route('stories.index') }}" class="mt-4">
    <p class="text-sm font-medium text-gray-700">
        タグで絞り込み
    </p>

    <input type="hidden" name="q" value="{{ $searchQuery ?? '' }}">
    <input type="hidden" name="sort" value="{{ $sort ?? 'new' }}">

    <div class="mt-4 space-y-5">
        @foreach($tagGroups as $group)
            <details open class="rounded-lg border border-gray-200 bg-white p-4">
                <summary class="cursor-pointer text-sm font-semibold text-gray-800">
                    {{ $group->name }}
                </summary>

                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach($group->tags as $tag)
                        <x-tag-checkbox
                            :tag="$tag"
                            :checked="collect($tagIds ?? [])->contains($tag->id)"
                        />
                    @endforeach
                </div>
            </details>
        @endforeach
    </div>

    <button
        type="submit"
        class="mt-4 rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700"
    >
        この条件で絞り込む
    </button>
</form>