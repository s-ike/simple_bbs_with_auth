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
}
