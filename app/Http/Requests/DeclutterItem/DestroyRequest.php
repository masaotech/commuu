<?php

namespace App\Http\Requests\DeclutterItem;

use App\Common\AuthorizationUtil;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\DeclutterItem;

class DestroyRequest extends FormRequest
{
    /**
     * 認可
     */
    public function authorize(): bool
    {
        $declutterItem = DeclutterItem::find($this->request->get("item_id"));

        // 【バリデーション】対象データの存在確認
        if ($declutterItem === null) return false;

        // 更新対象データのグループIDを取得
        $targetGroupId = $declutterItem->group_id;

        // 【バリデーション】対象データのグループメンバーか確認
        return AuthorizationUtil::isGroupMember($targetGroupId);
    }

    /**
     * バリデーション
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return ['item_id' => 'required'];
    }
}
