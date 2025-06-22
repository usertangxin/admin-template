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
            $table->comment('菜单信息表');
            $table->increments('id')->comment('主键');
            $table->unsignedInteger('parent_id')->nullable()->comment('父ID');
            $table->string('level', 500)->nullable()->comment('组级集合');
            $table->string('name', 50)->nullable()->comment('菜单名称');
            $table->string('code', 100)->nullable()->comment('菜单标识代码');
            $table->string('icon', 50)->nullable()->comment('菜单图标');
            $table->string('route', 200)->nullable()->comment('路由地址');
            $table->string('component')->nullable()->comment('组件路径');
            $table->string('redirect')->nullable()->comment('跳转地址');
            $table->smallInteger('is_hidden')->nullable()->default(1)->comment('是否隐藏 (1是 2否)');
            $table->unsignedTinyInteger('is_layout')->nullable()->default(1)->comment('继承layout');
            $table->char('type', 1)->nullable()->default('')->comment('菜单类型, (M菜单 B按钮 L链接 I iframe)');
            $table->integer('generate_id')->nullable()->default(0)->comment('生成id');
            $table->string('generate_key')->nullable()->comment('生成key');
            $table->smallInteger('status')->nullable()->default(1)->comment('状态 (1正常 2停用)');
            $table->unsignedSmallInteger('sort')->nullable()->default(0)->comment('排序');
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
