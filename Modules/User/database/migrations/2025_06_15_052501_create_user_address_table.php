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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->comment('用户地址');
            $table->increments('id')->comment('编号');
            $table->unsignedInteger('user_id')->comment('用户编号');
            $table->string('name')->nullable()->comment('姓名');
            $table->string('phone')->nullable()->comment('电话');
            $table->string('province', 200)->default('')->comment('省');
            $table->string('province_code')->nullable()->comment('省code');
            $table->string('city', 200)->default('')->comment('市');
            $table->string('city_code')->nullable()->comment('市code');
            $table->string('district', 200)->default('')->comment('区');
            $table->string('district_code')->nullable()->comment('区code');
            $table->string('detail')->comment('详细地址');
            $table->unsignedTinyInteger('is_default')->default(2)->comment('是否是详细地址:dict=yes_or_no');
            $table->dateTime('create_time')->nullable()->comment('插入时间');
            $table->dateTime('update_time')->nullable()->comment('更新时间');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_address');
    }
};
