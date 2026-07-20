<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Post</h2>
            <a href="{{ route('author.posts.index') }}" class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto px-4">
        <form method="POST" action="{{ route('author.posts.store') }}" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-sm border">
            @include('partials.post-form')
        </form>
    </div>
</x-app-layout>
