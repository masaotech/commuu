<?php

namespace App\Http\Requests\ShoppingItem;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\MatchCurrentGroup;

class StoreRequest extends FormRequest
{
    /**
     * 認可
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * バリデーション
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_current_group_id' => ['required', new MatchCurrentGroup()],
        ];
    }
}
