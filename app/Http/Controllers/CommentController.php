<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Models\Post           $post
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'body' => 'required',
        ]);

        try {
            DB::transaction(function () use ($request, $post) {
                $comment = new Comment();
                $comment->user_id = Auth::id();
                $comment->post_id = $post->id;
                $comment->body = $request->body;
                $comment->save();

                $post->latest_comment_time = Carbon::now();
                $post->save();
            }, 2);
        } catch (Throwable $e) {
            Log::error($e);
            throw $e;
        }

        return redirect()
            ->route('posts.show', $post)
            ->with(['message' => 'コメントしました。']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            abort(403);
        }
        $comment->deleted_at = Carbon::now();
        $comment->save();

        return redirect()
            ->route('posts.show', $post)
            ->with(['message' => '削除しました。']);
    }
}
