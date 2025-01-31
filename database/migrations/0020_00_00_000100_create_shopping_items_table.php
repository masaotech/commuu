<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shopping_items', function (Blueprint $table) {
            $table->comment('買い物リスト');

            $table->id()->comment('商品ID');
            $table->string('name', 255)->comment('商品名');
            $table->foreignId('group_id')->comment('グループID')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('item_category_id')->comment('商品カテゴリID');
            $table->unsignedBigInteger('item_status_code_id')->comment('商品ステータスID');
            $table->timestamp('created_at')->comment('登録日時');
            $table->timestamp('updated_at')->comment('更新日時');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shopping_items');
    }
};
