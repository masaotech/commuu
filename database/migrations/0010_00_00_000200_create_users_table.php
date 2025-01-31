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
        Schema::create('users', function (Blueprint $table) {
            $table->comment('ユーザー');
            
            $table->id()->comment('ユーザーID');
            $table->string('name')->comment('ユーザー名');
            $table->string('email')->unique()->comment('メールアドレス');
            $table->timestamp('email_verified_at')->nullable()->comment('メールアドレス検証日時');
            $table->string('password')->comment('パスワード');
            $table->foreignId('current_group_id')->nullable()->comment('現在のグループID')->constrained('groups','id')->nullOnDelete()->cascadeOnUpdate();            
            $table->rememberToken()->comment('パスワード再発行トークン');
            $table->timestamp('created_at')->comment('登録日時');
            $table->timestamp('updated_at')->comment('更新日時');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->comment('パスワード再設定トークン');
            
            $table->string('email')->primary()->comment('メールアドレス');
            $table->string('token')->comment('パスワード再発行トークン');
            $table->timestamp('created_at')->nullable()->comment('登録日時');
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->comment('セッション');

            $table->string('id')->primary()->comment('セッションID');
            $table->foreignId('user_id')->nullable()->index()->comment('ユーザーID');
            $table->string('ip_address', 45)->nullable()->comment('IPアドレス');
            $table->text('user_agent')->nullable()->comment('ユーザーエージェント');
            $table->longText('payload')->comment('ペイロード');
            $table->integer('last_activity')->index()->comment('最終アクセス日時(UNIX時間)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
