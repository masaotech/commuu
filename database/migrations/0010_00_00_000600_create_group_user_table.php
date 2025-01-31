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
        Schema::create('group_user', function (Blueprint $table) {
            $table->comment('グループユーザー[中間]');

            $table->id()->comment('グループユーザーID');
            $table->foreignId('group_id')->comment('グループID')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('user_id')->comment('ユーザーID')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('user_role_id')->comment('ユーザー権限ID')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamp('created_at')->comment('登録日時');
            $table->timestamp('updated_at')->comment('更新日時');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_user');
    }
};
