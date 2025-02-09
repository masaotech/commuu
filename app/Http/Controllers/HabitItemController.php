<?php

namespace App\Http\Controllers;

use App\Http\Requests\HabitItem\StoreRequest;
use App\Http\Requests\HabitItem\UpdateRequest;
use App\Http\Requests\HabitItem\DestroyRequest;
use App\Models\HabitCycle;
use App\Models\HabitItem;
use App\Models\HabitSchedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use DateTime;
use DateTimeImmutable;

class HabitItemController extends Controller
{
    /**
     * [GET] 定例To-Do一覧画面表示
     */
    public function index()
    {
        // スケジュール更新
        $this->updateHabitSchedules();

        // 表示データ取得
        $schedules = DB::table('habit_schedules as s')
            ->where('group_id', '=', $this->commonBag['userCurrentGroupId'])
            ->leftjoin('habit_items as i', 's.habit_item_id', '=', 'i.id')
            ->select([
                'i.id                           as item_id',
                'i.name                         as name',
                'i.group_id                     as group_id',
                'i.habit_schedules_updated_at   as habit_schedules_updated_at',
                's.id                           as schedule_id',
                's.scheduled_date               as scheduled_date',
                's.isComplete                   as isComplete',
            ])
            ->orderBy('scheduled_date', 'asc')
            ->orderBy('schedule_id', 'asc')
            ->paginate(30)  // ページネーションのページあたりの表示数指定
        ;

        $this->addToBag('schedules', $schedules);
        return view('habit/index', $this->commonBag);
    }

    /**
     * [GET] 定例To-Do(編集) 画面表示
     */
    public function edit()
    {
        // サイクルマスタ一覧 の取得
        $habitCycles = HabitCycle::all();

        // 設定済み一覧 の取得
        $habitItems = DB::table('habit_items as i')
            ->leftjoin('habit_cycles as c', 'c.id', '=', 'i.habit_cycle_id')
            ->where('i.group_id', '=', $this->commonBag['userCurrentGroupId'])
            ->select([
                'i.id                   as item_id',
                'i.name                 as item_name',
                'i.group_id             as group_id',
                'i.monthly_start_day    as monthly_start_day',
                'i.weekly_day_of_week   as weekly_day_of_week',
                'i.daily_start_date     as daily_start_date',
                'c.id                   as cycle_id',
                'c.name                 as cycle_name',
                'c.cycle_type           as cycle_type',
            ])
            ->orderBy('cycle_id', 'asc')
            ->orderBy('monthly_start_day', 'asc')
            ->orderBy('weekly_day_of_week', 'asc')
            ->get();

        $this->addToBag('habitCycles', $habitCycles);
        $this->addToBag('habitItems', $habitItems);
        return view('habit/edit', $this->commonBag);
    }

    /**
     * [POST] 定例To-Do新規登録処理
     */
    public function store(StoreRequest $request)
    {
        // 新規登録用インスタンス
        $habitItem = new HabitItem();

        // 共通データをセット
        $habitItem->name = $request->name;
        $habitItem->group_id = $this->commonBag['userCurrentGroupId'];
        $habitItem->habit_schedules_updated_at = null;

        // サイクルタイプ毎のデータをセット
        if ($request->cycle_type == 'monthly') {
            // 月単位の場合
            $habitItem->habit_cycle_id = $request->monthly_cycle;
            $habitItem->monthly_start_day = $request->monthly_day;
        } elseif ($request->cycle_type == 'weekly') {
            // 週単位の場合
            $habitItem->habit_cycle_id = $request->weekly_cycle;
            $weekly_day_of_week = "";
            foreach ($request->weekly_days as $day) {
                $weekly_day_of_week .= $day;
            }
            $habitItem->weekly_day_of_week = $weekly_day_of_week;
        } elseif ($request->cycle_type == 'daily') {
            // 日単位の場合
            $habitItem->habit_cycle_id = $request->daily_cycle;
            $habitItem->daily_start_date = $request->daily_day;
        }

        // 新規登録 実行
        $habitItem->save();

        $this->updateHabitSchedules();

        return Redirect::route('habititem.edit')
            ->with('flash-message-info', '「'. $habitItem->name . '」　を登録しました');;
    }

