@use('App\Consts\ShoppingItemCategoriesConst')
@use('App\Consts\ShoppingItemStatusConst')
<x-app-layout>
    @include('layouts.dropdown-registered-group')
    @php
        $weekArray = ['日', '月', '火', '水', '木', '金', '土'];
        $datetimeToday = new DateTime('today');
    @endphp
    {{-- タイトル --}}
    <x-slot name="header">
        定期To-Do（編集）
    </x-slot>

    {{-- 一覧画面へリンク --}}
    <x-slot name="headerLink">
        <a class="text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            href="{{ route('habititem.index') }}">
            一覧へ戻る
        </a>
    </x-slot>

    {{-- メイン部分 --}}
    <div class="max-w-7xl mx-auto md:px-2 lg:px-8 pb-6 space-y-6">

        {{-- 新規To-Do 登録 --}}
        <div class="p-4 lg:px-8 bg-white shadow rounded-lg">
            <h2 class="text-lg font-medium text-gray-900">
                新規登録
            </h2>
            <form method="post" action="{{ route('habititem.store') }}" class="max-w-xl">
                @csrf
                {{-- 選択エリア --}}
                <div class="flex mt-2">
                    <input type="radio" id="cycle_type_monthly" name="cycle_type" class="absolute opacity-0"
                        value="monthly" checked required />
                    <label for="cycle_type_monthly" @class([
                        'cursor-pointer',
                        'rounded-t-lg',
                        'border',
                        'border-b-0',
                        'bg-green-100',
                        'px-4',
                        'py-2',
                        'ml-3',
                    ])>月単位</label>
                    <input type="radio" id="cycle_type_weekly" name="cycle_type" class="absolute opacity-0"
                        value="weekly" />
                    <label for="cycle_type_weekly" @class([
                        'cursor-pointer',
                        'rounded-t-lg',
                        'border',
                        'border-b-0',
                        'bg-purple-100',
                        'px-4',
                        'py-2',
                        'ml-1',
                    ])>週単位</label>
                    <input type="radio" id="cycle_type_daily" name="cycle_type" class="absolute opacity-0"
                        value="daily" />
                    <label for="cycle_type_daily" @class([
                        'cursor-pointer',
                        'rounded-t-lg',
                        'border',
                        'border-b-0',
                        'bg-blue-100',
                        'px-4',
                        'py-2',
                        'ml-1',
                    ])>日単位</label>
                </div>

                {{-- 月単位の入力欄 --}}
                <div id="monthly_block" class="p-3 bg-green-100 border rounded-lg space-y-3">
                    <div>
                        <x-input-label for="monthly_cycle">サイクル</x-input-label>
                        <x-form-select name="monthly_cycle" id="monthly_cycle" required>
                            @foreach ($habitCycles as $habitCycle)
                                @if ($habitCycle->cycle_type == 'monthly')
                                    <option value="{{ $habitCycle->id }}">
                                        {{ $habitCycle->name }}
                                    </option>
                                @endif
                            @endforeach
                        </x-form-select>
                    </div>
                    <div>
                        <x-input-label for="monthly_day">実施日</x-input-label>
                        <x-text-input id="monthly_day" name="monthly_day" type="number" min="1" max="28"
                            class="brock w-20" value="1" required />日（1～28日で指定）
                    </div>
                </div>

                {{-- 週単位の入力欄 --}}
                <div id="weekly_block" class="p-3 bg-purple-100 border rounded-lg hidden">
                    <x-input-label>実施曜日</x-input-label>
                    <div class="grid sm:grid-cols-7">
                        @foreach ($weekArray as $key => $value)
                            <div>
                                <input type="checkbox" name="weekly_days[]" id="weekly_days_{{ $key }}"
                                    class="weekly_days" value="{{ $key }}" disabled />
                                <label for="weekly_days_{{ $key }}">{{ $value }}曜</label>
                            </div>
                        @endforeach
                    </div>

                    @foreach ($habitCycles as $habitCycle)
                        @if ($habitCycle->cycle_type == 'weekly')
                            <input type="hidden" name="weekly_cycle" id="weekly_cycle" value="{{ $habitCycle->id }}"
                                disabled />
                        @endif
                    @endforeach
                </div>

                {{-- 日単位の入力欄 --}}
                <div id="daily_block" class="p-3 bg-blue-100 border rounded-lg space-y-3 hidden">
                    <div>
                        <x-input-label for="daily_cycle">サイクル</x-input-label>
                        <x-form-select name="daily_cycle" id="daily_cycle" disabled>
                            @foreach ($habitCycles as $habitCycle)
                                @if ($habitCycle->cycle_type == 'daily')
                                    <option value="{{ $habitCycle->id }}">
                                        {{ $habitCycle->name }}
                                    </option>
                                @endif
                            @endforeach
                        </x-form-select>
                    </div>
                    <div>
                        <x-input-label for="daily_cycle">開始日</x-input-label>
                        <x-text-input id="daily_day" name="daily_day" type="date"
                            value="{{ $datetimeToday->format('Y-m-d') }}" disabled />
                    </div>
                </div>

                {{-- 共通エリア --}}
                <x-text-input id="name" name="name" type="text" class="m-3" placeholder="定期To-Do名"
                    required />
                <x-primary-button class="block">追加</x-primary-button>
            </form>

            {{-- Todo 今後の改修 --}}
            {{-- <div class="bg-gray-300 p-10">
                現在の設定での実施日（直近10件）
            </div> --}}

        </div>

        {{-- 既存To-Do 一覧 --}}
        <div class="p-4 lg:px-8 bg-white shadow rounded-lg">
            <h2 class="text-lg font-medium text-gray-900">
                設定済み一覧
            </h2>

            <div class="overflow-x-auto rounded-lg border max-w-3xl">
                <table class="w-full text-sm text-left rtl:text-right text-gray-700 rounded-md">
                    <thead class="bg-gray-200">
                        <tr>
                            <th scope="col" class="p-2 sm:px-4">To-Do名</th>
                            <th scope="col" class="p-2 sm:px-4">サイクル</th>
                            <th scope="col" class="p-2 sm:px-4">補足</th>
                            <th scope="col" class="p-2 sm:px-4 min-w-14"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($habitItems as $habitItem)
                            <tr class="bg-white border-t ">
                                <td class="px-2 py-4">{{ $habitItem->item_name }}</td>
                                <td class="px-2 py-4">{{ $habitItem->cycle_name }}</td>
                                <td class="px-2 py-4">
                                    @if ($habitItem->cycle_type == 'monthly')
                                        各月{{ $habitItem->monthly_start_day }}日
                                    @elseif($habitItem->cycle_type == 'weekly')
                                        @php
                                            $weekKeyArray = str_split($habitItem->weekly_day_of_week);
                                        @endphp
                                        @foreach ($weekKeyArray as $key)
                                            {{ $weekArray[$key] }}曜
                                            @if (!$loop->last)
                                                /
                                            @endif
                                        @endforeach
                                    @elseif($habitItem->cycle_type == 'daily')
                                        {{-- {{ $habitItem->daily_start_date }} --}}
                                    @endif
                                </td>
                                <td>
                                    <x-danger-button x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'confirm-habititem-deletion-{{ $habitItem->item_id }}')">削除</x-danger-button>
                                    <x-modal name="confirm-habititem-deletion-{{ $habitItem->item_id }}" focusable>
                                        <form method="post" action="{{ route('habititem.destroy') }}" class="p-6">
                                            @csrf
                                            <input type="hidden" name="item_id" value={{ $habitItem->item_id }} />
                                            <input type="hidden" name="group_id" value={{ $habitItem->group_id }} />
                                            <h2 class="text-lg font-medium text-gray-900">
                                                定期To-Do 「{{ $habitItem->item_name }}」 を削除して本当に大丈夫ですか？
                                            </h2>
                                            <div class="mt-6 flex justify-end">
                                                <x-secondary-button x-on:click="$dispatch('close')">
                                                    キャンセル
                                                </x-secondary-button>
                                                <x-danger-button class="ms-3">
                                                    削除
                                                </x-danger-button>
                                            </div>
                                        </form>
                                    </x-modal>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- jQuery --}}
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> --}}

    {{-- javascript --}}
    <script src="/habit_work.js"></script>
    {{-- Todo vite の場合エラー発生 --}}
    {{-- @vite(['resources/js/habit.js']) --}}
</x-app-layout>
