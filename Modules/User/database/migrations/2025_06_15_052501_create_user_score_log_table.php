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
        Schema::create('user_score_logs', function (Blueprint $table) {
            $table->comment('用户积分变更记录表');
            $table->increments('id')->comment('编号');
            $table->unsignedInteger('user_id')->comment('用户编号');
            $table->integer('score')->comment('变更数量');
            $table->integer('before')->comment('变更前');
            $table->integer('after')->comment('变更后');
            $table->string('memo')->comment('备注');
            $table->unsignedInteger('created_by')->nullable()->comment('创建者');
            $table->dateTime('created_at')->nullable()->comment('创建时间');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_score_logs');
    }
};
