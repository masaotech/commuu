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
            [
                'name' => 'user001',
                'email' => 'user001@example.com',
                'email_verified_at' => new DateTime(),
                'password' => Hash::make('password'),
                'current_group_id' => 2,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'name' => 'user002',
                'email' => 'user002@example.com',
                'email_verified_at' => new DateTime(),
                'password' => Hash::make('password'),
                'current_group_id' => 2,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'name' => 'user003',
                'email' => 'user003@example.com',
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
