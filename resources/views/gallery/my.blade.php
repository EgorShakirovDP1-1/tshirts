<x-app-layout>
    <div class="container mx-auto my-5 px-4">
        <!-- Page Title -->
        <h1 class="mb-6 text-center text-candy text-3xl md:text-4xl font-bold">🎨 My Drawings</h1>

        <!-- Drawings Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
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
                            <p class="text-sm text-gray-500">Uploaded on {{ $drawing->created_at ? $drawing->created_at->format('d.m.Y') : 'from the beginning of time' }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-4 text-center">
                    <p class="text-muted">You haven't uploaded any drawings yet. 🎨</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Tailwind + Custom Styles -->
    <style>
    .text-candy {
        color: #e75480;
        text-shadow: 1px 1px #ffccdc;
    }

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

    body {
        background: linear-gradient(135deg, #fff1f7, #ffe6f0);
    }
    </style>
</x-app-layout>
