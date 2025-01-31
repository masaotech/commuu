@use('App\Consts\UserRoleConst')
<x-app-layout>
    <x-slot name="header">
        @if ($userRoleIdOfEditGroup == UserRoleConst::ADMIN)
            グループ設定
        @elseif ($userRoleIdOfEditGroup == UserRoleConst::GENERAL)
            グループ情報
        @endif
    </x-slot>

    <div class="max-w-7xl mx-auto md:lg: sm:px-4px-8 space-y-6">
        {{-- グループ名 編集 --}}
        <div class="p-4 md:p-8 bg-white shadow rounded-lg">
            <div class="max-w-xl">
                @include('group.partials.update-group-information-form')
            </div>
        </div>

        {{-- メンバー編集 --}}
        <div class="p-4 md:p-8 bg-white shadow rounded-lg">
            <div>
                @include('group.partials.update-group-user-form')
            </div>
        </div>

        {{-- メンバー追加 --}}
        @if ($userRoleIdOfEditGroup == UserRoleConst::ADMIN)
            <div class="p-4 md:p-8 bg-white shadow rounded-lg">
                <div class="max-w-xl">
                    @include('group.partials.add-group-user-form')
                </div>
            </div>
        @endif

        {{-- グループ削除 or グループ退会 --}}
        @if ($userRoleIdOfEditGroup == UserRoleConst::ADMIN)
            <div class="p-4 md:p-8 bg-white shadow rounded-lg">
                <div class="max-w-xl">
                    @include('group.partials.delete-group-form')
                </div>
            </div>
        @elseif ($userRoleIdOfEditGroup == UserRoleConst::GENERAL)
            <div class="p-4 md:p-8 bg-white shadow rounded-lg">
                <div class="max-w-xl">
                    @include('group.partials.leave-group-form')
                </div>
            </div>
        @endif

    </div>
</x-app-layout>
