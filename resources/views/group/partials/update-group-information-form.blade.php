@use('App\Consts\UserRoleConst')
@php
    $isNotAdmin = $userRoleIdOfEditGroup != UserRoleConst::ADMIN;
@endphp
<header>
    <h2 class="text-lg font-medium text-gray-900">
        グループ名
    </h2>
    @if ($userRoleIdOfEditGroup == UserRoleConst::ADMIN)
        <p class="mt-1 mb-2 text-sm text-gray-600">
            グループ名を更新できます
        </p>
    @endif
</header>
<form method="post" action="{{ route('group.update', ['group' => $group]) }}">
    @csrf
    @method('patch')
    <input type="hidden" name="group_id" value={{ $group->id }} />
    <div class="grid sm:grid-cols-2 gap-x-4 gap-y-2">
        <div>
            <x-text-input id="name" name="name" type="text" class="w-full" :value="old('name', $group->name)" required
                autocomplete="name" :disabled="$isNotAdmin"/>
        </div>
        @if ($userRoleIdOfEditGroup == UserRoleConst::ADMIN)
            <div>
                <x-primary-button>変更</x-primary-button>
            </div>
        @endif
    </div>
</form>
