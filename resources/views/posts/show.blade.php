<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post detail') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if (session('message'))
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-blue-500 max-w-7xl mx-auto p-2 mb-4 text-white">
                    {{ session('message') }}
                </div>
            </div>
        @endif
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="lg:p-6 sm:p-4 w-full">
                    <div class="border-2 rounded-lg border-gray-200 border-opacity-50 p-8 sm:flex-row flex-col">
                        <div class="mb-6">
                            <h2 class="text-gray-900 text-lg title-font font-medium mb-3">
                                {{ $post->title }}
                            </h2>
                            <p class="leading-relaxed text-base">
                                {!! nl2br(e($post->body)) !!}
                            </p>
                        </div>
                        <div class="flex flex-wrap justify-between justify-items-center">
                            <p class="pt-2">
                                投稿者：{{ $post->user->name }}　投稿日時：{{ $post->created_at }}
                            </p>
                            @if ($post->user_id === \Illuminate\Support\Facades\Auth::id())
                                <div class="flex">
                                    <div>
                                        <a href="{{ route('posts.edit', $post) }}"
                                            class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-5 focus:outline-none hover:bg-indigo-600 rounded">
                                            {{ __('Edit') }}
                                        </a>
                                    </div>
                                    <div>
                                        <form action="{{ route('posts.destroy', $post) }}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button class="flex mx-auto ml-2 text-white bg-red-500 border-0 py-2 px-5 focus:outline-none hover:bg-red-600 rounded">
                                                {{  __('Delete') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
