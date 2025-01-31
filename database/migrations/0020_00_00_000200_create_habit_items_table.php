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
        Schema::create('habit_cycles', function (Blueprint $table) {
            $table->comment('定例サイクル');

            $table->unsignedBigInteger('id')->primary()->comment('定例周期ID');
            $table->string('cycle_type', 255)->comment('基準周期(monthly/weekly/daily)');
            $table->string('name', 255)->comment('定例周期名');
            $table->timestamp('created_at')->comment('登録日時');
            $table->timestamp('updated_at')->comment('更新日時');
        });

        Schema::create('habit_items', function (Blueprint $table) {
            $table->comment('定例項目リスト');

            $table->id()->comment('定例項目ID');
            $table->string('name', 255)->comment('定例項目名');
            $table->foreignId('group_id')->comment('グループID')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('habit_cycle_id')->comment('定例周期ID')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedTinyInteger('monthly_start_day')->nullable()->comment('月次開始日(1～28)');
            $table->string('weekly_day_of_week', 255)->nullable()->comment('週次実施曜日(134, 06 等)');
            $table->date('daily_start_date')->nullable()->comment('日次開始日(yyyy/mm/dd)');
            $table->date('habit_schedules_updated_at')->nullable()->comment('スケジュール更新日(yyyy/mm/dd)');
            $table->timestamp('created_at')->comment('登録日時');
            $table->timestamp('updated_at')->comment('更新日時');
        });

        Schema::create('habit_schedules', function (Blueprint $table) {
            $table->comment('定例スケジュール');

            $table->id()->comment('定例スケジュールID');
            $table->foreignId('habit_item_id')->comment('定例項目ID')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->date('scheduled_date')->comment('日次開始日(yyyy/mm/dd)');
            $table->boolean('isComplete')->comment('完了フラグ');
            $table->timestamp('created_at')->comment('登録日時');
            $table->timestamp('updated_at')->comment('更新日時');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habit_cycles');
        Schema::dropIfExists('habit_items');
        Schema::dropIfExists('habit_schedules');
    }
};
