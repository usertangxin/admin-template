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
        Schema::create('user_banks', function (Blueprint $table) {
            $table->comment('用户银行卡');
            $table->increments('id')->comment('编号');
            $table->unsignedInteger('user_id')->comment('用户编号');
            $table->string('name')->comment('姓名');
            $table->string('bank_name')->comment('开户行');
            $table->string('bank_number')->comment('银行卡号');
            $table->string('bank_phone')->comment('预留手机号');
            $table->dateTime('created_at')->nullable()->comment('添加时间');
            $table->dateTime('updated_at')->nullable()->comment('更新时间');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_banks');
    }
};
