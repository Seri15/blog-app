<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // Homepage: list published posts, with search + category/tag filter + pagination
    public function index(Request $request)
    {
        $posts = Post::visibleTo(Auth::user())
            ->with(['author', 'category', 'tags'])
            ->search($request->query('q'))
            ->category($request->query('category'))
            ->tag($request->query('tag'))
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        $categories = Category::withCount('posts')->orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('posts.index', compact('posts', 'categories', 'tags'));
    }

    // Single post view
    public function show(Post $post)
    {
        $user = Auth::user();

        // guests/other authors shouldn't see drafts that aren't theirs
        if (! $post->isPublished()) {
            abort_unless(
                $user instanceof \App\Models\User && ($user->isAdmin() || $user->id === $post->user_id),
                404
            );
        }

        $post->increment('views_count');

        $post->load(['author', 'category', 'tags', 'comments.user']);

        $related = Post::published()
            ->where('id', '!=', $post->id)
            ->when($post->category_id, fn ($q) => $q->where('category_id', $post->category_id))
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('posts.show', compact('post', 'related'));
    }
}
