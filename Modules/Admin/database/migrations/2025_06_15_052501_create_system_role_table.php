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
        Schema::create('system_role', function (Blueprint $table) {
            $table->comment('角色信息表');
            $table->increments('id')->comment('主键');
            $table->unsignedInteger('parent_id')->nullable()->comment('父ID');
            $table->string('level', 500)->nullable()->comment('组级集合');
            $table->string('name', 30)->nullable()->comment('角色名称');
            $table->string('code', 100)->nullable()->comment('角色代码');
            $table->smallInteger('data_scope')->nullable()->default(1)->comment('数据范围(1:全部数据权限 2:自定义数据权限 3:本部门数据权限 4:本部门及以下数据权限 5:本人数据权限)');
            $table->smallInteger('status')->nullable()->default(1)->comment('状态 (1正常 2停用)');
            $table->unsignedSmallInteger('sort')->nullable()->default(0)->comment('排序');
            $table->string('remark')->nullable()->comment('备注');
            $table->integer('created_by')->nullable()->comment('创建者');
            $table->integer('updated_by')->nullable()->comment('更新者');
            $table->dateTime('create_time')->nullable()->comment('创建时间');
            $table->dateTime('update_time')->nullable()->comment('修改时间');
            $table->dateTime('delete_time')->nullable()->comment('删除时间');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_role');
    }
};
