<?php

namespace App\Common;

use Illuminate\Support\Facades\Auth;
use App\Models\GroupUser;
use App\Consts\UserRoleConst;

class AuthorizationUtil
{
    /**
     * ログインユーザーが対象グループのメンバーか確認
     * @param int $groupId 対象グループID
     * @return bool true=>グループのメンバーである、false=>グループのメンバーでない
     */
    public static function isGroupMember(int $groupId): bool
    {
        $count = GroupUser::where('user_id', '=', Auth::user()->id)
            ->where('group_id', '=', $groupId)
            ->get()
            ->count();
        return $count === 1;
    }

    /**
     * ログインユーザーが対象グループのメンバーかつ管理者権限か確認
     * @param int $groupId 対象グループID
     * @return bool true=>管理者権限、false=>管理者権限以外
     */
    public static function hasGroupAdminRole(int $groupId): bool
    {
        $count = GroupUser::where('user_id', '=', Auth::user()->id)
            ->where('group_id', '=', $groupId)
            ->where('user_role_id', '=', UserRoleConst::ADMIN)
            ->get()
            ->count();
        return $count === 1;
    }
}
