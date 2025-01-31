@props(['active'])

@php
    $is___Active = 'transition duration-200 ease-in-out block w-full text-gray-700 border-l-4 px-4 py-2 text-start text-sm leading-5 ';
    $isNotActive = 'transition duration-200 ease-in-out block w-full text-gray-700 border-l-4 px-4 py-2 text-start text-sm leading-5 ';

    // 通常時
    $is___Active .= 'bg-orange-100 border-orange-400 ';
    $isNotActive .= 'bg-gray-100 border-gray-400 ';

    // ホバー時
    $is___Active .= 'hover:bg-orange-200 hover:border-orange-500 ';
    $isNotActive .= 'hover:bg-gray-200 hover:border-gray-500 ';

    // フォーカス時
    $is___Active .= 'focus:outline-none focus:bg-orange-300 focus:border-orange-600 ';
    $isNotActive .= 'focus:outline-none focus:bg-gray-300 focus:border-gray-600 ';

    $classes = $active ?? false ? $is___Active : $isNotActive;
@endphp

<button type="submit" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
