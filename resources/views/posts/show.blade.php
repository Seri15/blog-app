<x-guest-layout>
    <div class="max-w-3xl mx-auto px-4 py-8">

        <a href="{{ route('home') }}" class="mb-6 inline-flex items-center rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-gray-800">
            <span aria-hidden="true">←</span>
            <span class="ml-2">Back</span>
        </a>

        @if ($post->featured_image)
            <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-64 object-cover rounded-lg mb-6">
        @endif

        @if ($post->category)
            <span class="text-xs uppercase tracking-wide text-gray-500">{{ $post->category->name }}</span>
        @endif

        <h1 class="text-3xl font-bold mt-2">{{ $post->title }}</h1>

        <div class="text-sm text-gray-500 mt-2">
            By {{ $post->author->name }} &middot; {{ $post->published_at?->format('M d, Y') }}
            &middot; {{ $post->views_count }} views
        </div>

        <div class="flex flex-wrap gap-2 mt-3">
            @foreach ($post->tags as $tag)
                <a href="{{ route('home', ['tag' => $tag->slug]) }}" class="text-xs bg-gray-100 px-2 py-1 rounded">#{{ $tag->name }}</a>
            @endforeach
        </div>

        <div class="prose max-w-none mt-6">
            {!! nl2br(e($post->content)) !!}
        </div>

        {{-- Like button --}}
        <div class="mt-6">
            @auth
                <form method="POST" action="{{ route('posts.like', $post) }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 border rounded-md {{ $post->likedBy(auth()->user()) ? 'bg-red-50 border-red-300 text-red-600' : '' }}">
                        {{ $post->likedBy(auth()->user()) ? '♥ Liked' : '♡ Like' }} ({{ $post->likes->count() }})
                    </button>
                </form>
            @else
                <p class="text-sm text-gray-500">
                    <a href="{{ route('login') }}" class="underline">Log in</a> to like this post.
                </p>
            @endauth
        </div>

        {{-- Comments --}}
        <div class="mt-10 border-t pt-6">
            <h2 class="text-xl font-semibold mb-4">Comments ({{ $post->comments->count() }})</h2>

            @auth
                <form method="POST" action="{{ route('comments.store', $post) }}" class="mb-6">
                    @csrf
                    <textarea name="body" rows="3" class="w-full rounded-md border-gray-300" placeholder="Add a comment..." required></textarea>
                    <button type="submit" class="mt-2 px-4 py-2 bg-gray-800 text-white rounded-md">Post Comment</button>
                </form>
            @else
                <p class="text-sm text-gray-500 mb-6">
                    <a href="{{ route('login') }}" class="underline">Log in</a> to leave a comment.
                </p>
            @endauth

            @foreach ($post->comments as $comment)
                <div class="border-b py-3">
                    <div class="text-sm font-medium">{{ $comment->user->name ?? $comment->name ?? 'Guest' }}</div>
                    <div class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</div>
                    <p class="mt-1 text-sm">{{ $comment->body }}</p>
                    @if (auth()->id() === $comment->user_id || auth()->user()?->isAdmin())
                        <form method="POST" action="{{ route('comments.destroy', [$post, $comment]) }}" class="mt-1">
                            @csrf @method('DELETE')
                            <button class="text-xs text-red-500">Delete</button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Related posts --}}
        @if ($related->isNotEmpty())
            <div class="mt-10 border-t pt-6">
                <h2 class="text-xl font-semibold mb-4">Related Posts</h2>
                <ul class="space-y-2">
                    @foreach ($related as $rp)
                        <li><a href="{{ route('posts.show', $rp) }}" class="text-blue-600 hover:underline">{{ $rp->title }}</a></li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</x-guest-layout>
