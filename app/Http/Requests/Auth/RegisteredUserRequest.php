<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisteredUserRequest extends FormRequest
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
            // プライバシーポリシー
            'accept_privacy_policy' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value === '0') {
                        $fail('プライバシーポリシーの確認および承認をしてください');
                    }
                },
            ],
            // 利用規約
            'accept_terms_of_use' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value === '0') {
                        $fail('利用規約の確認および承認をしてください');
                    }
                },
            ],
        ];
    }
}