    /**
     * [POST] 定例To-Doのスケジュール実施状況更新（habit_itemsテーブルの更新）
     */
    public function update(UpdateRequest $request)
    {
        // 更新対象のデータ取得
        $habitSchedule = HabitSchedule::find($request->schedule_id);

        // 現状のステータス に応じて更新データを設定
        if ($request->is_complete == 0) {
            $habitSchedule->isComplete = 1;
            $isStamped = true;
            $stampedNumber = $habitSchedule->id;
            $flashMessage = null;
        } else {
            $habitSchedule->isComplete = 0;
            $isStamped = false;
            $stampedNumber = null;
            $flashMessage = '取り消しました';
        }

        // 更新 実行
        $habitSchedule->save();

        return Redirect::route('habititem.index')
            ->with('isStamped', $isStamped) // 「済」スタンプ判定
            ->with('stampedNumber', $stampedNumber) // 「済」スタンプ判定
            ->with('flash-message-info', $flashMessage);
    }

    /**
     * [POST] 定例To-Doの削除
     */
    public function destroy(DestroyRequest $request)
    {
        // 削除対象のデータ取得
        $habitItem = HabitItem::find($request->item_id);

        // 削除 実行
        $habitItem->delete();

        return Redirect::route('habititem.edit')
            ->with('flash-message-success', '「' . $habitItem->name . '」を削除しました');
    }

