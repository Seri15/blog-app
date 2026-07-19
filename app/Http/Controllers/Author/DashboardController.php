<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $myPosts = Post::where('user_id', $userId);

        $stats = [
            'total_posts' => (clone $myPosts)->count(),
            'published_posts' => (clone $myPosts)->where('status', 'published')->count(),
            'draft_posts' => (clone $myPosts)->where('status', 'draft')->count(),
            'total_views' => (clone $myPosts)->sum('views_count'),
            'total_likes' => Like::whereIn('post_id', (clone $myPosts)->pluck('id'))->count(),
            'total_comments' => Comment::whereIn('post_id', (clone $myPosts)->pluck('id'))->count(),
        ];

        $recentPosts = (clone $myPosts)->latest()->take(5)->get();

        return view('author.dashboard', compact('stats', 'recentPosts'));
    }
}
