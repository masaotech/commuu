@use('App\Consts\ShoppingItemCategoriesConst')
@use('App\Consts\ShoppingItemStatusConst')
<x-app-layout>
    @include('layouts.dropdown-registered-group')

    {{-- タイトル --}}
    <x-slot name="header">
        買い物リスト
    </x-slot>

    {{-- 設定画面へリンク --}}
    <x-slot name="headerLink">
        <a href="{{ route('shoppingitem.edit') }}">
            @include('icon.setting-icon')
        </a>
    </x-slot>

    {{-- メイン部分 --}}
    <div class="max-w-7xl mx-auto md:px-4 lg:px-8 pb-6 space-y-6">

        {{-- 新規登録 --}}
        <div class="p-4 sm:px-8 bg-white shadow rounded-lg">
            <form method="post" action="{{ route('shoppingitem.store') }}">
                @csrf
                {{-- <div class="flex items-center gap-4"> --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 items-center gap-4 md:gap-6">
                    {{-- 商品名 --}}
                    <x-text-input id="name" name="name" type="text" class="brock w-full" placeholder="新規登録 商品名"
                        autofocus required maxlength="255" />
                    <input type="hidden" id="user_current_group_id" name="user_current_group_id"
                        value="{{ $userCurrentGroupId }}" />

                    <div class="flex space-x-2">
                        {{-- 商品カテゴリ（色選択） --}}
                        @foreach (ShoppingItemCategoriesConst::SHOPPING_ITEM_COLOR_LIST as $key => $value)
                            <div>
                                @php
                                    $isGreen = $value == 'green';
                                    $isOrange = $value == 'orange';
                                    $isBlue = $value == 'blue';
                                    $isRed = $value == 'red';
                                    $isPurple = $value == 'purple';
                                @endphp

                                <input type="radio" id="item_category_id_{{ $key }}" name="item_category_id"
                                    class="absolute opacity-0 peer" value="{{ $key }}"
                                    @checked($loop->first)>

                                <label for="item_category_id_{{ $key }}" @class([
                                    'cursor-pointer',
                                    'rounded-lg',
                                    'text-center',
                                    'shadow-[0px_1px_15px_0px_rgba(0,0,0,0.12)]',
                                    'flex',
                                    'items-center',
                                    'justify-center',
                                    'h-8',
                                    'w-8',
                                    'md:h-10',
                                    'md:w-10',
                                    'outline-gray-400',
                                    'outline-offset-2',
                                    'peer-checked:outline-dashed',
                                    'bg-green-200' => $isGreen,
                                    'bg-orange-200' => $isOrange,
                                    'bg-blue-200' => $isBlue,
                                    'bg-red-200' => $isRed,
                                    'bg-purple-200' => $isPurple,
                                ])></label>
                            </div>
                        @endforeach

                        {{-- submit ボタン --}}
                        <x-primary-button>追加</x-primary-button>
                    </div>

                </div>
            </form>
        </div>

        {{-- 購入対象のみ表示＆検索ボックス --}}
        <div class="p-4 sm:px-12 bg-white shadow rounded-lg">
            <div class="grid grid-cols-1 sm:grid-cols-2 items-center gap-4 md:gap-6">
                <div class="flex items-center">
                    <label class="cursor-pointer">
                        <input type="checkbox" id="disp_checked_only" value="" class="sr-only peer">
                        <div
                            class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-500">
                        </div>
                    </label>
                    <span class="ms-2">購入対象のみ表示する</span>
                </div>
                <div class="sm:flex sm:justify-end sm:gap-2">
                    <x-text-input id="search_box" placeholder="絞り込み 検索" />
                    <x-primary-button type="button" id="clear_search_box">クリア</x-primary-button>
                </div>
            </div>
        </div>

        {{-- 商品 一覧 --}}
        <div class="p-4 sm:px-8 bg-white shadow rounded-lg">
            <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 md:p-4">
                @foreach ($items as $item)
                    @php
                        // チェック判定
                        $isChecked = $item->item_status_code_id == ShoppingItemStatusConst::PURCHASING_TARGET;

                        // カラー判定
                        $isGreen = $item->item_category_id == ShoppingItemCategoriesConst::COLOR_1_ID;
                        $isPurple = $item->item_category_id == ShoppingItemCategoriesConst::COLOR_2_ID;
                        $isBlue = $item->item_category_id == ShoppingItemCategoriesConst::COLOR_3_ID;
                        $isRed = $item->item_category_id == ShoppingItemCategoriesConst::COLOR_4_ID;
                        $isOrange = $item->item_category_id == ShoppingItemCategoriesConst::COLOR_5_ID;

                        // チェック＆カラー判定
                        $isCheckedGreen = $isGreen && $isChecked;
                        $isCheckedPurple = $isPurple && $isChecked;
                        $isCheckedBlue = $isBlue && $isChecked;
                        $isCheckedRed = $isRed && $isChecked;
                        $isCheckedOrange = $isOrange && $isChecked;

                        $newBlock =
                            '</div>' .
                            '</div>' .
                            '<div class="p-4 sm:px-8 bg-white shadow rounded-lg">' .
                            '<div class="grid grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 md:p-4">';
                    @endphp

                    @if (!$loop->first)
                        @if ($items[$loop->index - 1]->item_category_id != $item->item_category_id)
                            {!! $newBlock !!}
                        @endif
                    @endif

                    <label for="item_id_{{ $item->id }}" @class([
                        'target_item',
                        'cursor-pointer',
                        'rounded-lg',
                        'text-center',
                        'shadow-[0px_1px_15px_0px_rgba(0,0,0,0.12)]',
                        'flex',
                        'items-center',
                        'justify-center',
                        'h-12',
                        'md:h-14',
                        'duration-200',
                        'hover:scale-105',
                        'peer-checked:outline-dashed',
                        'border-4',
                        // ボーダー色
                        'border-green-200' => $isGreen,
                        'border-purple-200' => $isPurple,
                        'border-blue-200' => $isBlue,
                        'border-red-200' => $isRed,
                        'border-orange-200' => $isOrange,
                        // 背景色
                        'bg-green-100' => $isCheckedGreen,
                        'bg-purple-100' => $isCheckedPurple,
                        'bg-blue-100' => $isCheckedBlue,
                        'bg-red-100' => $isCheckedRed,
                        'bg-orange-100' => $isCheckedOrange,
                    ])>
                        <input id="item_id_{{ $item->id }}" type="checkbox" value="{{ $item->id }}"
                            class="target hidden {{ ShoppingItemCategoriesConst::SHOPPING_ITEM_COLOR_LIST[$item->item_category_id] }}"
                            @checked($isChecked) />
                        {{ $item->name }}
                    </label>
                @endforeach
            </div>
        </div>

    </div>

    {{-- jQuery --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    {{-- javascript --}}
    @vite(['resources/js/shopping.js'])
</x-app-layout>