    /**
     * [private] 定例To-Doのスケジュール最新化（habit_schedulesテーブルの更新）
     */
    public function updateHabitSchedules()
    {
        $today = new DateTimeImmutable('today'); // 今日
        $deleteMaxDate = $today->modify('-3 day'); // 何日経過したスケジュールを削除するか
        $insertMaxDate = $today->modify('+6 month'); // 何日先までスケジュール登録するか

        // 対象グループの定期To-Doをループ
        $habitItems = HabitItem::where('group_id', '=', $this->commonBag['userCurrentGroupId'])->get();
        foreach ($habitItems as $habitItem) {
            if (new DateTime($habitItem->habit_schedules_updated_at) == $today) {
                // 当日に更新済みの場合スキップ
                continue;
            }

            // 以下データを DELETE ===========================================================================================
            // ・scheduled_date が 3日以上前
            // ・isComplete が true（実施済）
            $deleteSchedules = DB::table('habit_schedules as s')
                ->leftjoin('habit_items as i', 's.habit_item_id', '=', 'i.id')
                ->where('i.id', '=', $habitItem->id)
                ->where('i.group_id', '=', $this->commonBag['userCurrentGroupId'])
                ->where('s.isComplete', '=', true)
                ->where('s.scheduled_date', '<=', $deleteMaxDate->format('Y-m-d'))
                ->select([
                    'i.id                           as item_id',
                    'i.name                         as name',
                    'i.group_id                     as group_id',
                    's.id                           as schedule_id',
                    's.scheduled_date               as scheduled_date',
                    's.isComplete                   as isComplete',
                ])
                ->get();
            foreach ($deleteSchedules as $deleteSchedule) {
                // スケジュール データ削除
                HabitSchedule::find($deleteSchedule->schedule_id)->delete();
            }

            // 以下データを INSERT ===========================================================================================
            // $currentTraceDate ～ $insertMaxDate まで

            // 追加スケジュールの捜索開始日を設定
            // 現在設定されているスケジュールの最終日を取得
            $latestSchedule = HabitSchedule::where('habit_item_id', '=', $habitItem->id)
                ->max('scheduled_date');
            if ($latestSchedule === null) {
                // スケジュールが存在しない場合、当日をセット
                $currentTraceDate = new DateTime('today');
            } else {
                // スケジュールが存在する場合、既存の最終日をセット
                $currentTraceDate = new DateTime($latestSchedule);
                $currentTraceDate->modify('+1 day');
            }
            if ($habitItem->daily_start_date !== null) {
                // 日単位の場合
                if ($currentTraceDate < new DateTime($habitItem->daily_start_date)) {
                    // 開始日がさらに先であれば開始日をセットする
                    $currentTraceDate = new DateTime($habitItem->daily_start_date);
                }
            }

            // 新規スケジュール登録用の日付を設定
            $newScheduleArray = []; // 登録日付保持用
            switch ($habitItem->habit_cycle_id) {
                    // サイクルパターンで処理を分岐
                case 1000:
                    // monthly：毎月
                    while ($currentTraceDate < $insertMaxDate) {
                        if ($habitItem->monthly_start_day == $currentTraceDate->format('j')) {
                            array_push($newScheduleArray, $currentTraceDate->format('Y-m-d'));
                        }
                        $currentTraceDate->modify('+1 day');
                    }
                    break;
                case 1001:
                    // monthly：奇数月（1,3,5,7,9,11月）
                    while ($currentTraceDate < $insertMaxDate) {
                        if ($habitItem->monthly_start_day == $currentTraceDate->format('j')) {
                            if (array_search($currentTraceDate->format('n'), ["1", "3", "5", "7", "9", "11"]) !== false) {
                                array_push($newScheduleArray, $currentTraceDate->format('Y-m-d'));
                            }
                        }
                        $currentTraceDate->modify('+1 day');
                    }
                    break;
                case 1002:
                    // monthly：偶数月（2,4,6,8,10,12月）
                    while ($currentTraceDate < $insertMaxDate) {
                        if ($habitItem->monthly_start_day == $currentTraceDate->format('j')) {
                            if (array_search($currentTraceDate->format('n'), ["2", "4", "6", "8", "10", "12"]) !== false) {
                                array_push($newScheduleArray, $currentTraceDate->format('Y-m-d'));
                            }
                        }
                        $currentTraceDate->modify('+1 day');
                    }
                    break;
                case 1003:
                    // monthly：3カ月毎（1,4,7,10月）
                    while ($currentTraceDate < $insertMaxDate) {
                        if ($habitItem->monthly_start_day == $currentTraceDate->format('j')) {
                            if (array_search($currentTraceDate->format('n'), ["1", "4", "7", "10"]) !== false) {
                                array_push($newScheduleArray, $currentTraceDate->format('Y-m-d'));
                            }
                        }
                        $currentTraceDate->modify('+1 day');
                    }
                    break;
                case 1004:
                    // monthly：3カ月毎（2,5,8,11月）
                    while ($currentTraceDate < $insertMaxDate) {
                        if ($habitItem->monthly_start_day == $currentTraceDate->format('j')) {
                            if (array_search($currentTraceDate->format('n'), ["2", "5", "8", "11"]) !== false) {
                                array_push($newScheduleArray, $currentTraceDate->format('Y-m-d'));
                            }
                        }
                        $currentTraceDate->modify('+1 day');
                    }
                    break;
                case 1005:
                    // monthly：3カ月毎（3,6,9,12月）
                    while ($currentTraceDate < $insertMaxDate) {
                        if ($habitItem->monthly_start_day == $currentTraceDate->format('j')) {
                            if (array_search($currentTraceDate->format('n'), ["3", "6", "9", "12"]) !== false) {
                                array_push($newScheduleArray, $currentTraceDate->format('Y-m-d'));
                            }
                        }
                        $currentTraceDate->modify('+1 day');
                    }
                    break;
                case 1006:
                    // monthly：4カ月毎（1,5,9月）
                    while ($currentTraceDate < $insertMaxDate) {
                        if ($habitItem->monthly_start_day == $currentTraceDate->format('j')) {
                            if (array_search($currentTraceDate->format('n'), ["1", "5", "9"]) !== false) {
                                array_push($newScheduleArray, $currentTraceDate->format('Y-m-d'));
                            }
                        }
                        $currentTraceDate->modify('+1 day');
                    }
                    break;
                case 1007:
                    // monthly：4カ月毎（2,6,10月）
                    while ($currentTraceDate < $insertMaxDate) {
                        if ($habitItem->monthly_start_day == $currentTraceDate->format('j')) {
                            if (array_search($currentTraceDate->format('n'), ["2", "6", "10"]) !== false) {
                                array_push($newScheduleArray, $currentTraceDate->format('Y-m-d'));
                            }
                        }
                        $currentTraceDate->modify('+1 day');
                    }
                    break;
                case 1008:
                    // monthly：4カ月毎（3,7,11月）
                    while ($currentTraceDate < $insertMaxDate) {
                        if ($habitItem->monthly_start_day == $currentTraceDate->format('j')) {
                            if (array_search($currentTraceDate->format('n'), ["3", "7", "11"]) !== false) {
                                array_push($newScheduleArray, $currentTraceDate->format('Y-m-d'));
                            }
                        }
                        $currentTraceDate->modify('+1 day');
                    }
                    break;
                case 1009:
                    // monthly：4カ月毎（4,8,12月）
                    while ($currentTraceDate < $insertMaxDate) {
                        if ($habitItem->monthly_start_day == $currentTraceDate->format('j')) {
                            if (array_search($currentTraceDate->format('n'), ["4", "8", "12"]) !== false) {
                                array_push($newScheduleArray, $currentTraceDate->format('Y-m-d'));
                            }
                        }
                        $currentTraceDate->modify('+1 day');
                    }
                    break;
                case 2000:
                    // weekly：毎週
                    $weekKeyArray = str_split($habitItem->weekly_day_of_week);
                    while ($currentTraceDate < $insertMaxDate) {
                        if (array_search($currentTraceDate->format('w'), $weekKeyArray) !== false) {
                            array_push($newScheduleArray, $currentTraceDate->format('Y-m-d'));
                        }
                        $currentTraceDate->modify('+1 day');
                    }
                    break;
                case 3000:
                    // daily：毎日
                    while ($currentTraceDate < $insertMaxDate) {
                        array_push($newScheduleArray, $currentTraceDate->format('Y-m-d'));
                        $currentTraceDate->modify('+1 day');
                    }
                    break;
                case 3001:
                    // daily：1日おき
                    while ($currentTraceDate < $insertMaxDate) {
                        array_push($newScheduleArray, $currentTraceDate->format('Y-m-d'));
                        $currentTraceDate->modify('+2 day');
                    }
                    break;
                case 3002:
                    // daily：2日おき
                    while ($currentTraceDate < $insertMaxDate) {
                        array_push($newScheduleArray, $currentTraceDate->format('Y-m-d'));
                        $currentTraceDate->modify('+3 day');
                    }
                    break;
                case 3003:
                    // daily：3日おき
                    while ($currentTraceDate < $insertMaxDate) {
                        array_push($newScheduleArray, $currentTraceDate->format('Y-m-d'));
                        $currentTraceDate->modify('+4 day');
                    }
                    break;
                case 3004:
                    // daily：4日おき
                    while ($currentTraceDate < $insertMaxDate) {
                        array_push($newScheduleArray, $currentTraceDate->format('Y-m-d'));
                        $currentTraceDate->modify('+5 day');
                    }
                    break;
                case 3005:
                    // daily：5日おき
                    while ($currentTraceDate < $insertMaxDate) {
                        array_push($newScheduleArray, $currentTraceDate->format('Y-m-d'));
                        $currentTraceDate->modify('+6 day');
                    }
                    break;
            }

            DB::beginTransaction();
            try {
                // insert
                foreach ($newScheduleArray as $newSchedule) {
                    $habitSchedule = new HabitSchedule();
                    $habitSchedule->habit_item_id = $habitItem->id;
                    $habitSchedule->scheduled_date = $newSchedule;
                    $habitSchedule->isComplete = false;
                    $habitSchedule->save();
                }

                // スケジュール最終更新日の更新
                $habitItem->habit_schedules_updated_at = $today->format('Y-m-d');
                $habitItem->save();
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                return Redirect::route('group.index')
                    ->with('flash-message-error', 'スケジュールの登録中にエラーが発生しました');
            }
        }
    }
}
