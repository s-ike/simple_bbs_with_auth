<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Carbon\Carbon;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $post = $request->route()->parameter('post');
            if (! is_null($post)
                && ! $request->route()->named('posts.show')) {
                if ($post->user_id !== Auth::id()) {
                    abort(403);
                }
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::latest()
            ->with('user')
            ->orderBy('latest_comment_time', 'DESC')
            ->paginate($request->pagination ?? '20');

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3',
            'body' => 'required',
        ]);

        $post = new Post();
        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->body = $request->body;
        $post->latest_comment_time = Carbon::now();
        $post->save();

        return redirect()
            ->route('posts.index')
            ->with(['message' => '投稿しました。']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Models\Post           $post
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Post $post)
    {
        $comments = Comment::where('post_id', $post->id)
            ->with('user')
            ->latest('id')
            ->paginate($request->pagination ?? '10');

        $sorted_comments = $comments->sortBy('id');

        return view('posts.show', compact('post', 'comments', 'sorted_comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Models\Post           $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|min:3',
            'body' => 'required',
        ]);

        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();

        return redirect()
            ->route('posts.show', $post)
            ->with(['message' => '編集しました。']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()
            ->route('posts.index')
            ->with(['message' => '削除しました。']);
    }
}
