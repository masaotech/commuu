<?php

namespace App\Http\Requests\HabitItem;

use App\Common\AuthorizationUtil;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\HabitSchedule;

class UpdateRequest extends FormRequest
{
    /**
     * 認可
     */
    public function authorize(): bool
    {
        $habitSchedule = HabitSchedule::find($this->request->get("schedule_id"));

        // 【バリデーション】対象データの存在確認
        if ($habitSchedule === null) return false;

        // 更新対象データのグループIDを取得
        $targetGroupId = $habitSchedule->habitItem->group_id;

        // 【バリデーション】対象データのグループメンバーか確認
        return AuthorizationUtil::isGroupMember($targetGroupId);
    }

    /**
     * バリデーション
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'schedule_id' => 'required',
            'is_complete' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (array_search($value, ["0", "1"]) === false) {
                        $fail($attribute . 'に不正な値が使用されました');
                    }
                },
            ],
        ];
    }
}
