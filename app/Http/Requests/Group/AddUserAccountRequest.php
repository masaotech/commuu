<?php

namespace App\Http\Requests\Group;

use App\Common\AuthorizationUtil;
use App\Consts\UserRoleConst;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use App\Models\GroupUser;

class AddUserAccountRequest extends FormRequest
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
            'mail' => [
                'required',
                'email',
                // 招待されたアカウントの存在チェック＆グループ登録状況チェック
                function ($attribute, $value, $fail) {
                    $invitaionUser = User::where('email', '=', $value)->get();
                    if ($invitaionUser->count() === 0) {
                        // アカウントが存在しない場合
                        $fail('入力されたメールアドレスのアカウントは存在しませんでした');
                    } else {
                        // アカウントが存在する場合
                        $registered = GroupUser::where('group_id', '=', $this->request->get("group_id"))
                            ->where('user_id', '=', $invitaionUser->first()->id)
                            ->get();
                        if ($registered->count() > 0) {
                            // グループに登録済の場合
                            $fail('入力されたメールアドレスのアカウントは既にこのグループに登録されています');
                        }
                    }
                },
            ],
            'userRole' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (array_search($value, [UserRoleConst::ADMIN, UserRoleConst::GENERAL]) === false) {
                        $fail($attribute . 'に不正な値が使用されました');
                    }
                },
            ],
        ];
    }
}
