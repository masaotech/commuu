<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class HabitScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // テーブルのクリア
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('habit_schedules')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // データ準備
        $habit_schedules = [
            [
                'id' => 1,
                'habit_item_id' => 1,
                'scheduled_date' => '2025-01-05',
                'isComplete' => 1,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'id' => 2,
                'habit_item_id' => 1,
                'scheduled_date' => '2025-02-05',
                'isComplete' => 0,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'id' => 3,
                'habit_item_id' => 1,
                'scheduled_date' => '2025-03-05',
                'isComplete' => 0,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'id' => 4,
                'habit_item_id' => 2,
                'scheduled_date' => '2025-01-05',
                'isComplete' => 1,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'id' => 5,
                'habit_item_id' => 2,
                'scheduled_date' => '2025-03-05',
                'isComplete' => 0,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'id' => 6,
                'habit_item_id' => 3,
                'scheduled_date' => '2025-01-19',
                'isComplete' => 1,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'id' => 7,
                'habit_item_id' => 3,
                'scheduled_date' => '2025-01-23',
                'isComplete' => 0,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'id' => 8,
                'habit_item_id' => 3,
                'scheduled_date' => '2025-01-26',
                'isComplete' => 0,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'id' => 9,
                'habit_item_id' => 3,
                'scheduled_date' => '2025-01-30',
                'isComplete' => 0,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
        ];

        // 登録
        foreach ($habit_schedules as $habit_schedule) {
            DB::table('habit_schedules')->insert($habit_schedule);
        }
    }
}
