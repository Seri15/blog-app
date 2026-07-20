<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

// This controller is only reachable by role:author (see routes/web.php).
// Authors can BROWSE every post (index) so they can see what other
// authors have written, but edit/update/destroy stay locked to their own
// posts only - enforced by authorizeOwner() below.
class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::visibleTo(Auth::user())
            ->with(['category', 'author'])
            ->where('user_id', Auth::id())
            ->when($request->query('status'), fn ($q, $status) => $q->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('author.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('author.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validatePost($request);

        $data['slug'] = Post::generateUniqueSlug($data['title']);
        $data['user_id'] = Auth::id();

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $post = Post::create($data);


        return redirect()->route('author.posts.index')->with('status', 'Post created!');
    }

    public function edit(Post $post)
    {
        $this->authorizeOwner($post);

        $categories = Category::orderBy('name')->get();

        return view('author.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorizeOwner($post);

        $data = $this->validatePost($request, $post->id);

        if ($data['title'] !== $post->title) {
            $data['slug'] = Post::generateUniqueSlug($data['title'], $post->id);
        }

        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        if ($data['status'] === 'published' && ! $post->published_at) {
            $data['published_at'] = now();
        }

        $post->update($data);


        return redirect()->route('author.posts.index')->with('status', 'Post updated!');
    }

    public function destroy(Post $post)
    {
        $this->authorizeOwner($post);

        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        $post->delete();

        return redirect()->route('author.posts.index')->with('status', 'Post deleted.');
    }

    private function validatePost(Request $request, ?int $postId = null): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'required|in:draft,published',
            'featured_image' => 'nullable|image|max:2048',
        ]);
    }

    // Blocks an author from editing/deleting a post by guessing another
    // author's post URL - only the owning author may pass.
    private function authorizeOwner(Post $post): void
    {
        abort_unless(Auth::id() === $post->user_id, 403);
    }
}
