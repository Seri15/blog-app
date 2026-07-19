<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Post</h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto px-4">
        <form method="POST" action="{{ route('author.posts.store') }}" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-sm border">
            @include('partials.post-form')
        </form>
    </div>
</x-app-layout>
