{{-- ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★ --}}
{{-- 本ファイルの編集時は「./app/Common/MassageUtil.php」も内容を同期させること --}}
{{-- ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★ --}}

@props(['message'])
@php
    $timeout = '10000';
    $borderColor = 'border-red-300';
    $backGroundColor = 'bg-red-100';
    $textColor = 'text-red-700';
@endphp

<x-flash-message :message=$message :timeout=$timeout :borderColor=$borderColor :backGroundColor=$backGroundColor
    :textColor=$textColor />
