<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class HabitCycleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // テーブルのクリア
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('habit_cycles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // データ準備
        $habit_cycles = [
            // 月単位
            [
                'id' => '1000',
                'cycle_type' => 'monthly',
                'name' => '毎月',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'id' => '1001',
                'cycle_type' => 'monthly',
                'name' => '奇数月（1,3,5,7,9,11月）',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'id' => '1002',
                'cycle_type' => 'monthly',
                'name' => '偶数月（2,4,6,8,10,12月）',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'id' => '1003',
                'cycle_type' => 'monthly',
                'name' => '3カ月毎（1,4,7,10月）',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'id' => '1004',
                'cycle_type' => 'monthly',
                'name' => '3カ月毎（2,5,8,11月）',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'id' => '1005',
                'cycle_type' => 'monthly',
                'name' => '3カ月毎（3,6,9,12月）',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'id' => '1006',
                'cycle_type' => 'monthly',
                'name' => '4カ月毎（1,5,9月）',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'id' => '1007',
                'cycle_type' => 'monthly',
                'name' => '4カ月毎（2,6,10月）',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'id' => '1008',
                'cycle_type' => 'monthly',
                'name' => '4カ月毎（3,7,11月）',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'id' => '1009',
                'cycle_type' => 'monthly',
                'name' => '4カ月毎（4,8,12月）',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            // 週単位
            [
                'id' => '2000',
                'cycle_type' => 'weekly',
                'name' => '毎週',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            // [
            //     'id' => '2000',
            //     'cycle_type' => 'weekly',
            //     'name' => '日曜',
            //     'created_at' => new DateTime(),
            //     'updated_at' => new DateTime(),
            // ],
            // [
            //     'id' => '2001',
            //     'cycle_type' => 'weekly',
            //     'name' => '月曜',
            //     'created_at' => new DateTime(),
            //     'updated_at' => new DateTime(),
            // ],
            // [
            //     'id' => '2002',
            //     'cycle_type' => 'weekly',
            //     'name' => '火曜',
            //     'created_at' => new DateTime(),
            //     'updated_at' => new DateTime(),
            // ],
            // [
            //     'id' => '2003',
            //     'cycle_type' => 'weekly',
            //     'name' => '水曜',
            //     'created_at' => new DateTime(),
            //     'updated_at' => new DateTime(),
            // ],
            // [
            //     'id' => '2004',
            //     'cycle_type' => 'weekly',
            //     'name' => '木曜',
            //     'created_at' => new DateTime(),
            //     'updated_at' => new DateTime(),
            // ],
            // [
            //     'id' => '2005',
            //     'cycle_type' => 'weekly',
            //     'name' => '金曜',
            //     'created_at' => new DateTime(),
            //     'updated_at' => new DateTime(),
            // ],
            // [
            //     'id' => '2006',
            //     'cycle_type' => 'weekly',
            //     'name' => '土曜',
            //     'created_at' => new DateTime(),
            //     'updated_at' => new DateTime(),
            // ],
            // 日単位
            [
                'id' => '3000',
                'cycle_type' => 'daily',
                'name' => '毎日',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'id' => '3001',
                'cycle_type' => 'daily',
                'name' => '1日おき',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'id' => '3002',
                'cycle_type' => 'daily',
                'name' => '2日おき',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'id' => '3003',
                'cycle_type' => 'daily',
                'name' => '3日おき',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'id' => '3004',
                'cycle_type' => 'daily',
                'name' => '4日おき',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'id' => '3005',
                'cycle_type' => 'daily',
                'name' => '5日おき',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
        ];

        // 登録
        foreach ($habit_cycles as $habit_cycle) {
            DB::table('habit_cycles')->insert($habit_cycle);
        }
    }
}
