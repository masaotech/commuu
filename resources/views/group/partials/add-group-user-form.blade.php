@use('App\Consts\UserRoleConst')
<header>
    <h2 class="text-lg font-medium text-gray-900">
        メンバー追加
    </h2>
    <p class="mt-1 text-sm text-gray-600">
        グループへメンバーを追加できます<br>
        グループへ追加するメンバーのメールアドレスと権限を指定してください
    </p>
    <p class="mt-1 text-sm text-gray-600"> ※アカウント作成済のユーザーをメンバー追加可能です </p>
</header>
<form method="post" action="{{ route('group.addUserAccount', ['group' => $group]) }}" class="space-y-3">
    @csrf
    <input type="hidden" name="group_id" value={{ $group->id }} />
    <x-text-input id="mail" name="mail" type="email" class="block w-full" required autocomplete="mail"
        placeholder="メールアドレス" />
    <select name="userRole" class="block w-full border-gray-300 rounded-md" required>
        <option value="" selected disabled>権限を選択</option>
        <option value="{{ UserRoleConst::ADMIN }}">{{ UserRoleConst::ADMIN_NAME }}</option>
        <option value="{{ UserRoleConst::GENERAL }}">{{ UserRoleConst::GENERAL_NAME }}
        </option>
    </select>
    <x-primary-button>グループへ追加</x-primary-button>
</form>
