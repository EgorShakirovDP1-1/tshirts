<section class="bg-gradient-to-tr from-pink-50 to-purple-100 p-6 rounded-xl shadow-lg">
    <header>
        <h2 class="text-xl font-bold text-pink-700 dark:text-pink-300 mb-2">
            {{ __('Profile Information') }}
        </h2>
        <p class="text-sm text-purple-700 dark:text-purple-300 mb-4">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <!-- Верефикация -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- Аватар -->
    @if(Auth::user()->avatar)
        <div class="mt-6 flex flex-col items-center">
            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Profile Photo" class="w-32 h-32 rounded-full object-cover border-4 border-pink-400 shadow-md transition hover:scale-105 duration-200">
            <form action="{{ route('profile.avatar.delete') }}" method="POST" class="mt-2" onsubmit="return confirm('Are you sure you want to delete your avatar?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:underline hover:text-red-700 transition">❌ Delete avatar</button>
            </form>
        </div>
    @else
        <div class="mt-4 flex justify-center">
            <img src="{{ asset('images/default-avatar.png') }}" alt="Default Photo" class="w-32 h-32 rounded-full object-cover border-4 border-purple-300 shadow-md">
        </div>
    @endif

    <!-- Основная форма -->
    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-8 space-y-6">
        @csrf
        @method('patch')

        <!-- Upload avatar -->
        <div>
            <label for="avatar" class="block font-medium text-pink-700 dark:text-pink-300">Profila attēls</label>
            <input type="file" name="avatar" id="avatar" class="block mt-1 w-full text-purple-700 border-pink-300 focus:border-pink-500 focus:ring-pink-500 rounded-lg shadow-sm" />
        </div>

        <!-- Profile Info -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-purple-700" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full border-pink-300 focus:border-pink-500 focus:ring-pink-500 rounded-lg" :value="old('name', $user->name)" required autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="surname" :value="__('Surname')" class="text-purple-700" />
            <x-text-input id="surname" name="surname" type="text" class="mt-1 block w-full border-pink-300 focus:border-pink-500 focus:ring-pink-500 rounded-lg" :value="old('surname', $user->surname)" />
            <x-input-error class="mt-2" :messages="$errors->get('surname')" />
        </div>

        <div>
            <x-input-label for="username" :value="__('Username')" class="text-purple-700" />
            <x-text-input id="username" name="username" type="text" class="mt-1 block w-full border-pink-300 focus:border-pink-500 focus:ring-pink-500 rounded-lg" :value="old('username', $user->username)" required />
            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-purple-700" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full border-pink-300 focus:border-pink-500 focus:ring-pink-500 rounded-lg" :value="old('email', $user->email)" required />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="phone" :value="__('Phone')" class="text-purple-700" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full border-pink-300 focus:border-pink-500 focus:ring-pink-500 rounded-lg" :value="old('phone', $user->phone)" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-pink-500 hover:bg-pink-600 focus:bg-pink-700 text-white shadow-md transition">{{ __('Save') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)" class="text-sm text-pink-600 dark:text-pink-300">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>

    @if ($errors->any())
        <div class="mt-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative shadow">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</section>
