<x-app-layout>
    <div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded">
        <h2 class="text-lg font-medium text-gray-900">Upload a PNG Thing</h2>

        @if (session('success'))
            <p class="text-green-600">{{ session('success') }}</p>
        @endif

        <form method="POST" action="{{ route('profile.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Image Upload -->
            <div class="mt-4">
                <x-input-label for="image" :value="__('Upload PNG Image')" />
                <x-text-input id="image" type="file" name="image" accept="image/png" class="block mt-1 w-full" required />
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
            </div>
<!-- Select Material -->
<div class="mt-4">
    <x-input-label for="material_id" :value="__('Select Material Type')" />
    <select id="material_id" name="material_id" class="block mt-1 w-full border-gray-300" required>
        <option value="" disabled selected>Choose Material</option>
        @foreach ($materials as $material)
            <option value="{{ $material->id }}">{{ $material->material }}</option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('material_id')" class="mt-2" />
</div>

    

            <div class="mt-4">
                <x-primary-button>{{ __('Upload') }}</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
<!-- http://127.0.0.1:8000/profile/Create/create -->