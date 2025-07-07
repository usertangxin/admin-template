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
        Schema::create('system_menu', function (Blueprint $table) {
            $table->comment('菜单信息表，用来存放用户自定的菜单数据，不存在于配置的菜单不会生效，他只适合用来覆盖配置中的默认值');
            $table->increments('id')->comment('主键');
            $table->string('name', 50)->nullable()->comment('菜单名称');
            $table->string('code', 100)->nullable()->comment('菜单标识代码');
            $table->string('icon', 50)->nullable()->comment('菜单图标');
            $table->boolean('is_hidden')->nullable()->comment('是否隐藏');
            $table->string('remark')->nullable()->comment('备注');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_menu');
    }
};
