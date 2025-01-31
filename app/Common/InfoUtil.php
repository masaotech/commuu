<?php

namespace App\Common;

use Illuminate\Support\Facades\Auth;
use App\Models\GroupUser;
use App\Consts\UserRoleConst;

class InfoUtil
{
    /**
     * 対象グループの管理者権限メンバー数を取得
     * @param int $groupId 対象グループID
     * @return int $count
     */
    public static function getAdminMemberCount($groupId): int
    {
        $count = GroupUser::where('group_id', '=', $groupId)
            ->where('user_role_id', '=', UserRoleConst::ADMIN)
            ->get()
            ->count();
        return $count;
    }

    /**
     * 対象グループのメンバー数を取得
     * @param int $groupId 対象グループID
     * @return int $count
     */
    public static function getMemberCount($groupId): int
    {
        $count = GroupUser::where('group_id', '=', $groupId)
            ->get()
            ->count();
        return $count;
    }
}
