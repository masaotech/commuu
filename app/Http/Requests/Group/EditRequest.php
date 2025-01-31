<?php

namespace App\Http\Requests\Group;

use App\Common\AuthorizationUtil;
use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
{
    /**
     * 認可
     */
    public function authorize(): bool
    {
        // リクエスト URL から対象のグループIDを取得
        $requestUri = $this->server("REQUEST_URI");
        preg_match("/group\/(?<group_id>\d+)\/edit/", $requestUri, $result);
        $targetGroupId = $result['group_id'];
        
        // 対象グループのメンバーか確認
        $result = AuthorizationUtil::isGroupMember($targetGroupId);
        return $result;
    }

    /**
     * バリデーション
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // nop
        ];
    }
}
