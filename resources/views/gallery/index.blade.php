<x-app-layout>
    <div class="container mx-auto my-5 px-4">
        <!-- Page Title -->
        <h1 class="mb-6 text-center text-candy text-3xl md:text-4xl font-bold">🍭 Sweet Drawings Gallery 🍬</h1>
        <form method="GET" action="{{ route('drawings.index') }}" class="mb-6 text-center">
    <div class="flex justify-center flex-wrap gap-4">
        <!-- Multi-select categories -->
        <div>
            <label class="block mb-1 font-medium text-gray-700">🗂 Filter by Categories:</label>
            <select name="categories[]" multiple class="border rounded px-3 py-2 w-64">
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" 
                        {{ in_array($cat->id, request('categories', [])) ? 'selected' : '' }}>
                        {{ $cat->category_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Sort dropdown -->
        <div>
            <label class="block mb-1 font-medium text-gray-700">🔽 Sort by:</label>
            <select name="sort" class="border border-gray-300 rounded-lg px-3 py-2 w-64 bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-pink-300">
                <option value="date" {{ request('sort') === 'date' ? 'selected' : '' }}>📅 Date</option>
                <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>⭐ Rating</option>
            </select>
        </div>

        <!-- Search input -->
        <div class="flex items-end">
            <input type="text" name="query" placeholder="Search by username or drawing name"
                value="{{ request('query') }}"
                class="border border-gray-300 rounded-l px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-300">
            <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded-r hover:bg-pink-600">
                Search
            </button>
        </div>

        <!-- Buttons -->
        <div class="flex items-end gap-2">
            <button class="bg-pink-500 hover:bg-pink-600 text-white font-semibold py-2 px-4 rounded-full shadow-md transition duration-300">
                ✅ Apply Filters
            </button>
            <a href="{{ route('drawings.index') }}" class="bg-gray-500 hover:bg-pink-600 text-white font-semibold py-2 px-4 rounded-full shadow-md transition duration-300 inline-block">
                ❌ Discard Filters
            </a>
        </div>
    </div>
</form>

        <!-- Drawings Grid -->
         <!-- search results -->
         @if($drawings->isEmpty())
    <p class="text-center text-gray-500">No drawing exists yet.</p>
@else
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($drawings as $drawing)
            <div class="flex justify-center">
                <div class="max-w-xs candy-card hover:shadow-lg">
                    <a href="{{ route('drawings.show', $drawing->id) }}" class="block">
                        <img src="{{ asset('storage/' . $drawing->path_to_drawing) }}" 
                             class="gallery-img" 
                             alt="{{ $drawing->name }}">
                    </a>
                    <div class="text-center p-4">
                        <h5 class="text-candy text-xl font-semibold mb-2">{{ $drawing->name }}</h5>
                        <p class="text-sm text-gray-500">Author: {{ $drawing->user->username ?? 'Unknown' }}</p>
                        <p class="text-sm text-gray-500">Rating: {{ $drawing->likes_count ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-500">Date: {{ $drawing->created_at->format('d.m.Y') }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
<!-- end search results -->

       

    <!-- Tailwind + Custom Styles -->
    <style>
    /* Candy-Themed Text */
    .text-candy {
        color: #e75480; /* Hot pink */
        text-shadow: 1px 1px #ffccdc;
    }

    /* Candy-Themed Card */
    .candy-card {
        background: #44444444; /* Dark gray */
        border-radius: 15px;
        box-shadow: 0 6px 10px rgba(255, 182, 193, 0.6);
        transition: transform 0.3s ease;
        overflow: hidden;
    }

    .candy-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 15px rgba(255, 105, 180, 0.6);
    }

    /* Gallery Images */
    .gallery-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        transition: transform 0.5s ease;
    }

    .gallery-img:hover {
        transform: scale(1.05);
    }

    /* Body Background */
    body {
        background: linear-gradient(135deg, #fff1f7, #ffe6f0);
    }
    </style>
</x-app-layout>
