@extends('layouts.site')

@section('title', '物語のシェア | '.config('app.name'))

@section('content')
    <h1 class="text-2xl font-bold text-gray-900">物語のシェア</h1>
    <p class="mt-2 text-sm text-gray-600">投稿は管理者の確認後に公開されます。個人が特定される情報は書かないでください。</p>

    <form method="post" action="{{ route('share.store') }}" class="mt-8 space-y-6">
        @csrf
        <div>
            <label for="body" class="block text-sm font-medium text-gray-700">あなたの体験・工夫・いま思うこと</label>
            <textarea id="body" name="body" rows="12" required
                class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('body') }}</textarea>
            <x-input-error :messages="$errors->get('body')" class="mt-2" />
        </div>

        <fieldset>
            <legend class="text-sm font-medium text-gray-700">タグ（任意・複数選択）</legend>
            <div class="mt-3 grid gap-2 sm:grid-cols-2">
                @foreach($tags as $tag)
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="tag_ids[]" value="{{ $tag->id }}"
                            @checked(collect(old('tag_ids', []))->contains($tag->id)) />
                        <span>#{{ $tag->name }}</span>
                    </label>
                @endforeach
            </div>
        </fieldset>

        <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
            シェアする
        </button>
    </form>
@endsection
