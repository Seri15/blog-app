<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
            <a href="{{ route('home') }}" class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                Home
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-white p-4 rounded-lg shadow-sm border">
                <div class="text-2xl font-bold">{{ $stats['total_posts'] }}</div>
                <div class="text-sm text-gray-500">Total Posts</div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-sm border">
                <div class="text-2xl font-bold">{{ $stats['published_posts'] }}</div>
                <div class="text-sm text-gray-500">Published</div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-sm border">
                <div class="text-2xl font-bold">{{ $stats['draft_posts'] }}</div>
                <div class="text-sm text-gray-500">Drafts</div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-sm border">
                <div class="text-2xl font-bold">{{ $stats['total_views'] }}</div>
                <div class="text-sm text-gray-500">Total Views</div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-sm border">
                <div class="text-2xl font-bold">{{ $stats['total_likes'] }}</div>
                <div class="text-sm text-gray-500">Total Likes</div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-sm border">
                <div class="text-2xl font-bold">{{ $stats['total_comments'] }}</div>
                <div class="text-sm text-gray-500">Total Comments</div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-sm border">
                <div class="text-2xl font-bold">{{ $stats['total_authors'] }}</div>
                <div class="text-sm text-gray-500">Authors</div>
            </div>
        </div>

        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <h3 class="text-lg font-semibold">Recent Posts</h3>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.posts.index') }}" class="rounded-md bg-gray-800 px-4 py-2 text-sm font-medium text-white transition hover:bg-gray-700">
                    All Posts
                </a>
                <a href="{{ route('admin.categories.index') }}" class="rounded-md bg-gray-800 px-4 py-2 text-sm font-medium text-white transition hover:bg-gray-700">
                    + Categories
                </a>
                <a href="{{ route('admin.posts.create') }}" class="rounded-md bg-gray-800 px-4 py-2 text-sm font-medium text-white transition hover:bg-gray-700">
                    + New Post
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border divide-y">
            @forelse ($recentPosts as $post)
                <div class="p-4 flex justify-between items-center">
                    <div>
                        <a href="{{ route('admin.posts.edit', $post) }}" class="font-medium hover:underline">{{ $post->title }}</a>
                        <span class="text-xs text-gray-400 ml-1">by {{ $post->author->name }}</span>
                        <span class="text-xs ml-2 px-2 py-0.5 rounded {{ $post->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ ucfirst($post->status) }}
                        </span>
                    </div>
                    <span class="text-sm text-gray-400">{{ $post->created_at->diffForHumans() }}</span>
                </div>
            @empty
                <p class="p-4 text-gray-500">No posts yet.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
