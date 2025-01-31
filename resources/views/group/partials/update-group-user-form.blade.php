@use('App\Consts\UserRoleConst')
<header>
    <h2 class="text-lg font-medium text-gray-900">
        メンバー 一覧
    </h2>
    @if ($userRoleIdOfEditGroup == UserRoleConst::ADMIN)
        <p class="mt-1 mb-2 text-sm text-gray-600">
            グループに所属するメンバの権限更新およびグループから削除ができます
        </p>
    @endif
</header>
<div class="overflow-x-auto rounded-lg border">
    <table class="w-full text-sm text-left rtl:text-right text-gray-700 rounded-md">
        <thead class="bg-gray-100 ">
            <tr>
                <th scope="col" class="p-2 sm:px-4 min-w-24">メンバー名</th>
                <th scope="col" class="p-2 sm:px-4 min-w-44">メールアドレス</th>
                <th scope="col" class="p-2 sm:px-4 min-w-44">権限</th>
                @if ($userRoleIdOfEditGroup == UserRoleConst::ADMIN)
                    <th scope="col" class="p-2 sm:px-4 min-w-20">削除</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($group->users as $user)
                <tr class="border-t">
                    {{-- メンバー名 --}}
                    <td class="p-2 sm:px-4">{{ $user->name }}</td>

                    {{-- メールアドレス --}}
                    <td class="p-2 sm:px-4">{{ $user->email }}</td>

                    {{-- 権限 --}}
                    @php
                        $userRoleId = $user->pivot->userRole->id;
                        $isAdmin = $userRoleId == UserRoleConst::ADMIN;
                        $isGeneral = $userRoleId == UserRoleConst::GENERAL;
                    @endphp
                    @if ($userRoleIdOfEditGroup == UserRoleConst::ADMIN)
                        <td class="p-2 sm:px-4">
                            <form method="post" action="{{ route('group.updateUserRole', ['group' => $group]) }}">
                                @csrf
                                @method('patch')
                                <input type="hidden" name="group_id" value="{{ $group->id }}" />
                                <input type="hidden" name="member_id" value="{{ $user->id }}">
                                <input type="hidden" name="member_name" value="{{ $user->name }}">
                                <select name="userRole" class="text-sm border-gray-400 rounded-md me-1" required>

                                    <option value="{{ UserRoleConst::ADMIN }}" @selected($isAdmin)>
                                        {{ UserRoleConst::ADMIN_NAME }}</option>
                                    <option value="{{ UserRoleConst::GENERAL }}" @selected($isGeneral)>
                                        {{ UserRoleConst::GENERAL_NAME }}
                                    </option>
                                </select>
                                <x-primary-button>変更</x-primary-button>
                            </form>
                        </td>
                    @elseif ($userRoleIdOfEditGroup == UserRoleConst::GENERAL)
                        <td class="p-2 sm:px-4">
                            <div class="py-2">
                                @if ($isAdmin)
                                    {{ UserRoleConst::ADMIN_NAME }}
                                @elseif($isGeneral)
                                    {{ UserRoleConst::GENERAL_NAME }}
                                @endif
                            </div>
                        </td>
                    @endif

                    {{-- 削除 --}}
                    @if ($userRoleIdOfEditGroup == UserRoleConst::ADMIN)
                        <td class="p-2 sm:px-4">
                            <x-danger-button x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-group-deletion-{{ $user->id }}')">削除</x-danger-button>
                            <x-modal name="confirm-group-deletion-{{ $user->id }}" focusable>
                                <form method="post" class="p-6"
                                    action="{{ route('group.destroyGroupUser', ['group' => $group]) }}">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" name="group_id" value="{{ $group->id }}" />
                                    <input type="hidden" name="member_id" value="{{ $user->id }}">
                                    <input type="hidden" name="member_name" value="{{ $user->name }}">
                                    <h2 class="text-lg font-medium text-gray-900">
                                        「{{ $user->name }}」を「{{ $group->name }}」のメンバーから削除します<br>
                                        よろしいですか？
                                    </h2>
                                    <div class="mt-6 flex justify-end">
                                        <x-secondary-button x-on:click="$dispatch('close')">
                                            キャンセル
                                        </x-secondary-button>
                                        <x-danger-button class="ms-3">
                                            削除
                                        </x-danger-button>
                                    </div>
                                </form>
                            </x-modal>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
