<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Posts</h2>
            <a href="{{ route('author.dashboard') }}" class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto px-4">
        <div class="flex justify-between mb-4 flex-wrap gap-2">
            <div class="flex gap-2">
                <a href="{{ route('author.posts.index', ['status' => null]) }}" class="px-3 py-1 border rounded {{ !request('status') ? 'bg-gray-800 text-white' : '' }}">All Status</a>
                <a href="{{ route('author.posts.index', ['status' => 'published']) }}" class="px-3 py-1 border rounded {{ request('status') === 'published' ? 'bg-gray-800 text-white' : '' }}">Published</a>
                <a href="{{ route('author.posts.index', ['status' => 'draft']) }}" class="px-3 py-1 border rounded {{ request('status') === 'draft' ? 'bg-gray-800 text-white' : '' }}">Drafts</a>
            </div>
            <a href="{{ route('author.posts.create') }}" class="px-4 py-2 bg-gray-800 text-white rounded-md text-sm">+ New Post</a>
        </div>

        <p class="text-xs text-gray-400 mb-3">You can browse every author's posts here, but you can only edit or delete your own.</p>

        @if (session('status'))
            <div class="mb-4 p-3 bg-green-50 text-green-700 rounded">{{ session('status') }}</div>
        @endif

        <table class="w-full bg-white rounded-lg shadow-sm border">
            <thead class="bg-gray-50 text-left text-sm text-gray-500">
                <tr>
                    <th class="p-3">Title</th>
                    <th class="p-3">Author</th>
                    <th class="p-3">Category</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Views</th>
                    <th class="p-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($posts as $post)
                    @php $isMine = $post->user_id === auth()->id(); @endphp
                    <tr class="{{ $isMine ? '' : 'bg-gray-50/50' }}">
                        <td class="p-3 font-medium">{{ $post->title }}</td>
                        <td class="p-3 text-sm">
                            {{ $post->author->name }}
                            @if ($isMine)
                                <span class="text-xs bg-blue-100 text-blue-700 px-1.5 py-0.5 rounded ml-1">You</span>
                            @endif
                        </td>
                        <td class="p-3 text-sm">{{ $post->category->name ?? '—' }}</td>
                        <td class="p-3 text-sm">
                            <span class="px-2 py-0.5 rounded text-xs {{ $post->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ ucfirst($post->status) }}
                            </span>
                        </td>
                        <td class="p-3 text-sm">{{ $post->views_count }}</td>
                        <td class="p-3 text-sm">
                            @if ($isMine)
                                <div class="flex gap-2">
                                    <a href="{{ route('author.posts.edit', $post) }}" class="text-blue-600">Edit</a>
                                    <form method="POST" action="{{ route('author.posts.destroy', $post) }}" onsubmit="return confirm('Delete this post?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600">Delete</button>
                                    </form>
                                </div>
                            @else
                                <span class="text-xs text-gray-400">Not yours</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="p-4 text-gray-500">No posts yet.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $posts->links() }}</div>
    </div>
</x-app-layout>
