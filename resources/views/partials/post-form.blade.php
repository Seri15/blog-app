@csrf

<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Title</label>
    <input type="text" name="title" value="{{ old('title', $post->title ?? '') }}"
           class="w-full rounded-md border-gray-300" required>
    @error('title') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Excerpt (short summary)</label>
    <textarea name="excerpt" rows="2" class="w-full rounded-md border-gray-300">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
</div>

<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Content</label>
    {{-- Swap this textarea for a rich text editor like Quill/TinyMCE if you want that add-on --}}
    <textarea name="content" id="content" rows="12" class="w-full rounded-md border-gray-300" required>{{ old('content', $post->content ?? '') }}</textarea>
    @error('content') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div class="grid grid-cols-2 gap-4 mb-4">
    <div>
        <label class="block text-sm font-medium mb-1">Category</label>
        <select name="category_id" class="w-full rounded-md border-gray-300">
            <option value="">-- None --</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $post->category_id ?? null) == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Status</label>
        <select name="status" class="w-full rounded-md border-gray-300">
            <option value="draft" @selected(old('status', $post->status ?? 'draft') === 'draft')>Draft</option>
            <option value="published" @selected(old('status', $post->status ?? 'draft') === 'published')>Published</option>
        </select>
    </div>
</div>

<div class="mb-4">
    <label class="block text-sm font-medium mb-1">Featured Image</label>
    @if (isset($post) && $post->featured_image)
        <img src="{{ Storage::url($post->featured_image) }}" class="w-40 h-24 object-cover rounded mb-2">
    @endif
    <input type="file" name="featured_image" accept="image/*">
    @error('featured_image') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md">
    {{ isset($post) ? 'Update Post' : 'Create Post' }}
</button>
