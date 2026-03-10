<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" class="text-gray-700" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full rounded-xl border-pastel-blue/70 focus:border-accent-blue focus:ring-accent-blue" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" class="text-gray-700" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full rounded-xl border-pastel-blue/70 focus:border-accent-blue focus:ring-accent-blue" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" class="text-gray-700" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full rounded-xl border-pastel-blue/70 focus:border-accent-blue focus:ring-accent-blue"
                type="password"
                name="password"
                required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" class="text-gray-700" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-xl border-pastel-blue/70 focus:border-accent-blue focus:ring-accent-blue"
                type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-accent-blue rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-blue" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4 bg-yellow hover:bg-accent-yellow focus:bg-accent-yellow active:bg-accent-yellow text-gray-800 font-bold rounded-xl normal-case tracking-normal">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>