<?php

namespace App\Http\Requests\Group;

use App\Common\AuthorizationUtil;
use App\Common\InfoUtil;
use App\Consts\UserRoleConst;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\GroupUser;

class UpdateUserRoleRequest extends FormRequest
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
            'userRole' => [
                'required',
                // 権限ロールの正当性確認
                function ($attribute, $value, $fail) {
                    if (array_search($value, [UserRoleConst::ADMIN, UserRoleConst::GENERAL]) === false) {
                        $fail($attribute . 'に不正な値が使用されました');
                    }
                },
                // 対象グループの管理者権限者数が 1 以下 かつ 一般権限に変更使用としている場合エラー
                function ($attribute, $value, $fail) {
                    if (InfoUtil::getAdminMemberCount($this->request->get("group_id")) <= 1 and $value == UserRoleConst::GENERAL) {
                        $fail('権限を変更できませんでした（グループには1名以上の「管理者」が必要です）');
                    }
                },
            ],
            'member_id' => [
                'required',
                // 対象メンバーがグループに所属するか確認
                function ($attribute, $value, $fail) {
                    $registered = GroupUser::where('group_id', '=', $this->request->get("group_id"))
                        ->where('user_id', '=', $value)
                        ->get();
                    if ($registered->count() == 0) {
                        // グループに登録されていない場合
                        $fail('不正な操作が行われました');
                    }
                },
            ]
        ];
    }
}
