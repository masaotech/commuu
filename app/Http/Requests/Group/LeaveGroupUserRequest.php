<?php

namespace App\Http\Requests\Group;

use App\Common\AuthorizationUtil;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\GroupUser;
use App\Consts\UserRoleConst;
use Illuminate\Support\Facades\Auth;

class LeaveGroupUserRequest extends FormRequest
{
    /**
     * 認可
     */
    public function authorize(): bool
    {
        // 対象グループのメンバーか確認
        $targetGroupIp = $this->request->get("group_id");
        $result = AuthorizationUtil::isGroupMember($targetGroupIp);

        return $result;
    }

    /**
     * バリデーション
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'group_id' => [
                'required',
                // 削除対象ユーザーの確認
                function ($attribute, $value, $fail) {
                    // 削除対象ユーザーの取得
                    $groupUser = GroupUser::where('group_id', '=', $value)
                        ->where('user_id', '=', Auth::user()->id)
                        ->get();

                    // 削除対象のアカウントの存在確認
                    if ($groupUser->count() === 0) {
                        $fail('削除対象のアカウントは存在しませんでした');
                    } elseif ($groupUser->first()->user_role_id == UserRoleConst::ADMIN) {
                        $fail('管理者権限の場合本操作は実施できません。メンバー 一覧から削除してください');
                    }
                }
            ],
        ];
    }
}
