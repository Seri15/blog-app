<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Posts</h2>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto px-4">
        <div class="flex justify-between mb-4">
            <div class="flex gap-2">
                <a href="{{ route('admin.posts.index') }}" class="px-3 py-1 border rounded {{ !request('status') ? 'bg-gray-800 text-white' : '' }}">All</a>
                <a href="{{ route('admin.posts.index', ['status' => 'published']) }}" class="px-3 py-1 border rounded {{ request('status') === 'published' ? 'bg-gray-800 text-white' : '' }}">Published</a>
                <a href="{{ route('admin.posts.index', ['status' => 'draft']) }}" class="px-3 py-1 border rounded {{ request('status') === 'draft' ? 'bg-gray-800 text-white' : '' }}">Drafts</a>
            </div>
            <a href="{{ route('admin.posts.create') }}" class="px-4 py-2 bg-gray-800 text-white rounded-md text-sm">+ New Post</a>
        </div>

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
                    <tr>
                        <td class="p-3 font-medium">{{ $post->title }}</td>
                        <td class="p-3 text-sm">{{ $post->author->name }}</td>
                        <td class="p-3 text-sm">{{ $post->category->name ?? '—' }}</td>
                        <td class="p-3 text-sm">
                            <span class="px-2 py-0.5 rounded text-xs {{ $post->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ ucfirst($post->status) }}
                            </span>
                        </td>
                        <td class="p-3 text-sm">{{ $post->views_count }}</td>
                        <td class="p-3 text-sm flex gap-2">
                            <a href="{{ route('admin.posts.edit', $post) }}" class="text-blue-600">Edit</a>
                            <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" onsubmit="return confirm('Delete this post?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600">Delete</button>
                            </form>
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
