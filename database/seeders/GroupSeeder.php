<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // テーブルのクリア
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('groups')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // データ準備
        $groups = [
            [
                'name' => '岡田Family',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'name' => 'チームパンダ',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'name' => '犬Dog\'s',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
        ];

        // 登録
        foreach ($groups as $group) {
            DB::table('groups')->insert($group);
        }
    }
}
