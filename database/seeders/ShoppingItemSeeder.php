<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;
class ShoppingItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // テーブルのクリア
        DB::table('shopping_items')->truncate();

        // データ準備
        $shopping_items = [
            [
                'group_id' => 1,
                'name' => 'たまご',
                'item_status_code_id' => '1',
                'item_category_id' => '1',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'group_id' => 1,
                'name' => '牛乳',
                'item_status_code_id' => '1',
                'item_category_id' => '1',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'group_id' => 1,
                'name' => 'トイレットペーパー',
                'item_status_code_id' => '0',
                'item_category_id' => '2',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'group_id' => 1,
                'name' => '猫缶',
                'item_status_code_id' => '1',
                'item_category_id' => '5',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'group_id' => 1,
                'name' => '納豆',
                'item_status_code_id' => '1',
                'item_category_id' => '1',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'group_id' => 1,
                'name' => '冷凍ブロッコリー',
                'item_status_code_id' => '1',
                'item_category_id' => '2',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'group_id' => 1,
                'name' => '醤油',
                'item_status_code_id' => '0',
                'item_category_id' => '3',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'group_id' => 1,
                'name' => 'カップラーメン',
                'item_status_code_id' => '0',
                'item_category_id' => '5',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'group_id' => 1,
                'name' => 'ふりかけ',
                'item_status_code_id' => '1',
                'item_category_id' => '1',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'group_id' => 1,
                'name' => 'わかめ',
                'item_status_code_id' => '0',
                'item_category_id' => '3',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'group_id' => 1,
                'name' => '料理酒',
                'item_status_code_id' => '1',
                'item_category_id' => '3',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'group_id' => 1,
                'name' => '小麦粉',
                'item_status_code_id' => '1',
                'item_category_id' => '1',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'group_id' => 1,
                'name' => '醤油',
                'item_status_code_id' => '0',
                'item_category_id' => '4',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'group_id' => 1,
                'name' => '調理種',
                'item_status_code_id' => '1',
                'item_category_id' => '4',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'group_id' => 1,
                'name' => 'ピーマン',
                'item_status_code_id' => '0',
                'item_category_id' => '1',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'group_id' => 1,
                'name' => '玉ねぎ',
                'item_status_code_id' => '1',
                'item_category_id' => '5',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'group_id' => 1,
                'name' => 'にんにく',
                'item_status_code_id' => '1',
                'item_category_id' => '1',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'group_id' => 1,
                'name' => 'もやし',
                'item_status_code_id' => '1',
                'item_category_id' => '4',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'group_id' => 1,
                'name' => 'パスタ麺',
                'item_status_code_id' => '0',
                'item_category_id' => '1',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'group_id' => 1,
                'name' => 'ヨーグルト',
                'item_status_code_id' => '0',
                'item_category_id' => '1',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'group_id' => 1,
                'name' => '片栗粉',
                'item_status_code_id' => '1',
                'item_category_id' => '1',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'group_id' => 1,
                'name' => 'ポン酢',
                'item_status_code_id' => '1',
                'item_category_id' => '1',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'group_id' => 2,
                'name' => '焼きのり',
                'item_status_code_id' => '1',
                'item_category_id' => '2',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'group_id' => 2,
                'name' => '醤油',
                'item_status_code_id' => '0',
                'item_category_id' => '1',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'group_id' => 3,
                'name' => 'ドッグフード',
                'item_status_code_id' => '1',
                'item_category_id' => '2',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'group_id' => 3,
                'name' => '犬小屋',
                'item_status_code_id' => '0',
                'item_category_id' => '4',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],

        ];

        // 登録
        foreach ($shopping_items as $shopping_item) {
            DB::table('shopping_items')->insert($shopping_item);
        }
    }
}
