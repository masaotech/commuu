<?php

namespace App\Http\Requests\HabitItem;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\HabitCycle;

class StoreRequest extends FormRequest
{
    /**
     * 認可
     */
    public function authorize(): bool
    {
        // nop
        return true;
    }

    /**
     * バリデーション
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 共通
            'name' => [
                'required',
                'max:255'
            ],
            'cycle_type' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (array_search($value, ["monthly", "weekly", "daily"]) === false) {
                        $fail($attribute . 'に不正な値が使用されました');
                    }
                },
            ],

            // 月単位
            'monthly_day' => [
                'required_if:cycle_type,monthly',
                'numeric',
                'between:1,28'
            ],
            'monthly_cycle' => [
                'required_if:cycle_type,monthly',
                function ($attribute, $value, $fail) {
                    $result = HabitCycle::where('cycle_type', '=', 'monthly')
                        ->select(['id'])
                        ->get()->pluck("id")->toArray();
                    if (array_search($value, $result) === false) {
                        $fail($attribute . 'に不正な値が使用されました');
                    }
                },
            ],

            // 週単位
            'weekly_days' => [
                'required_if:cycle_type,weekly',
                function ($attribute, $value, $fail) {
                    foreach ($value as $day) {
                        if (array_search($day, ["0", "1", "2", "3", "4", "5", "6"]) === false) {
                            $fail($attribute . 'に不正な値が使用されました');
                        }
                    }
                },
            ],
            'weekly_cycle' => [
                'required_if:cycle_type,weekly',
                function ($attribute, $value, $fail) {
                    $result = HabitCycle::where('cycle_type', '=', 'weekly')
                        ->select(['id'])
                        ->get()->pluck("id")->toArray();
                    if (array_search($value, $result) === false) {
                        $fail($attribute . 'に不正な値が使用されました');
                    }
                },
            ],

            // 日単位
            'daily_day' => [
                'required_if:cycle_type,daily',
                'date_format:Y-m-d'
            ],
            'daily_cycle' => [
                'required_if:cycle_type,daily',
                function ($attribute, $value, $fail) {
                    $result = HabitCycle::where('cycle_type', '=', 'daily')
                        ->select(['id'])
                        ->get()->pluck("id")->toArray();
                    if (array_search($value, $result) === false) {
                        $fail($attribute . 'に不正な値が使用されました');
                    }
                },
            ],
        ];
    }
}
