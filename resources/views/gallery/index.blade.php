<x-app-layout>
    <div class="container mx-auto my-8 px-4">
        <!-- Page Title -->
        <h1 class="mb-8 text-center text-candy text-4xl font-extrabold tracking-tight drop-shadow-lg">🍭 Sweet Drawings Gallery 🍬</h1>
        <form method="GET" action="{{ route('drawings.index') }}" class="mb-8">
            <div class="flex flex-wrap justify-center gap-6">
                <!-- Multi-select categories -->
                <div>
                    <label class="block mb-1 font-medium text-gray-700">🗂 Filter by Categories:</label>
                    <select name="categories[]" multiple class="border border-pink-300 rounded-lg px-3 py-2 w-56 focus:ring-2 focus:ring-pink-400">
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
                    <select name="sort" class="border border-pink-300 rounded-lg px-3 py-2 w-56 bg-white text-gray-700 focus:ring-2 focus:ring-pink-400">
                        <option value="date" {{ request('sort') === 'date' ? 'selected' : '' }}>📅 Date</option>
                        <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>⭐ Rating</option>
                    </select>
                </div>

                <!-- Search input -->
                <div>
                    <label class="block mb-1 font-medium text-gray-700">🔍 Search:</label>
                    <div class="flex">
                        <input type="text" name="query" placeholder="Username or drawing name"
                            value="{{ request('query') }}"
                            class="border border-pink-300 rounded-l-lg px-4 py-2 focus:ring-2 focus:ring-pink-400 w-48">
                        <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded-r-lg hover:bg-pink-600 transition">Search</button>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col justify-end gap-2">
                    <button class="bg-pink-500 hover:bg-pink-600 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-300">
                        ✅ Apply Filters
                    </button>
                    <a href="{{ route('drawings.index') }}" class="bg-gray-400 hover:bg-pink-600 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-300 text-center">
                        ❌ Discard Filters
                    </a>
                </div>
            </div>
        </form>

        <!-- Drawings Grid -->
        @if($drawings->isEmpty())
            <p class="text-center text-gray-500 text-lg mt-16">No drawing exists yet.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                @foreach($drawings as $drawing)
                    <div class="flex justify-center">
                        <div class="candy-card flex flex-col h-full w-80">
                            <a href="{{ route('drawings.show', $drawing->id) }}" class="block">
                                <img src="{{ asset('storage/' . $drawing->path_to_drawing) }}" 
                                     class="gallery-img"
                                     alt="{{ $drawing->name }}">
                            </a>
                            <div class="flex-1 flex flex-col justify-between text-center p-5 bg-white rounded-b-2xl">
                                <div>
                                    <h5 class="text-candy text-2xl font-bold mb-2 truncate">{{ $drawing->name }}</h5>
                                    <p class="text-sm text-gray-500 mb-1">👤 <span class="font-medium">{{ $drawing->user->username ?? 'Unknown' }}</span></p>
                                    <p class="text-sm text-gray-500 mb-1">
                                        ⭐ Rating: <span class="font-semibold">{{ $drawing->rating_sum ?? 'N/A' }}</span>
                                    </p>
                                    <p class="text-sm text-gray-400">
                                        📅
                                        {{ $drawing->created_at ? $drawing->created_at->format('d.m.Y') : 'from the beginning of time' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <style>
        .text-candy {
            color: #e75480;
            text-shadow: 1px 1px #ffccdc;
        }
        .candy-card {
            background: linear-gradient(135deg, #fff1f7 60%, #ffe6f0 100%);
            border-radius: 20px;
            box-shadow: 0 8px 24px 0 rgba(255, 182, 193, 0.25);
            transition: transform 0.3s cubic-bezier(.4,2,.3,1), box-shadow 0.3s;
            overflow: hidden;
            min-height: 370px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }
        .candy-card:hover {
            transform: translateY(-8px) scale(1.03);
            box-shadow: 0 16px 32px 0 rgba(231, 84, 128, 0.25);
        }
        .gallery-img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            background: #fff;
            transition: transform 0.4s;
        }
        .gallery-img:hover {
            transform: scale(1.04);
        }
        body {
            background: linear-gradient(135deg, #fff1f7, #ffe6f0);
        }
        </style>
    </div>
</x-app-layout>