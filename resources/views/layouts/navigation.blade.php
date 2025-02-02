<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 md:px-4 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- 【640px～ で表示】ナビバー左側 --}}
            <div class="flex">
                {{-- アプリロゴ --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('rootUrl') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-700" />
                    </a>
                </div>

                {{-- アプリケーションメニュ --}}
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @php
                        $isActiveShopping = request()->routeIs('shoppingitem.index') || request()->routeIs('shoppingitem.edit');
                        $isActiveHabit = request()->routeIs('habititem.index') || request()->routeIs('habititem.edit');
                        $isActiveDeclutter = request()->routeIs('declutter.index');
                    @endphp
                    <x-nav-link :href="route('shoppingitem.index')" :active="$isActiveShopping">
                        @include('icon.shopping-icon')
                        <span class="ms-2">買い物リスト</span>
                    </x-nav-link>
                    <x-nav-link :href="route('habititem.index')" :active="$isActiveHabit">
                        @include('icon.habit-todo-icon')
                        <span class="ms-2">定期To-Do</span>
                    </x-nav-link>
                    <x-nav-link :href="route('declutter.index')" :active="$isActiveDeclutter">
                        @include('icon.declutter-icon')
                        <span class="ms-2">断捨離サポート</span>
                    </x-nav-link>
                </div>
            </div>

            {{-- 【640px～ で表示】ナビバー右側 --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                {{-- グループ名のドロップダウンリスト --}}
                @isset($userRegisteredGroups)
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ $currentGroupName }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            {{ $userRegisteredGroups }}
                        </x-slot>
                    </x-dropdown>
                @endisset

                {{-- ユーザー名のドロップダウンリスト --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    {{-- 設定＆ログアウト --}}
                    <x-slot name="content">
                        <div class="space-y-1">
                            <x-dropdown-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                                アカウント管理
                            </x-dropdown-nav-link>
                            <x-dropdown-nav-link :href="route('group.index')" :active="request()->routeIs('group.index')">
                                グループ管理
                            </x-dropdown-nav-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-nav-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    ログアウト
                                </x-dropdown-nav-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- 【～639px で表示】ハンバーガーメニュー --}}
            <div class="-me-2 flex items-center sm:hidden">
                @isset($userRegisteredGroups)
                    <x-dropdown align="right" width="48" class="me-3">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ $currentGroupName }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            {{ $userRegisteredGroups }}
                        </x-slot>
                    </x-dropdown>
                @endisset
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- 【～639px で表示】ハンバーガーメニュー展開時 --}}
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-700">{{ Auth::user()->name }}</div>
            </div>
            {{-- 設定＆ログアウト --}}

            <div class="mt-3 space-y-2">
                <x-dropdown-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                    アカウント管理
                </x-dropdown-nav-link>
                <x-dropdown-nav-link :href="route('group.index')" :active="request()->routeIs('group.index')">
                    グループ管理
                </x-dropdown-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        ログアウト
                    </x-dropdown-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
