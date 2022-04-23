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
                    <div class="border-2 rounded-lg border-gray-200 border-opacity-50 p-8 mb-4 sm:flex-row flex-col">
                        <div class="mb-6">
                            <h1 class="text-gray-900 text-lg title-font font-semibold mb-3">
                                {{ $post->title }}
                            </h1>
                            <p class="leading-relaxed text-base">
                                {!! nl2br(e($post->body)) !!}
                            </p>
                        </div>
                        <div class="flex flex-wrap justify-between justify-items-center">
                            <div class="pt-2">
                                <div class="flex">
                                    <div>
                                        投稿者：{{ $post->user->name }}
                                    </div>
                                    <div class="ml-4">
                                        投稿日時：{{ $post->created_at }}
                                    </div>
                                </div>
                            </div>
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

                    @if ($comments && count($comments) > 0)
                        <div class="border-2 rounded-lg border-gray-200 border-opacity-50 p-8 mb-4 sm:flex-row flex-col divide-y divide-gray-500">
                            @if ($comments && count($comments) >= 10)
                                <form action="{{ route('posts.show', $post) }}" method="get">
                                    <div class="text-right mb-4">
                                        <label for="pagination">表示件数</label>
                                        <select name="pagination" id="pagination">
                                            <option value="10"
                                                @if (\Request::get('pagination') === '10')
                                                    selected
                                                @endif>10件</option>
                                            <option value="20"
                                                @if (\Request::get('pagination') === '20')
                                                    selected
                                                @endif>20件</option>
                                        </select>
                                    </div>
                                </form>
                            @endif
                            @php
                                $i = 1;
                                if ($comments->total() > ($comments->currentPage() * $comments->perPage())) {
                                    $i = $comments->total() - ($comments->currentPage() * $comments->perPage()) + 1;
                                }
                            @endphp
                            @foreach ($sorted_comments as $comment)
                                <div class="mb-4">
                                    <div class="mt-4">
                                        {{ $comment->body }}
                                    </div>
                                    <div class="flex pt-2">
                                        <div class="font-semibold">
                                            {{ $i }}
                                        </div>
                                        <div class="ml-4">
                                            投稿者：{{ $comment->user->name }}
                                        </div>
                                        <div class="ml-4">
                                            投稿日時：{{ $comment->created_at }}
                                        </div>
                                    </div>
                                </div>
                                @php
                                    ++$i;
                                @endphp
                            @endforeach
                            <div class="pt-4">
                                {{ $comments->links() }}
                            </div>
                        </div>
                    @endif

                    <div>
                        <form action="{{ route('comments.store', $post) }}" method="post">
                            @csrf
                            <div>
                                <label for="body" class="leading-7">{{ __('Comment') }}</label>
                                <textarea name="body" id="body" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ old('body') }}</textarea>
                                @error('body')
                                    <div class="text-red-600">{{ $message }}</div>
                                @enderror
                                <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-5 focus:outline-none hover:bg-indigo-600 rounded">
                                    {{ __('Send comment') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const paginate = document.getElementById('pagination');
        paginate.addEventListener('change', function () {
            this.form.submit();
        });
    </script>
</x-app-layout>
