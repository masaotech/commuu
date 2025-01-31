<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class MatchCurrentGroup implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // ポストされた現在のグループIDと、DBの現在のグループが一致する事の確認
        $registered = User::where('id', '=', Auth::user()->id)
            ->get()->first();
        if ($registered->current_group_id != $value) {
            $fail('別画面でグループが「' . $registered->currentGroup->name . '」に変更されています。再度操作を行ってください');
        }
    }
}
