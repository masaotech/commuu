<?php

namespace App\Http\Requests\Group;

use App\Common\AuthorizationUtil;
use Illuminate\Foundation\Http\FormRequest;

class DestroyRequest extends FormRequest
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
        ];
    }
}
