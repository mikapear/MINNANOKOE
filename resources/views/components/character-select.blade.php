<div>
    <label for="character_id" class="block text-sm font-medium text-gray-700">
        キャラクター
    </label>

    <select
        id="character_id"
        name="character_id"
        class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm"
    >
        <option value="">選択なし</option>

        @foreach($characters as $character)
            <option
                value="{{ $character->id }}"
                @selected(old('character_id', $selectedCharacterId ?? null) == $character->id)
            >
                {{ $character->name }}
            </option>
        @endforeach
    </select>
</div>