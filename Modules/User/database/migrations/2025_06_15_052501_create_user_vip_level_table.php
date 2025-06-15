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
        Schema::create('user_vip_level', function (Blueprint $table) {
            $table->comment('VIP等级表');
            $table->increments('id')->comment('编号');
            $table->string('name')->comment('等级名称');
            $table->string('icon_image')->nullable()->comment('图标');
            $table->unsignedInteger('level')->unique('level')->comment('等级数值');
            $table->unsignedTinyInteger('status')->default(1)->comment('状态:1=启用,2=禁用');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_vip_level');
    }
};
