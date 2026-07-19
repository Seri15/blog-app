<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Only logged-in users can comment (adjust if you want guest comments)
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        $user = Auth::user();

        $post->comments()->create([
            'user_id' => $user instanceof \App\Models\User ? $user->id : null,
            'body' => $request->body,
            'approved' => true, // set to false here if you want moderation
        ]);

        return back()->with('status', 'Comment posted!');
    }

    public function destroy(Post $post, \App\Models\Comment $comment)
    {
        $user = Auth::user();

        // only the comment's author or an admin can delete it
        abort_unless(
            $user instanceof \App\Models\User && ($user->id === $comment->user_id || $user->isAdmin()),
            403
        );

        $comment->delete();

        return back()->with('status', 'Comment deleted.');
    }
}
