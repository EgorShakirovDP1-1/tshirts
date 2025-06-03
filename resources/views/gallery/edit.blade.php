<x-app-layout>
    <div class="max-w-4xl mx-auto py-10">
        <h1 class="text-3xl font-bold mb-6 text-center text-pink-600">✏️ Edit Drawing</h1>

        <form action="{{ route('drawings.update', $drawing->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="relative group flex justify-center items-center mb-8">
                <div class="bg-gradient-to-br from-pink-100 to-pink-200 rounded-3xl p-3 shadow-xl flex justify-center items-center"
                     style="max-width: 420px; max-height: 420px; width: 100%; height: 100%;">
                    <div class="bg-white rounded-2xl shadow-inner flex justify-center items-center w-full h-full"
                         style="padding: 0; display: flex;">
                        <img src="{{ asset('storage/' . $drawing->path_to_drawing) }}"
                             class="w-full h-full max-w-[380px] max-h-[380px] object-contain rounded-2xl"
                             alt="{{ $drawing->name }}">
                    </div>
                </div>
            </div>
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
