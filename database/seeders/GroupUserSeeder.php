<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;
class GroupUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // テーブルのクリア
        DB::table('group_user')->truncate();

        // データ準備
        $groups_users = [
            [
                'group_id' => 1,
                'user_id' => 4,
                'user_role_id' => 1,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'group_id' => 2,
                'user_id' => 4,
                'user_role_id' => 1,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'group_id' => 3,
                'user_id' => 4,
                'user_role_id' => 2,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'group_id' => 2,
                'user_id' => 5,
                'user_role_id' => 2,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'group_id' => 1,
                'user_id' => 6,
                'user_role_id' => 2,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'group_id' => 3,
                'user_id' => 6,
                'user_role_id' => 1,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            // 以下ゲストユーザー用
            [
                'group_id' => 10,
                'user_id' => 1,
                'user_role_id' => 1,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'group_id' => 11,
                'user_id' => 2,
                'user_role_id' => 1,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'group_id' => 10,
                'user_id' => 2,
                'user_role_id' => 2,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'group_id' => 11,
                'user_id' => 1,
                'user_role_id' => 2,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'group_id' => 11,
                'user_id' => 3,
                'user_role_id' => 2,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
        ];

        // 登録
        foreach ($groups_users as $group_user) {
            DB::table('group_user')->insert($group_user);
        }
    }
}
