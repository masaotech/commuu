@props(['active'])

@php
    $is___Active = 'transition duration-200 ease-in-out inline-flex items-center w-full h-full text-gray-700 font-medium border-t-4 text-sm justify-center ';
    $isNotActive = 'transition duration-200 ease-in-out inline-flex items-center w-full h-full text-gray-700 font-medium border-t-4 text-sm justify-center ';

    // 通常時
    $is___Active .= 'bg-orange-50 border-orange-400 ';
    $isNotActive .= 'bg-gray-50 border-gray-400 ';

    // ホバー時
    $is___Active .= 'hover:bg-orange-100 hover:border-orange-500 ';
    $isNotActive .= 'hover:bg-gray-100 hover:border-gray-500 ';

    // フォーカス時
    $is___Active .= 'focus:outline-none focus:bg-orange-200 focus:border-orange-600 ';
    $isNotActive .= 'focus:outline-none focus:bg-gray-200 focus:border-gray-600 ';

    $classes = $active ?? false ? $is___Active : $isNotActive;
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
