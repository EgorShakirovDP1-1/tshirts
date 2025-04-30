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
            <select name="sort" class="border rounded px-3 py-2">
                <option value="date" {{ request('sort') === 'date' ? 'selected' : '' }}>📅 Date</option>
                <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>⭐ Rating</option>
            </select>
        </div>

        <!-- Submit -->
        <div class="flex items-end">
            <button type="submit" class="px-4 py-2 bg-pink-500 text-white rounded hover:bg-pink-600 mt-6">
                ✅ Apply Filters
            </button>
        </div>
        <a href="{{ route('drawings.index') }}" 
           class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 mt-6">
            ❌ Discard Filters
        </a>
    </div>
</form>


        <!-- Search Form -->
        <form action="{{ route('drawings.search') }}" method="GET" class="mb-6">
    <div class="flex justify-center">
        <input type="text" name="query" placeholder="Поиск по имени пользователя или рисунка"
               class="border border-gray-300 rounded-l px-4 py-2 w-1/2 focus:outline-none focus:ring-2 focus:ring-pink-300">
        <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded-r hover:bg-pink-600">
            Поиск
        </button>
    </div>
</form>
        <!-- Filter by Category -->
        
        <!-- Drawings Grid -->
         <!-- search results -->
         @if($drawings->isEmpty())
    <p class="text-center text-gray-500">Ничего не найдено.</p>
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
                        <p class="text-sm text-gray-500">Автор: {{ $drawing->user->username ?? 'Неизвестно' }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
<!-- end search results -->
        <!-- Drawings Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($drawings as $drawing)
                <div class="flex justify-center">
                    <div class="max-w-xs candy-card hover:shadow-lg">
                        <a href="{{ route('drawings.show', $drawing->id) }}" class="block">
                            <img src="{{ asset('storage/' . $drawing->path_to_drawing) }}" 
                                 class="gallery-img" 
                                 alt="{{ $drawing->name }}">
                        </a>
                        <div class="text-center p-4">
                            <h5 class="text-candy text-xl font-semibold mb-2">{{ $drawing->name }}</h5>
                            <p class="text-sm text-gray-500">By {{ $drawing->user->username ?? 'Unknown' }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center">
                    <p class="text-muted">No drawings found. 🎨</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Tailwind + Custom Styles -->
    <style>
    /* Candy-Themed Text */
    .text-candy {
        color: #e75480; /* Hot pink */
        text-shadow: 1px 1px #ffccdc;
    }

    /* Candy-Themed Card */
    .candy-card {
        background: linear-gradient(135deg, #ffe6f0, #ffd6eb);
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
