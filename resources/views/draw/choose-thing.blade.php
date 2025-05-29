<x-app-layout>
    <div class="container mx-auto my-10 px-4">
        <h2 class="text-3xl font-bold text-center mb-6">Choose a Thing to Draw On</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($things as $thing)
                @if(\Illuminate\Support\Facades\Storage::disk('public')->exists($thing->path_to_img))
                    <div class="border rounded-lg overflow-hidden shadow hover:shadow-lg transition">
                        <a href="{{ route('draw.fromThing', $thing->id) }}">
                            <img src="{{ asset('storage/' . $thing->path_to_img) }}" alt="Thing Image" class="w-full h-48 object-cover">
                        </a>
                        <div class="p-4 text-center">
                            <a href="{{ route('draw.fromThing', $thing->id) }}" class="text-pink-600 font-medium hover:underline">
                                🖌️ Draw on this
                            </a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</x-app-layout>
