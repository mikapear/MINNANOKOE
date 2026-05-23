<label class="cursor-pointer">
    <input
        type="checkbox"
        name="tag_ids[]"
        value="{{ $tag->id }}"
        class="peer sr-only"
        @checked($checked)
    />

    <span class="
        inline-flex items-center rounded-full

        border border-stone-200/80
        bg-white/90

        px-4 py-2

        text-sm font-medium
        text-stone-700

        transition-all duration-200

        hover:border-stone-300
        hover:bg-stone-50
        hover:text-stone-800

        peer-checked:border-yellow-200
        peer-checked:bg-[#fff9e6]
        peer-checked:text-stone-900

        peer-checked:shadow-[0_0_14px_rgba(255,245,200,0.28)]

        backdrop-blur-sm
    ">
        #{{ $tag->name }}
    </span>
</label>