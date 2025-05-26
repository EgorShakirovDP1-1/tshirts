<nav class="fixed bottom-0 left-0 w-full bg-gradient-to-r from-pink-100 via-purple-100 to-blue-100 border-t border-pink-300 shadow-lg z-50">
    <div class="flex justify-around items-center text-sm font-medium text-gray-700">
        <a href="{{ route('drawings.gallery') }}" class="flex flex-col items-center py-2 hover:text-pink-600 transition duration-200">
            <i class="bi bi-images text-pink-500 text-xl"></i>
            <span>Gallery</span>
        </a>
        <a href="{{ route('draw') }}" class="flex flex-col items-center py-2 hover:text-blue-500 transition duration-200">
            <i class="bi bi-brush text-blue-500 text-xl"></i>
            <span>Draw</span>
        </a>
        <a href="{{ route('deliveries.all') }}" class="flex flex-col items-center py-2 hover:text-yellow-500 transition duration-200">
            <i class="bi bi-truck text-yellow-500 text-xl"></i>
            <span>Deliveries</span>
        </a>
        <a href="{{ route('drawings.my') }}" class="flex flex-col items-center py-2 hover:text-green-600 transition duration-200">
            <i class="bi bi-person-badge text-green-500 text-xl"></i>
            <span>My Drawings</span>
        </a>
        <a href="{{ route('profile.edit') }}" class="flex flex-col items-center py-2 hover:text-purple-600 transition duration-200">
            <i class="bi bi-person text-purple-500 text-xl"></i>
            <span>Profile</span>
        </a>
    </div>
</nav>
