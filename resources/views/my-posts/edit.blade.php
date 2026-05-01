@extends('layouts.site')

@section('title', '投稿を編集 | '.config('app.name'))

@section('content')
    <h1 class="text-2xl font-bold text-gray-900">投稿を編集</h1>

    <form method="post" action="{{ route('me.posts.update', $post) }}" class="mt-8 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="body" class="block text-sm font-medium text-gray-700">本文</label>
            <textarea id="body" name="body" rows="12" required
                class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('body', $post->body_original) }}</textarea>
            <x-input-error :messages="$errors->get('body')" class="mt-2" />
        </div>

        <fieldset>
            <legend class="text-sm font-medium text-gray-700">タグ</legend>
            <div class="mt-3 grid gap-2 sm:grid-cols-2">
                @php $selected = collect(old('tag_ids', $post->tags->pluck('id')->all())); @endphp
                @foreach($tags as $tag)
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="tag_ids[]" value="{{ $tag->id }}"
                            @checked($selected->contains($tag->id)) />
                        <span>#{{ $tag->name }}</span>
                    </label>
                @endforeach
            </div>
        </fieldset>

        <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
            再提出する
        </button>
    </form>
@endsection
