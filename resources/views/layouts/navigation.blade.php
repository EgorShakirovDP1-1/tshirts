<nav x-data="{ open: false }" class="bg-pink-500 shadow-md border-b border-pink-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Left Side: Logo & Links -->
            <div class="flex items-center space-x-6">
                <!-- Logo -->
               

                <!-- Navigation Links -->
                <div class="hidden md:flex space-x-6">
                <x-nav-link :href="route('welcome')" :active="request()->routeIs('welcome')">
                         home
                    </x-nav-link>
                    <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                        🧑 Profile
                    </x-nav-link>
                    <x-nav-link :href="route('draw')" :active="request()->routeIs('draw')">
                        🎨 Drawings
                    </x-nav-link>
                    <x-nav-link :href="route('profile.create')" :active="request()->routeIs('profile.create')">
                        ➕ Create
                    </x-nav-link>
                    <x-nav-link :href="route('drawings.gallery')" :active="request()->routeIs('drawings.gallery')">
                        🖼️ Gallery
                    </x-nav-link>
                </div>
            </div>
            @auth
            <!-- Right Side: User Dropdown -->
            <div class="hidden md:flex items-center space-x-4">
                <div class="text-white font-semibold">{{ Auth::user()->name }}</div>

                <!-- Dropdown Menu -->
               
<div class="hidden sm:flex sm:items-center sm:ms-6">
    <x-dropdown align="right" width="48">
        <x-slot name="trigger">
            <button class="flex items-center text-white hover:text-gray-200 focus:outline-none">
                <svg class="w-5 h-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 
                        111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                </svg>
            </button>
        </x-slot>

        <x-slot name="content">
            <x-dropdown-link :href="route('profile.edit')">
                ⚙️ {{ __('Profile') }}
            </x-dropdown-link>
            <x-dropdown-link :href="route('draw')">
                🖌️ {{ __('Drawings') }}
            </x-dropdown-link>
            <x-dropdown-link :href="route('profile.create')">
                ➕ {{ __('Create') }}
            </x-dropdown-link>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-dropdown-link :href="route('logout')"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    🚪 {{ __('Log Out') }}
                </x-dropdown-link>
            </form>
        </x-slot>
    </x-dropdown>
    @endauth
</div>



            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button @click="open = !open" class="text-white hover:text-gray-200">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div x-show="open" class="md:hidden bg-pink-100">
        <div class="py-2 space-y-2">
            <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                🧑 Profile
            </x-nav-link>
            
            <x-nav-link :href="route('draw')" :active="request()->routeIs('draw')">
                🎨 Drawings
            </x-nav-link>
            <x-nav-link :href="route('profile.create')" :active="request()->routeIs('profile.create')">
                ➕ Create
            </x-nav-link>
            <x-nav-link :href="route('drawings.gallery')" :active="request()->routeIs('drawings.gallery')">
                🖼️ Gallery
            </x-nav-link>
            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-300 mt-3">
                @csrf
                <x-nav-link :href="route('logout')"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    🚪 {{ __('Log Out') }}
                </x-nav-link>
            </form>
        </div>
    </div>
</nav>
