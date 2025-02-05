@use('App\Consts\ShoppingItemCategoriesConst')
@use('App\Consts\ShoppingItemStatusConst')
<x-app-layout>
    @include('layouts.dropdown-registered-group')

    {{-- タイトル --}}
    <x-slot name="header">
        買い物リスト（編集）
    </x-slot>

    {{-- 一覧画面へリンク --}}
    <x-slot name="headerLink">
        <a class="text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            href="{{ route('shoppingitem.index') }}">
            一覧へ戻る
        </a>
    </x-slot>

    {{-- メイン部分 --}}
    <div class="max-w-7xl mx-auto md:px-2 lg:px-8 pb-6 space-y-6">

        <input type="hidden" id="user_current_group_id" name="user_current_group_id" value="{{ $userCurrentGroupId }}" />

        {{-- 商品 一覧 --}}
        <div class="p-4 lg:px-8 bg-white shadow rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-6 md:p-4 max-md:mb-4">
                @foreach ($items as $item)
                    {{-- 商品カテゴリ毎でブロックを分ける --}}
                    @php
                        $newBlock =
                            '</div>' .
                            '</div>' .
                            '<div class="p-4 lg:px-8 bg-white shadow rounded-lg">' .
                            '<div class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-6 md:p-4 max-md:mb-4">';
                    @endphp

                    @if (!$loop->first)
                        @if ($items[$loop->index - 1]->item_category_id != $item->item_category_id)
                            {{-- 商品カテゴリが切り替わった箇所でブロック区切りを挿入 --}}
                            {!! $newBlock !!}
                        @endif
                    @endif

                    {{-- 商品名 --}}
                    <x-text-input id="name_item_{{ $item->id }}" name="item_name" type="text"
                        class="brock w-full max-md:mt-4" value="{{ $item->name }}" placeholder="商品名" required
                        maxlength="255" />

                    {{-- 商品カテゴリ（色選択）＆更新ボタン --}}
                    <div class="flex space-x-2 categories">
                        @foreach (ShoppingItemCategoriesConst::SHOPPING_ITEM_COLOR_LIST as $key => $value)
                            <div>
                                @php
                                    $isGreen = $value == 'green';
                                    $isOrange = $value == 'orange';
                                    $isBlue = $value == 'blue';
                                    $isRed = $value == 'red';
                                    $isPurple = $value == 'purple';
                                    $isChecked = $key == $item->item_category_id;
                                @endphp

                                <input type="radio" id="item_category_id_{{ $key }}_item_{{ $item->id }}"
                                    name="item_category_id_item_{{ $item->id }}" class="absolute opacity-0 peer"
                                    value="{{ $key }}" @checked($isChecked)>

                                <label for="item_category_id_{{ $key }}_item_{{ $item->id }}"
                                    @class([
                                        'cursor-pointer',
                                        'rounded-lg',
                                        'text-center',
                                        'shadow-[0px_1px_15px_0px_rgba(0,0,0,0.12)]',
                                        'flex',
                                        'items-center',
                                        'justify-center',
                                        'h-8',
                                        'w-8',
                                        'lg:h-10',
                                        'lg:w-10',
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
                        <x-primary-button id="update_item_{{ $item->id }}"
                            class="update-item">更新</x-primary-button>
                        <x-danger-button id="delete_item_{{ $item->id }}" class="delete-item">削除</x-danger-button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- jQuery --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    {{-- javascript --}}
    @vite(['resources/js/shopping.js'])
</x-app-layout>
