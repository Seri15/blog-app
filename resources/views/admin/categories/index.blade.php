<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Categories</h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto px-4">
        <form method="POST" action="{{ route('admin.categories.store') }}" class="flex gap-2 mb-6">
            @csrf
            <input type="text" name="name" placeholder="New category name" class="flex-1 rounded-md border-gray-300" required>
            <button class="px-4 py-2 bg-gray-800 text-white rounded-md">Add</button>
        </form>

        <div class="bg-white rounded-lg shadow-sm border divide-y">
            @forelse ($categories as $category)
                <div class="p-3 flex justify-between items-center">
                    <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="flex gap-2 flex-1">
                        @csrf @method('PUT')
                        <input type="text" name="name" value="{{ $category->name }}" class="rounded-md border-gray-300 text-sm">
                        <span class="text-xs text-gray-400 self-center">{{ $category->posts_count }} posts</span>
                        <button class="text-blue-600 text-sm">Save</button>
                    </form>
                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Delete this category?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 text-sm ml-3">Delete</button>
                    </form>
                </div>
            @empty
                <p class="p-4 text-gray-500">No categories yet.</p>
            @endforelse
        </div>

        <div class="mt-4">{{ $categories->links() }}</div>
    </div>
</x-app-layout>
