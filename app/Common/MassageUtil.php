<?php

namespace App\Common;

class MassageUtil
{
    // ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
    // 本メソッドの編集時は以下ファイルについても内容を同期させること
    // 「./resources/views/components/flash-message.blade.php」
    // 「./resources/views/components/flash-message-success.blade.php」
    // 「./resources/views/components/flash-message-info.blade.php」
    // 「./resources/views/components/flash-message-error.blade.php」
    // ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★

    public static function flashMassageInfo($message = "")
    {
        return self::getMessage($message, 'info');
    }

    public static function flashMassageSuccess($message = "")
    {
        return self::getMessage($message, 'success');
    }

    public static function flashMassageError($message = "")
    {
        return self::getMessage($message, 'error');
    }

    private static function getMessage($message, $type)
    {
        // メッセージタイプ毎の値セット
        switch ($type) {
            case 'info':
                $timeout = "3000";
                $borderColor = "border-gray-500";
                $backGroundColor = "bg-gray-50";
                $textColor = "text-gray-700";
                break;
            case 'success':
                $timeout = "7000";
                $borderColor = "border-blue-400";
                $backGroundColor = "bg-blue-50";
                $textColor = "text-blue-500";
                break;
            case 'error':
                $timeout = "10000";
                $borderColor = "border-red-300";
                $backGroundColor = "bg-red-100";
                $textColor = "text-red-700";
                break;
        }

        $returnMessage =  <<<__LONG_STRRING__
                <p x-data="{ show: true }" x-show="show" x-transition.duration.200ms x-init="setTimeout(() => show = false, {$timeout})"
                     class="flash-messege my-1 content-center rounded border-2 {$borderColor} {$backGroundColor} px-4 py-1 text-sm {$textColor}">
                    <span class="flex justify-between">
                        <span class="py-2">{$message}</span>
                        <button class="cursor-pointer p-2" onclick="this.closest('.flash-messege').classList.add('hidden');">
                            <svg version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512"
                                style="width: 10px; height: 10px; opacity: 1;" xml:space="preserve">
                                <style type="text/css">
                                    .st0 {
                                        fill: #888;
                                    }
                                </style>
                                <g>
                                    <polygon class="st0"
                                        points="512,52.535 459.467,0.002 256.002,203.462 52.538,0.002 0,52.535 203.47,256.005 0,459.465 
                            52.533,511.998 256.002,308.527 459.467,511.998 512,459.475 308.536,256.005">
                                    </polygon>
                                </g>
                            </svg>
                        </button>
                    </span>
                </p>
                __LONG_STRRING__;

        return $returnMessage;
    }
}
