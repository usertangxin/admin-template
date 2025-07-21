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
        Schema::create('user_sign_logs', function (Blueprint $table) {
            $table->comment('用户签到日志表');
            $table->increments('id')->comment('编号');
            $table->unsignedInteger('user_id')->comment('用户编号');
            $table->dateTime('create_time')->comment('创建时间');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_sign_log');
    }
};
