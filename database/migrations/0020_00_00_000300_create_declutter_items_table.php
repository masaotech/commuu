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
        Schema::create('declutter_items', function (Blueprint $table) {
            $table->comment('断捨離アイテム');

            $table->id()->comment('アイテムID');
            $table->foreignId('group_id')->comment('グループID')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->mediumText('image_base64')->comment('画像ファイル');
            $table->date('disposal_confirm_at')->comment('処分確認日(yyyy/mm/dd)');
            $table->string('note', 255)->nullable()->comment('メモ欄');
            $table->timestamp('created_at')->comment('登録日時');
            $table->timestamp('updated_at')->comment('更新日時');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('declutter_items');
    }
};
