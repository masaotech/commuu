{{-- ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★ --}}
{{-- 本ファイルの編集時は「./app/Common/MassageUtil.php」も内容を同期させること --}}
{{-- ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★ --}}

@props(['message'])
@php
    $timeout = '3000';
    $borderColor = 'border-gray-500';
    $backGroundColor = 'bg-gray-50';
    $textColor = 'text-gray-700';
@endphp

<x-flash-message :message=$message :timeout=$timeout :borderColor=$borderColor :backGroundColor=$backGroundColor
    :textColor=$textColor />
