<x-app-layout>
    <x-slot name="header">
        アカウント管理
    </x-slot>

    <div class="">
        <div class="max-w-7xl mx-auto md:px-4 lg:px-8 space-y-6 pb-6">
            {{-- アカウント情報更新 --}}
            <div class="p-4 md:p-8 bg-white shadow rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- パスワード更新 --}}
            <div class="p-4 md:p-8 bg-white shadow rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- アカウント削除 --}}
            <div class="p-4 md:p-8 bg-white shadow rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
