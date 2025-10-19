<section>
    <header class="mb-4">
        <h2 class="text-2xl font-bold text-green-800">{{ __('Update Password') }}</h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        {{-- Current password --}}
        <div>
            <label for="update_password_current_password" class="block text-sm font-medium text-gray-700 mb-1">
                {{ __('Current Password') }}
            </label>
            <x-text-input
                id="update_password_current_password"
                name="current_password"
                type="password"
                autocomplete="current-password"
                class="input-style bg-white text-gray-900 dark:bg-white dark:text-gray-900"
            />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1" />
        </div>

        {{-- New password --}}
        <div>
            <label for="update_password_password" class="block text-sm font-medium text-gray-700 mb-1">
                {{ __('New Password') }}
            </label>
            <x-text-input
                id="update_password_password"
                name="password"
                type="password"
                autocomplete="new-password"
                class="input-style bg-white text-gray-900 dark:bg-white dark:text-gray-900"
            />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1" />
        </div>

        {{-- Confirm password --}}
        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                {{ __('Confirm Password') }}
            </label>
            <x-text-input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                autocomplete="new-password"
                class="input-style bg-white text-gray-900 dark:bg-white dark:text-gray-900"
            />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1" />
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="btn-primary">{{ __('Save') }}</button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show:true }" x-show="show" x-transition x-init="setTimeout(()=>show=false,2000)"
                   class="text-sm text-gray-700">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
