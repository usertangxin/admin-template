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
            $table->uuid('id')->primary()->comment('主键');
            $table->string('name', 50)->nullable()->comment('菜单名称');
            $table->string('url', 50)->nullable()->comment('菜单URL');
            $table->string('code', 100)->unique('system_menus_code_unique')->comment('菜单标识代码');
            $table->string('parent_code', 100)->nullable()->comment('父菜单标识代码');
            $table->string('icon', 50)->nullable()->comment('菜单图标');
            $table->string('type', 50)->nullable()->comment('菜单类型:dict=menu_type');
            $table->boolean('is_hidden')->default(false)->nullable()->comment('是否隐藏');
            $table->boolean('is_auto_collect')->default(false)->comment('是否自动收集');
            $table->boolean('allow_all')->default(false)->comment('是否允许所有用户访问,包括未登录用户');
            $table->boolean('allow_admin')->default(false)->comment('是否允许你所有管理员访问');
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
