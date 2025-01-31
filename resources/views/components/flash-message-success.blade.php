{{-- ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★ --}}
{{-- 本ファイルの編集時は「./app/Common/MassageUtil.php」も内容を同期させること --}}
{{-- ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★ --}}

@props(['message'])
@php
    $timeout = '7000';
    $borderColor = 'border-blue-400';
    $backGroundColor = 'bg-blue-50';
    $textColor = 'text-blue-500';
@endphp

<x-flash-message :message=$message :timeout=$timeout :borderColor=$borderColor :backGroundColor=$backGroundColor
    :textColor=$textColor />
