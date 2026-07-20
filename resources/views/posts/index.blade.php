<x-guest-layout>
    <div class="max-w-6xl mx-auto px-4 py-8">

        <div class="mb-6 flex flex-wrap items-center justify-between gap-3 rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
            <div>
                <h1 class="text-xl font-semibold text-gray-900">Latest Posts</h1>
                <p class="text-sm text-gray-500">Browse stories and join the community.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                @guest
                    <a href="{{ route('login') }}" class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-gray-800">
                        Register
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-gray-800">
                        Dashboard
                    </a>
                @endguest
            </div>
        </div>

        {{-- Search + filters --}}
        <form method="GET" action="{{ route('home') }}" class="mb-8 flex flex-wrap gap-3">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search posts..."
                   class="flex-1 min-w-[200px] rounded-md border-gray-300 shadow-sm">

            <select name="category" class="rounded-md border-gray-300 shadow-sm">
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>
                        {{ $category->name }} ({{ $category->posts_count }})
                    </option>
                @endforeach
            </select>

            <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md">Filter</button>
            @if (request()->hasAny(['q', 'category']))
                <a href="{{ route('home') }}" class="px-4 py-2 border rounded-md">Clear</a>
            @endif
        </form>

        {{-- Post grid --}}
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($posts as $post)
                <article class="border rounded-lg overflow-hidden shadow-sm">
                    @if ($post->featured_image)
                        <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-40 object-cover">
                    @endif
                    <div class="p-4">
                        @if ($post->category)
                            <span class="text-xs uppercase tracking-wide text-gray-500">{{ $post->category->name }}</span>
                        @endif
                        <h2 class="font-semibold text-lg mt-1">
                            {{ $post->title }}
                        </h2>
                        <p class="text-sm text-gray-600 mt-2">{{ Str::limit($post->excerpt ?? strip_tags($post->content), 100) }}</p>
                        <div class="text-xs text-gray-400 mt-3 flex justify-between">
                            <span>{{ $post->author->name }} &middot; {{ $post->published_at?->format('M d, Y') }}</span>
                            <span>{{ $post->views_count }} views &middot; {{ $post->likes->count() }} likes</span>
                        </div>
                    </div>
                </article>
            </a>
            @empty
                <p class="text-gray-500 col-span-full">No posts found.</p>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    </div>
</x-guest-layout>
