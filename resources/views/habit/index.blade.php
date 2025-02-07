@use('App\Consts\ShoppingItemCategoriesConst')
@use('App\Consts\ShoppingItemStatusConst')
<x-app-layout>
    @include('layouts.dropdown-registered-group')

    {{-- タイトル --}}
    <x-slot name="header">
        定期To-Do
    </x-slot>

    {{-- 設定画面へリンク --}}
    <x-slot name="headerLink">
        <a href="{{ route('habititem.edit') }}">
            @include('icon.setting-icon')
        </a>
    </x-slot>

    {{-- メイン部分 --}}
    @if ($schedules->count() === 0)
        <div class="p-4 lg:px-8 bg-white shadow rounded-lg">
            <div class="overflow-x-auto rounded-lg max-w-3xl">
                <p>
                    定例To-Do データが登録されていません。<br>
                    右上の設定マークから登録してください。
                </p>
            </div>
        </div>
    @else
        <div class="max-w-7xl mx-auto md:p-4 lg:px-8 space-y-6">
            <div class="sm:py-6 sm:px-8 sm:bg-white sm:shadow sm:rounded-lg">
                <div class="overflow-x-auto rounded-lg border border-gray-300 max-w-3xl">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-700 rounded-md">
                        <tbody>
                            @php
                                $weekArray = ['日', '月', '火', '水', '木', '金', '土'];
                                $datetimeToday = new DateTime('today');
                            @endphp
                            @foreach ($schedules as $schedule)
                                <tr @class([
                                    'bg-gray-200' => $schedule->isComplete,
                                    'bg-white' => !$schedule->isComplete,
                                    'border-t' => !$loop->first,
                                    'border-gray-300' => !$loop->first,
                                ])>
                                    {{-- 済 / 未 --}}
                                    <td class="min-w-12">
                                        <div class="flex justify-center items-center">
                                            @php
                                                $isStamped =
                                                    session('isStamped') === true &&
                                                    session('stampedNumber') === $schedule->schedule_id;
                                            @endphp
                                            @if ($schedule->isComplete)
                                                <img alt="Task complete" src="/img/task_complete.png" width="40px"
                                                    @class(['ms-1', 'stamp' => $isStamped])>
                                            @else
                                                <span class="text-gray-400 font-medium text-xl ms-1">未</span>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- 実施日 / To-Do名 --}}
                                    @php
                                        // 日付取得
                                        $datetimeTarget = new DateTime($schedule->scheduled_date);
                                        $scheduled_date = $datetimeTarget->format('n/j'); // 日付セット

                                        // 曜日取得
                                        $w = (int) $datetimeTarget->format('w');
                                        $isSunday = $w == 0; // 日曜判定
                                        $isSaturday = $w == 6; // 土曜判定
                                        $day = $weekArray[$w]; // 曜日セット

                                        // 日数差分取得
                                        $diff = $datetimeToday->diff($datetimeTarget);
                                        $diffDays = $diff->days;
                                        if ($diffDays === 0) {
                                            // 当日(差分なし)の場合
                                            $diffMessage = '当日';
                                            $isToday = true;
                                            $isFuture = false;
                                            $isExpired = false;
                                        } elseif ($diff->invert === 0) {
                                            // 未来(差分がプラス)の場合
                                            $diffMessage = $diffDays . '日後';
                                            $isToday = false;
                                            $isFuture = true;
                                            $isExpired = false;
                                        } elseif ($diff->invert === 1) {
                                            // 過去(差分がマイナス)の場合
                                            $diffMessage = $diffDays . '日超過！';
                                            $isToday = false;
                                            $isFuture = false;
                                            $isExpired = true;
                                        }
                                    @endphp
                                    <td class="px-2 py-2 sm:px-4 min-w-44">
                                        <div>
                                            {{ $scheduled_date }}
                                            (<span @class(['text-blue-600' => $isSaturday, 'text-red-600' => $isSunday])>{{ $day }}</span>)
                                            @if (!$schedule->isComplete)
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
                                                ])>{{ $diffMessage }}</span>
                                            @endif
                                        </div>
                                        <div class="ms-2 text-md font-medium">{{ $schedule->name }}</div>
                                    </td>

                                    {{-- ボタン --}}
                                    <td class="min-w-24">
                                        <div class="flex justify-end items-center me-3">
                                            @if ($schedule->isComplete)
                                                {{-- 実施済 ⇒ 未実施 に変更 --}}
                                                <x-primary-button x-data=""
                                                    x-on:click.prevent="$dispatch('open-modal', 'confirm-habititem-deletion-{{ $schedule->schedule_id }}')">
                                                    とりけす
                                                </x-primary-button>
                                                <x-modal name="confirm-habititem-deletion-{{ $schedule->schedule_id }}"
                                                    focusable>
                                                    <form method="post" action="{{ route('habititem.update') }}"
                                                        class="p-6">
                                                        @csrf
                                                        <input type="hidden" name="schedule_id"
                                                            value={{ $schedule->schedule_id }} />
                                                        <input type="hidden" name="is_complete"
                                                            value={{ $schedule->isComplete }} />
                                                        <input type="hidden" name="to_do_name"
                                                            value={{ $schedule->name }} />
                                                        <input type="hidden" name="schedule_date"
                                                            value="{{ $scheduled_date }}({{ $day }})" />
                                                        <input type="hidden" name="group_id"
                                                            value={{ $schedule->group_id }} />
                                                        <h2 class="text-lg text-gray-900">
                                                            {{ $scheduled_date }}
                                                            (<span
                                                                @class(['text-blue-600' => $isSaturday, 'text-red-600' => $isSunday])>{{ $day }}</span>)
                                                            実施分の「{{ $schedule->name }}」を<br>
                                                            <span class="font-medium"> 「未実施」 </span>
                                                            に変更します
                                                        </h2>
                                                        <div class="mt-6 flex justify-end">
                                                            <x-secondary-button x-on:click="$dispatch('close')">
                                                                キャンセル
                                                            </x-secondary-button>
                                                            <x-primary-button class="ms-3">
                                                                OK
                                                            </x-primary-button>
                                                        </div>
                                                    </form>
                                                </x-modal>
                                            @else
                                                {{-- 未実施 ⇒ 実施済 に変更 --}}
                                                <form method="post" action="{{ route('habititem.update') }}">
                                                    @csrf
                                                    <input type="hidden" name="schedule_id"
                                                        value={{ $schedule->schedule_id }} />
                                                    <input type="hidden" name="is_complete"
                                                        value={{ $schedule->isComplete }} />
                                                    <input type="hidden" name="to_do_name"
                                                        value={{ $schedule->name }} />
                                                    <input type="hidden" name="schedule_date"
                                                        value="{{ $scheduled_date }}({{ $day }})" />
                                                    <input type="hidden" name="group_id"
                                                        value={{ $schedule->group_id }} />
                                                    <x-primary-button> 済にする </x-primary-button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- ページネーション --}}
                @if ($schedules->hasPages())
                    <div class="max-w-2xl my-4">
                        {{ $schedules->onEachSide(2)->links() }}
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- 済スタンプアニメーション --}}
    <style>
        .stamp {
            animation: stamp 0.9s ease-out;
        }

        @keyframes stamp {
            from {
                transform: scale(10);
            }
        }
    </style>

    {{-- スクロール位置保持 --}}
    <script>
        var scrollPosition;
        var STORAGE_KEY = "scrollY";

        function saveScrollPosition() {
            scrollPosition = window.pageYOffset;
            localStorage.setItem(STORAGE_KEY, scrollPosition);
        }

        window.addEventListener("load", function() {
            scrollPosition = localStorage.getItem(STORAGE_KEY);
            if (scrollPosition !== null) {
                scrollTo(0, scrollPosition);
            }
            window.addEventListener("scroll", saveScrollPosition, false);
        });
    </script>

</x-app-layout>
