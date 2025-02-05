<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DateTime;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // テーブルのクリア
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // データ準備
        $users = [
            // 以下 1, 2, 3 はゲストユーザー用
            [
                'id' => 1,
                'name' => 'ゲストA',
                'email' => 'guest-a@masaotech.com',
                'email_verified_at' => new DateTime(),
                'password' => Hash::make('z/f|tuwUwzP4$F)%#*NJjguXeZpX+JMy'),
                'current_group_id' => 10,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'id' => 2,
                'name' => 'ゲストB',
                'email' => 'guest-b@masaotech.com',
                'email_verified_at' => new DateTime(),
                'password' => Hash::make('n$8e/W)vGs9R_jUXdYJG$!t#E*3!~6.+'),
                'current_group_id' => 11,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'id' => 3,
                'name' => 'ゲストC',
                'email' => 'guest-c@masaotech.com',
                'email_verified_at' => new DateTime(),
                'password' => Hash::make('g%p77gP|xhdshXJG9cn!jv_u2Q~D|F~C'),
                'current_group_id' => 11,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'id' => 4,
                'name' => 'user004',
                'email' => 'user004@example.com',
                'email_verified_at' => new DateTime(),
                'password' => Hash::make('password'),
                'current_group_id' => 2,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'id' => 5,
                'name' => 'user005',
                'email' => 'user005@example.com',
                'email_verified_at' => new DateTime(),
                'password' => Hash::make('password'),
                'current_group_id' => 2,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'id' => 6,
                'name' => 'user006',
                'email' => 'user006@example.com',
                'email_verified_at' => new DateTime(),
                'password' => Hash::make('password'),
                'current_group_id' => 3,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
        ];

        // 登録
        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }
    }
}
