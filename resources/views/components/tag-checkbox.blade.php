<label class="cursor-pointer">
    <input
        type="checkbox"
        name="tag_ids[]"
        value="{{ $tag->id }}"
        class="peer sr-only"
        @checked($checked)
    />

    <span class="inline-flex items-center rounded-full border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 transition hover:bg-pink-50 peer-checked:border-pink-400 peer-checked:bg-pink-100 peer-checked:text-pink-700 peer-checked:font-semibold">
        #{{ $tag->name }}
    </span>
</label>