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
        Schema::create('system_menus', function (Blueprint $table) {
            $table->comment('菜单信息表');
            $table->increments('id')->comment('主键');
            $table->string('name', 50)->nullable()->comment('菜单名称');
            $table->string('url', 50)->nullable()->comment('菜单URL');
            $table->string('code', 100)->nullable()->comment('菜单标识代码');
            $table->string('parent_code', 100)->nullable()->comment('父菜单标识代码');
            $table->string('icon', 50)->nullable()->comment('菜单图标');
            $table->string('type', 50)->nullable()->comment('菜单类型:dict=menu_type');
            $table->boolean('is_hidden')->nullable()->comment('是否隐藏');
            $table->dateTime('created_at')->nullable()->comment('创建时间');
            $table->dateTime('updated_at')->nullable()->comment('更新时间');
            $table->string('remark')->nullable()->comment('备注');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_menus');
    }
};
