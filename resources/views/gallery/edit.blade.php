<x-app-layout>
    <div class="max-w-4xl mx-auto py-10">
        <h1 class="text-3xl font-bold mb-6 text-center text-pink-600">✏️ Edit Drawing</h1>

        <form action="{{ route('drawings.update', $drawing->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="mb-4">
                <label class="block font-semibold text-lg text-gray-700">Drawing Name</label>
                <input type="text" name="name" value="{{ old('name', $drawing->name) }}" class="w-full p-3 border rounded-lg" required>
            </div>

            <!-- Categories Multi-select -->
            <div class="mb-6">
                <label class="block font-semibold text-lg text-gray-700 mb-2">🎯 Categories</label>
                <select name="categories[]" multiple class="w-full p-3 border rounded-lg bg-white">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ in_array($category->id, $drawing->categories->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
                <p class="text-sm text-gray-500 mt-1">Hold Ctrl (or Cmd) to select multiple.</p>
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('drawings.index') }}" class="px-5 py-2 rounded-full border border-gray-400 text-gray-600 hover:bg-gray-100">
                    🔙 Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-pink-500 text-white font-semibold rounded-full hover:bg-pink-600 transition">
                    💾 Save Changes
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
