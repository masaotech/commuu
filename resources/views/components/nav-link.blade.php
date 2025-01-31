@props(['active'])

@php
    $is___Active = 'inline-flex items-center px-1 pt-1 border-b-4 text-sm font-medium leading-5 transition duration-150 ease-in-out ';
    $isNotActive = 'inline-flex items-center px-1 pt-1 border-b-4 text-sm font-medium leading-5 transition duration-150 ease-in-out ';

    // 通常時
    $is___Active .= 'text-gray-900 border-orange-400 ';
    $isNotActive .= 'text-gray-500 border-gray-300 ';

    // ホバー時
    $is___Active .= ' ';
    $isNotActive .= 'hover:text-gray-700 hover:border-gray-400 ';

    // フォーカス時
    $is___Active .= 'focus:outline-none ';
    $isNotActive .= 'focus:outline-none focus:text-gray-900 focus:border-gray-500 ';

    $classes = $active ?? false ? $is___Active : $isNotActive;
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
