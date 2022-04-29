<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts') }}
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
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (count($posts) > 0)
                        <div class="">
                            <form action="{{ route('posts.index') }}" method="get">
                                <div class="text-right">
                                    <label for="pagination">表示件数</label>
                                    <select name="pagination" id="pagination">
                                        <option value="20"
                                            @if (\Request::get('pagination') === '20')
                                                selected
                                            @endif>20件</option>
                                        <option value="50"
                                            @if (\Request::get('pagination') === '50')
                                                selected
                                            @endif>50件</option>
                                    </select>
                                </div>
                            </form>
                            <table class="table-fixed border-collapse border border-slate-500 mx-auto w-full">
                                <thead>
                                    <tr>
                                        <th class="border border-slate-600 w-2/4">タイトル</th>
                                        <th class="border border-slate-600 w-1/4">投稿者</th>
                                        <th class="border border-slate-600 w-1/4">更新日時</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($posts as $post)
                                        <tr>
                                            <td class="border border-slate-700 px-4 py-2">
                                                <div class="flex">
                                                    <p>{{ $post->id }}</p>
                                                    <a href="{{ route('posts.show', $post) }}" class="text-indigo-500 hover:text-indigo-700 ml-2">
                                                        {{ $post->title }}
                                                    </a>
                                                    @php
                                                        $count = $post->comments->count();
                                                    @endphp
                                                    @if ($count > 0)
                                                        <div class="flex items-center bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">
                                                            {{ $count }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="border border-slate-700 px-4 py-2">{{ $post->user->name }}</td>
                                            <td class="border border-slate-700 px-4 py-2">{{ $post->latest_comment_time }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $posts->links() }}
                        </div>
                    @else
                        まだ投稿がありません。
                    @endif
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
