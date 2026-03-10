<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4 rounded-lg bg-green-100/70 border border-green-200 px-3 py-2 text-green-700" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" class="text-gray-700" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full rounded-xl border-pastel-blue/70 focus:border-accent-blue focus:ring-accent-blue" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" class="text-gray-700" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full rounded-xl border-pastel-blue/70 focus:border-accent-blue focus:ring-accent-blue"
                type="password"
                name="password"
                required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-pastel-blue text-accent-blue shadow-sm focus:ring-accent-blue" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
            <a class="underline text-sm text-gray-600 hover:text-accent-blue rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-blue" href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
            </a>
            @endif

            <x-primary-button class="ms-3 bg-yellow hover:bg-accent-yellow focus:bg-accent-yellow active:bg-accent-yellow text-gray-800 font-bold rounded-xl normal-case tracking-normal">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>