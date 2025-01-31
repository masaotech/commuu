<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class HabitItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // テーブルのクリア
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('habit_items')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // データ準備
        $habit_items = [
            [
                'id' => 1,
                'name' => '洗濯槽クリーナー',
                'group_id' => '1',
                'habit_cycle_id' => '1000',
                'monthly_start_day' => 5,
                'weekly_day_of_week' => null,
                'daily_start_date' => null,
                'habit_schedules_updated_at' => '2025-01-20',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'id' => 2,
                'name' => 'まど掃除',
                'group_id' => '2',
                'habit_cycle_id' => '1001',
                'monthly_start_day' => 10,
                'weekly_day_of_week' => null,
                'daily_start_date' => null,
                'habit_schedules_updated_at' => '2025-01-20',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'id' => 3,
                'name' => '床掃除機掛け',
                'group_id' => '2',
                'habit_cycle_id' => '2000',
                'monthly_start_day' => null,
                'weekly_day_of_week' => 04,
                'daily_start_date' => null,
                'habit_schedules_updated_at' => '2025-01-20',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
        ];

        // 登録
        foreach ($habit_items as $habit_item) {
            DB::table('habit_items')->insert($habit_item);
        }
    }
}
