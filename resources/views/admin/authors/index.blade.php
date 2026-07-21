<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manage Authors</h2>
            <a href="{{ route('admin.dashboard') }}" class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-lg shadow-sm border divide-y">
            @forelse ($authors as $author)
                <div class="p-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <div>
                        <div class="font-medium text-gray-900">{{ $author->name }}</div>
                        <div class="text-sm text-gray-500">{{ $author->email }}</div>
                        <div class="text-xs text-gray-400 mt-1">{{ $author->posts_count }} posts</div>
                    </div>

                    <form method="POST" action="{{ route('admin.authors.destroy', $author) }}" onsubmit="return confirm('Delete this author account?')">
                        @csrf
                        @method('DELETE')
                        <button class="rounded-md bg-red-600 px-3 py-2 text-sm font-medium text-white transition hover:bg-red-700">
                            Delete Account
                        </button>
                    </form>
                </div>
            @empty
                <p class="p-4 text-gray-500">No authors found.</p>
            @endforelse
        </div>

        <div class="mt-4">{{ $authors->links() }}</div>
    </div>
</x-app-layout>
