<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    // Toggle like/unlike for the current user on a post
    public function toggle(Post $post)
    {
        $existing = $post->likes()->where('user_id', Auth::id())->first();

        if ($existing) {
            $existing->delete();
        } else {
            $post->likes()->create(['user_id' => Auth::id()]);
        }

        return back()->with('status', $existing ? 'Like removed.' : 'Post liked!');
    }
}
