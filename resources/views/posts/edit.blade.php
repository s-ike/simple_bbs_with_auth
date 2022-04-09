<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('posts.update', $post) }}" method="post">
                        @method('PUT')
                        @csrf
                        <div>
                            <label>
                                {{ __('Title') }}
                                <input type="text" name="title" value={{ old('title', $post->title) }}>
                            </label>
                            @error('title')
                            <div class="text-red-600">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label>
                                {{ __('Body') }}
                                <textarea name="body">{{ old('body', $post->body) }}</textarea>
                            </label>
                            @error('body')
                                <div class="text-red-600">{{ $message }}</div>
                            @enderror
                        </div>
                        <button>{{ __('Edit') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
