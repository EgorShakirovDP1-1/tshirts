<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <!-- Верефикация -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
 <!-- Отображение текущего аватара и кнопка удаления -->
    @if(Auth::user()->avatar)
        <div class="mt-6">
            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Profile Photo" class="w-32 h-32 rounded-full object-cover">

            <!-- Вынесенная форма удаления -->
            <form action="{{ route('profile.avatar.delete') }}" method="POST" class="mt-2" onsubmit="return confirm('Are you sure you want to delete your avatar?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:underline">❌ Delete avatar</button>
            </form>
        </div>
    @else
        <div class="mt-4">
            <img src="{{ asset('images/default-avatar.png') }}" alt="Default Photo" class="w-32 h-32 rounded-full object-cover">
        </div>
    @endif
    <!-- Основная форма обновления профиля -->
    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Upload avatar -->
        <div class="mt-4">
            <label for="avatar">Profila attēls</label>
            <input type="file" name="avatar" id="avatar" class="block mt-1 w-full">
        </div>

        <!-- Profile Info -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Surname -->
        <div>
            <x-input-label for="surname" :value="__('Surname')" />
            <x-text-input id="surname" name="surname" type="text" class="mt-1 block w-full" :value="old('surname', $user->surname)" />
            <x-input-error class="mt-2" :messages="$errors->get('surname')" />
        </div>

        <!-- Username -->
        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username', $user->username)" required />
            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <!-- Phone -->
        <div>
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>

   
</section>
