<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_posts' => Post::count(),
            'published_posts' => Post::where('status', 'published')->count(),
            'draft_posts' => Post::where('status', 'draft')->count(),
            'total_views' => Post::sum('views_count'),
            'total_likes' => Like::count(),
            'total_comments' => Comment::count(),
            'total_authors' => User::where('role', 'author')->count(),
        ];

        $recentPosts = Post::with('author')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentPosts'));
    }
}
