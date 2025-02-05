<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex justify-end">
            <x-primary-button>
                ログイン
            </x-primary-button>
        </div>

        <div class="mt-2">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    パスワードを忘れた場合はこちら
                </a>
            @endif
        </div>

        <div class="mt-2">
            @if (Route::has('register'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('register') }}">
                    アカウント登録はこちら
                </a>
            @endif
        </div>
    </form>
    {{-- <div class="flex justify-end">
        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            href="{{ route('termsOfUse') }}">
            利用規約
        </a>
        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ms-3"
            href="{{ route('privacyPolicy') }}">
            プライバシーポリシー
        </a>
    </div> --}}
    <hr class="my-8" />
    <h2 class="font-bold">ゲストユーザーで試す方はこちら</h2>
    <div class="flex justify-center gap-2 sm:gap-4 my-4">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input id="email" class="hidden" type="hidden" name="email" value="guest-a@masaotech.com" required />
            <input id="password" class="hidden" type="hidden" name="password" value="z/f|tuwUwzP4$F)%#*NJjguXeZpX+JMy"
                required />
            <button type="submit"
                class="text-xs px-2 sm:px-3 py-2 border border-gray-400 bg-gray-100 rounded-md font-bold text-gray-600 hover:bg-gray-200 focus:bg-gray-200 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                ゲストAでログイン</button>
        </form>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input id="email" class="hidden" type="hidden" name="email" value="guest-b@masaotech.com" required />
            <input id="password" class="hidden" type="hidden" name="password" value="n$8e/W)vGs9R_jUXdYJG$!t#E*3!~6.+"
                required />
            <button type="submit"
                class="text-xs px-2 sm:px-3 py-2 border border-gray-400 bg-gray-100 rounded-md font-bold text-gray-600 hover:bg-gray-200 focus:bg-gray-200 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                ゲストBでログイン</button>
        </form>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input id="email" class="hidden" type="hidden" name="email" value="guest-c@masaotech.com" required />
            <input id="password" class="hidden" type="hidden" name="password" value="g%p77gP|xhdshXJG9cn!jv_u2Q~D|F~C"
                required />
            <button type="submit"
                class="text-xs px-2 sm:px-3 py-2 border border-gray-400 bg-gray-100 rounded-md font-bold text-gray-600 hover:bg-gray-200 focus:bg-gray-200 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                ゲストCでログイン</button>
        </form>
    </div>
    <div class="flex text-xs my-2 text-gray-500">
        <span class="me-1">※</span>
        <span>ゲストユーザーのデータは30分毎にデモ用データに初期化しておりますので、ご自由に更新操作をお試しください</span>
    </div>
    <div class="flex text-xs my-2 text-gray-500">
        <span class="me-1">※</span>
        <span>一部機能を制限しておりますが、本サービスのメイン機能は全てお試し頂けます</span>
    </div>
    <div class="flex text-xs my-2 text-gray-500">
        <span class="me-1">※</span>
        <span>別のゲストユーザーを試す際は、一度ログアウトするか別のブラウザをご利用ください</span>
    </div>
</x-guest-layout>
