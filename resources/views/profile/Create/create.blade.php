<x-app-layout>
<div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded">
    <h2 class="text-lg font-medium text-gray-900">Upload a PNG Thing</h2>

    @if (session('success'))
        <p class="text-green-600">{{ session('success') }}</p>
    @endif

    <form id="uploadForm" method="POST" action="{{ route('thing.store') }}">
        @csrf

        <!-- Image Upload -->
        <div class="mt-4">
            <x-input-label for="image" :value="__('Upload Image (PNG, JPG, JPEG, WEBP)')" />
            <input id="image" name="image" type="file" accept="image/png,image/jpeg,image/jpg,image/webp" class="block mt-1 w-full" required>
            <x-input-error :messages="$errors->get('image')" class="mt-2" />
        </div>

        <!-- Preview + Hidden -->
        <div class="mt-4">
            <p class="text-sm text-gray-500 mb-2">Preview:</p>
            <canvas id="previewCanvas" class="border border-gray-300 rounded" style="max-width:100%; height:auto;"></canvas>
            <input type="hidden" name="compressed_image" id="compressedImageInput">
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
            <x-primary-button type="submit">{{ __('Upload') }}</x-primary-button>
        </div>
    </form>
</div>

<script>
const uploadForm = document.getElementById('uploadForm');
const imageInput = document.getElementById('image');
const previewCanvas = document.getElementById('previewCanvas');
const ctx = previewCanvas.getContext('2d');
const compressedImageInput = document.getElementById('compressedImageInput');

// Показывать превью при выборе файла
imageInput.addEventListener('change', function () {
    const file = imageInput.files[0];
    if (!file) return;

    const allowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'];
    if (!allowedTypes.includes(file.type)) {
        alert('Unsupported file format!');
        return;
    }

    const reader = new FileReader();
    reader.onload = function (e) {
        const img = new Image();
        img.onload = function () {
            const maxSize = 800;
            let width = img.width;
            let height = img.height;

            if (width > maxSize || height > maxSize) {
                const ratio = Math.min(maxSize / width, maxSize / height);
                width *= ratio;
                height *= ratio;
            }

            previewCanvas.width = width;
            previewCanvas.height = height;
            ctx.clearRect(0, 0, width, height);
            ctx.drawImage(img, 0, 0, width, height);
        };
        img.src = e.target.result;
    };
    reader.readAsDataURL(file);
});

uploadForm.addEventListener('submit', function (e) {
    e.preventDefault();

    const file = imageInput.files[0];
    if (!file) {
        alert('Please select an image!');
        return;
    }

    const allowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'];
    if (!allowedTypes.includes(file.type)) {
        alert('Unsupported file format!');
        return;
    }

    const reader = new FileReader();
    reader.onload = function (e) {
        const img = new Image();
        img.onload = function () {
            const maxSize = 800;
            let width = img.width;
            let height = img.height;

            if (width > maxSize || height > maxSize) {
                const ratio = Math.min(maxSize / width, maxSize / height);
                width *= ratio;
                height *= ratio;
            }

            previewCanvas.width = width;
            previewCanvas.height = height;
            ctx.clearRect(0, 0, width, height);
            ctx.drawImage(img, 0, 0, width, height);

            previewCanvas.toBlob(function (blob) {
                const finalReader = new FileReader();
                finalReader.onloadend = function () {
                    compressedImageInput.value = finalReader.result;
                    uploadForm.submit();
                };
                finalReader.readAsDataURL(blob);
            }, 'image/png', 0.8);
        };
        img.src = e.target.result;
    };
    reader.readAsDataURL(file);
});
</script>
</x-app-layout>
