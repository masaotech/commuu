<?php

namespace App\Http\Requests\Group;

use App\Common\AuthorizationUtil;
use Illuminate\Foundation\Http\FormRequest;

class ChangeCurrentGroupRequest extends FormRequest
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
            'group_id' => ['required'],
        ];
    }
}
