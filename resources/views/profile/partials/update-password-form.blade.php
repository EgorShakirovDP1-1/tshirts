<section class="bg-gradient-to-tr from-pink-50 to-purple-100 p-6 rounded-xl shadow-lg">
    <header>
        <h2 class="text-xl font-bold text-pink-700 dark:text-pink-300 mb-2">
            {{ __('Update Password') }}
        </h2>
        <p class="text-sm text-purple-700 dark:text-purple-300 mb-4">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-purple-700" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full border-pink-300 focus:border-pink-500 focus:ring-pink-500 rounded-lg" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" class="text-purple-700" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full border-pink-300 focus:border-pink-500 focus:ring-pink-500 rounded-lg" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="text-purple-700" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full border-pink-300 focus:border-pink-500 focus:ring-pink-500 rounded-lg" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-pink-500 hover:bg-pink-600 focus:bg-pink-700 text-white shadow-md transition">{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-pink-600 dark:text-pink-300"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
