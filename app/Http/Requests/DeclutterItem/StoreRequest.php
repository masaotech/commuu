<?php

namespace App\Http\Requests\DeclutterItem;

use Illuminate\Foundation\Http\FormRequest;

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
            'note' => [
                'max:255',
            ],
            'target_day' => [
                'required',
                'date_format:Y-m-d',
            ],
            'file' => [
                'required',
                function ($attribute, $value, $fail) {
                    $fileType = @exif_imagetype($value);
                    switch ($fileType) {
                        case IMAGETYPE_GIF:
                        case IMAGETYPE_JPEG:
                        case IMAGETYPE_PNG:
                        case IMAGETYPE_BMP:
                            break;
                        case IMAGETYPE_TIFF_II:
                        case IMAGETYPE_TIFF_MM:
                        default:
                            $fail('使用できない形式の画像が指定されました(JPEG, PNG, BMP, GIF が使用可能です)');
                            break;
                    }
                },
            ],
        ];
    }
}
