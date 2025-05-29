<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-pink-700 dark:text-pink-300 leading-tight tracking-wide drop-shadow">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-tr from-pink-50 to-purple-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 flex flex-col lg:flex-row lg:space-y-0 lg:space-x-8">
            <div class="p-6 bg-white/80 dark:bg-gray-800/80 shadow-lg rounded-2xl border border-pink-100 w-full lg:w-1/2">
                <div class="max-w-xl mx-0"> <!-- убираем auto, добавляем mx-0 для прижатия к левому краю -->
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="flex flex-col w-full lg:w-1/2 space-y-8">
                <div class="p-6 bg-white/80 dark:bg-gray-800/80 shadow-lg rounded-2xl border border-purple-100">
                    <div class="max-w-xl mx-auto">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="p-6 bg-white/80 dark:bg-gray-800/80 shadow-lg rounded-2xl border border-pink-200">
                    <div class="max-w-xl mx-auto">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
