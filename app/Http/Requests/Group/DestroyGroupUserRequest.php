<?php

namespace App\Http\Requests\Group;

use App\Common\AuthorizationUtil;
use App\Common\InfoUtil;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\GroupUser;
use App\Consts\UserRoleConst;

class DestroyGroupUserRequest extends FormRequest
{
    /**
     * 認可
     */
    public function authorize(): bool
    {
        // 対象グループの管理者権限か確認
        $targetGroupIp = $this->request->get("group_id");
        $result = AuthorizationUtil::hasGroupAdminRole($targetGroupIp);

        return $result;
    }

    /**
     * バリデーション
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'group_id' => ['required'],
            'member_id' => [
                'required',
                // 削除対象ユーザーの確認
                function ($attribute, $value, $fail) {
                    // 対象ユーザーの取得
                    $groupUser = GroupUser::where('group_id', '=', $this->request->get("group_id"))
                        ->where('user_id', '=', $value)
                        ->get();

                    // 削除対象のアカウントの存在確認
                    if ($groupUser->count() === 0) {
                        $fail('削除対象のアカウントは存在しませんでした');
                    } else {

                        // 対象グループのメンバー数が2名以上いることの確認
                        if (InfoUtil::getMemberCount($this->request->get("group_id")) <= 1) {
                            $fail('メンバーを削除できませんでした（グループには1名以上のメンバーが必要です）');
                        }


                        // 対象グループの管理者が1名以上残る事の確認
                        if (
                            InfoUtil::getAdminMemberCount($this->request->get("group_id")) == 1
                            and $groupUser->first()->user_role_id == UserRoleConst::ADMIN
                        ) {
                            // グループに管理者権限ユーザーが1名のみ かつ 削除対象のユーザーが管理者権限 の場合
                            $fail('メンバーを削除できませんでした（グループには1名以上の管理者権限メンバーが必要です）');
                        }
                    }
                }
            ],
        ];
    }
}
