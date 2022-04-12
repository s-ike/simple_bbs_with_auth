<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (count($posts) > 0)
                        <table class="table-fixed border-collapse border border-slate-500 mx-auto">
                            <thead>
                                <tr>
                                    <th class="border border-slate-600 w-2/4">タイトル</th>
                                    <th class="border border-slate-600 w-1/4">投稿者</th>
                                    <th class="border border-slate-600 w-1/4">投稿日時</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($posts as $post)
                                    <tr>
                                        <td class="border border-slate-700 px-4 py-2">
                                            <a href="{{ route('posts.show', $post) }}" class="hover:text-indigo-700">{{ $post->title }}</a>
                                        </td>
                                        <td class="border border-slate-700 px-4 py-2">{{ $post->user->name }}</td>
                                        <td class="border border-slate-700 px-4 py-2">{{ $post->created_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        まだ投稿がありません。
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
