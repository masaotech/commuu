<x-app-layout>
    @include('layouts.dropdown-registered-group')

    {{-- タイトル --}}
    <x-slot name="header">
        断捨離サポート
    </x-slot>


    {{-- メイン部分 --}}
    <div class="max-w-7xl mx-auto md:px-4 lg:px-8 pb-6 space-y-6">
        {{-- 新規登録 --}}
        <div class="p-4 sm:px-8 bg-white shadow rounded-lg">
            <form action="{{ route('declutter.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                {{-- 断捨離 判断日 --}}
                @php
                    $today = new DateTimeImmutable('today'); // 今日
                    $date_1_week_later = $today->modify('+1 week')->format('Y-m-d');
                @endphp
                <x-input-label for="target_day">断捨離 判断日</x-input-label>
                <x-text-input id="target_day" name="target_day" type="date" value="{{ $date_1_week_later }}" required />
                <x-form-select name="date_options" id="date_options">
                    <option value="{{ $date_1_week_later }}">1週間後</option>
                    <option value="{{ $today->modify('+2 week')->format('Y-m-d') }}">2週間後</option>
                    <option value="{{ $today->modify('+1 month')->format('Y-m-d') }}">1カ月後</option>
                    <option value="{{ $today->modify('+2 month')->format('Y-m-d') }}">2カ月後</option>
                    <option value="{{ $today->modify('+3 month')->format('Y-m-d') }}">3カ月後</option>
                    <option value="{{ $today->modify('+6 month')->format('Y-m-d') }}">半年後</option>
                    <option value="{{ $today->modify('+1 year')->format('Y-m-d') }}">1年後</option>
                    <option value="{{ $today->modify('+2 year')->format('Y-m-d') }}">2年後</option>
                    <option value="{{ $today->modify('+3 year')->format('Y-m-d') }}">3年後</option>
                </x-form-select>

                {{-- 画像 --}}
                <div class="relative">
                    <x-input-label class="mt-3">断捨離アイテム画像</x-input-label>
                    <div>
                        <x-primary-button type="button" id="file_choice_btn">画像を選択</x-primary-button>
                        <input id="input_file" type="file" name="file"
                            class="new_item_image absolute bottom-0 left-4 w-3 opacity-0" accept="image/*" required>
                    </div>
                    {{-- 画像プレビュー欄 --}}
                    <figure id="figure" style="display: none">
                        <img src="" alt="" id="figureImage"
                            class="h-32 mt-1 rounded-md border border-gray-300">
                    </figure>
                </div>

                {{-- メモ欄 --}}
                <x-input-label for="note" class="mt-3">メモ欄</x-input-label>
                <x-text-input id="note" name="note" placeholder="メモ欄" />

                <x-primary-button class="ms-2">登録</x-primary-button>
            </form>
        </div>

        {{-- アイテム一覧 --}}
        @if ($items->count() === 0)
            <div class="p-4 sm:px-8 bg-white shadow rounded-lg">
                <p>
                    断捨離アイテムが登録されていません。
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                @foreach ($items as $item)
                    <div class="bg-white shadow rounded-lg p-4 sm:px-8">
                        {{-- 日付 --}}
                        @php
                            $disposalConfirmAt = new DateTime($item->disposal_confirm_at);
                            $createdAt = new DateTime($item->created_at);
                            $datetimeToday = new DateTime('today');
                        @endphp

                        @php
                            // 日数差分取得（断捨離 判断日）
                            $diff = $datetimeToday->diff($disposalConfirmAt);
                            $diffDays = $diff->days;
                            if ($diffDays === 0) {
                                // 当日(差分なし)の場合
                                $diffMessageConfirmAt = '当日';
                                $isToday = true;
                                $isFuture = false;
                                $isExpired = false;
                            } elseif ($diff->invert === 0) {
                                // 未来(差分がプラス)の場合
                                $diffMessageConfirmAt = $diffDays . '日後';
                                $isToday = false;
                                $isFuture = true;
                                $isExpired = false;
                            } elseif ($diff->invert === 1) {
                                // 過去(差分がマイナス)の場合
                                $diffMessageConfirmAt = $diffDays . '日超過！';
                                $isToday = false;
                                $isFuture = false;
                                $isExpired = true;
                            }

                            // 日数差分取得（断捨離 登録日）
                            $diff = $datetimeToday->diff($createdAt);
                            $diffDays = $diff->days + 1;
                            if ($diffDays === 0) {
                                // 当日(差分なし)の場合
                                $diffMessageCreatedAt = '';
                            } elseif ($diff->invert === 0) {
                                // 未来(差分がプラス)の場合
                                $diffMessageCreatedAt = '';
                            } elseif ($diff->invert === 1) {
                                // 過去(差分がマイナス)の場合
                                $diffMessageCreatedAt = $diffDays . '日前';
                            }
                        @endphp

                        <p class="text-xs font-bold text-gray-500">断捨離 判断日</p>
                        <div class="ms-3">
                            {{ $disposalConfirmAt->format('Y/n/j') }}
                            <span @class([
                                'ms-2',
                                'py-0',
                                'px-2',
                                'rounded-md',
                                'font-bold',
                                'text-blue-600' => $isToday,
                                'text-red-600' => $isExpired,
                                'bg-gray-200' => $isFuture,
                                'bg-blue-200' => $isToday,
                                'bg-red-200' => $isExpired,
                            ])>{{ $diffMessageConfirmAt }}</span>
                        </div>

                        <p class="text-xs font-bold text-gray-500 mt-2">登録日</p>
                        <div class="ms-3">
                            {{ $createdAt->format('Y/n/j') }}
                            <span @class(['ms-2'])>{{ $diffMessageCreatedAt }}</span>
                        </div>

                        {{-- 画像 --}}
                        @php
                            // ファイルのデコード
                            $decodeFile = base64_decode($item->image_base64);
                            // mimeの取得
                            $mime = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $decodeFile);
                        @endphp
                        <div class="flex items-center justify-center mx-2 sm:mx-4 lg:mx-6 my-2">
                            <img src="data: {{ $mime }};base64, {{ $item->image_base64 }}"
                                class="rounded-md border border-gray-200 max-sm:max-h-40 max-lg:max-h-64">
                        </div>

                        {{-- メモ --}}
                        <div class="flex items-center justify-center">{{ $item->note }}</div>

                        {{-- 削除 --}}
                        <x-danger-button x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-declutteritem-deletion-{{ $item->id }}')">削除</x-danger-button>
                        <x-modal name="confirm-declutteritem-deletion-{{ $item->id }}" focusable>
                            <form method="post" action="{{ route('declutter.destroy') }}" class="p-6">
                                @csrf
                                <input type="hidden" name="item_id" value={{ $item->id }} />
                                <input type="hidden" name="group_id" value={{ $item->group_id }} />
                                <h2 class="text-lg font-medium text-gray-900">
                                    削除しますよろしいですか？
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
                        {{-- <div>{{ $item->id }}</div> --}}
                        {{-- <div>{{ $item->group_id }}</div> --}}
                    </div>
                @endforeach
            </div>
        @endif

    </div>

    {{-- jQuery --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    {{-- javascript --}}
    @vite(['resources/js/declutter.js'])

</x-app-layout>
