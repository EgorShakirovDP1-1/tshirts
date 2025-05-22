<x-app-layout>
    <div class="max-w-6xl mx-auto my-10 px-4">
       <!-- Action Buttons -->
<div class="mb-6 flex flex-wrap gap-4">
    <a href="{{ route('drawings.index') }}" 
       class="inline-flex items-center px-4 py-2 border-2 border-pink-500 text-pink-500 font-semibold text-lg rounded-full hover:bg-pink-500 hover:text-white transition duration-300 shadow-lg">
        🔙 Back to Gallery
    </a>

    @can('update', $drawing)
        <a href="{{ route('drawings.edit', $drawing->id) }}" 
           class="inline-flex items-center px-4 py-2 border-2 border-yellow-500 text-yellow-500 font-semibold text-lg rounded-full hover:bg-yellow-500 hover:text-white transition duration-300 shadow-lg">
            ✏️ Edit Drawing
        </a>
    @endcan
</div>
        </div>
        <!-- Drawing Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
            <!-- Image -->
            <div class="relative group">
                <div class="bg-gradient-to-br from-pink-100 to-pink-200 rounded-3xl p-4 shadow-xl">
                    <img src="{{ asset('storage/' . $drawing->path_to_drawing) }}" 
                         class="w-full h-96 object-contain rounded-2xl bg-white"
                         alt="{{ $drawing->name }}">
                </div>
            </div>

            <!-- Info Section -->
            <div class="text-center md:text-left">
                <h1 class="text-4xl font-bold text-candy mb-5">{{ $drawing->name }}</h1>

                <p class="text-xl text-gray-600 mb-3">
                    🎨 <strong>Artist:</strong> {{ optional($drawing->user)->username ?? 'Unknown' }}
                </p>
                <p class="text-xl text-gray-600 mb-3">
                    📅 <strong>Uploaded on:</strong> {{ $drawing->created_at->format('F j, Y') }}
                </p>
                <p class="text-xl text-gray-600 mb-6">
                    🆔 <strong>Drawing ID:</strong> #{{ $drawing->id }}
                </p>
@auth
    @if(auth()->id() === $drawing->user_id && $drawing->thing->isNotEmpty())
        <form action="{{ route('drawings.parcel-map', $drawing) }}" method="GET" class="inline">
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                delivery
            </button>
        </form>
    @endif
@endauth

                <!-- Action Buttons -->
                <div class="flex justify-center md:justify-start gap-4">
    <!-- Like Button -->
    <form action="{{ route('drawings.like', $drawing->id) }}" method="POST">
        @csrf
        <input type="hidden" name="rating" value="1">
        <button type="submit"
                class="px-5 py-3 bg-pink-500 text-white font-semibold rounded-full shadow-lg 
                       hover:bg-pink-600 transition duration-300 
                       {{ optional($drawing->userReaction())->rating === 1 ? 'opacity-50' : '' }}">
            ❤️ Like ({{ $drawing->likes_count }})
        </button>
    </form>

    <!-- Dislike Button -->
    <form action="{{ route('drawings.like', $drawing->id) }}" method="POST">
        @csrf
        <input type="hidden" name="rating" value="-1">
        <button type="submit"
                class="px-5 py-3 bg-gray-500 text-white font-semibold rounded-full shadow-lg 
                       hover:bg-gray-600 transition duration-300 
                       {{ optional($drawing->userReaction())->rating === -1 ? 'opacity-50' : '' }}">
            👎 Dislike ({{ $drawing->dislikes_count }})
        </button>
    </form>
</div>

<div class="mt-10">
    
    <h2 class="text-2xl font-bold text-gray-800 mb-4">💬 Comments</h2>

    <!-- Comment Form (Only for Authenticated Users) -->
    @auth
    <form action="{{ route('comments.store', $drawing->id) }}" method="POST" class="mb-6">
        @csrf
        <textarea name="text" rows="3" class="w-full p-3 border rounded-lg" placeholder="Write a comment..." required></textarea>
        <button type="submit" class="mt-2 px-5 py-2 bg-blue-500 text-white font-semibold rounded shadow hover:bg-blue-600">
            ✏️ Add Comment
        </button>
    </form>
    @endauth

    <!-- Comments List -->
    @forelse($drawing->comments as $comment)
        <div class="mb-4 p-4 border rounded-lg bg-gray-100">
        <p class="text-gray-800"><strong>{{ optional($comment->user)->username ?? 'Vitaliy Serebokin' }}</strong> said:</p>
<img src="{{ $comment->user->avatar_url }}" class="w-12 h-12 rounded-full object-cover" alt="User Avatar">


            <p class="text-gray-700">{{ $comment->text }}</p>
            <p class="text-gray-500 text-sm">🕒 {{ $comment->created_at->diffForHumans() }}</p>

            @auth
                @if(auth()->id() === $comment->user_id)
                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm">🗑 Delete</button>
                    </form>
                @endif
            @endauth
        </div>
    @empty
        <p class="text-gray-500">No comments yet. Be the first to comment! ✨</p>
    @endforelse
</div>

                    

                    <!-- New Action Button -->
                    <!-- filepath: resources/views/gallery/show.blade.php -->

                </div>
            </div>
        </div>
    </div>

    <!-- Custom Styles -->
    <style>
    /* Candy-Themed Text */
    .text-candy {
        color: #e75480; /* Hot pink */
        text-shadow: 2px 2px #ffccdc;
    }

    /* Body Background */
    body {
        background: linear-gradient(135deg, #fff1f7, #ffe6f0);
        font-family: 'Poppins', sans-serif;
    }

    /* Image Hover Effect */
    .image-hover:hover {
        transform: scale(1.05);
    }
    </style>
</x-app-layout>
