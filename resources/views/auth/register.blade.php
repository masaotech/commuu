<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
        </div>

        {{-- 利用規約 --}}
        <div class="mt-4 flex items-center gap-2">
            <input type="hidden" name="accept_terms_of_use" value="0">
            <input type="checkbox" name="accept_terms_of_use" value="1"
                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('termsOfUse') }}" target="_blank">
                利用規約
            </a>
            <span class="text-sm">に同意する</span>
        </div>

        {{-- プライバシーポリシー --}}
        <div class="mt-2 flex items-center gap-2">
            <input type="hidden" name="accept_privacy_policy" value="0">
            <input type="checkbox" name="accept_privacy_policy" value="1"
                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('privacyPolicy') }}" target="_blank">
                プライバシーポリシー
            </a>
            <span class="text-sm">に同意する</span>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
