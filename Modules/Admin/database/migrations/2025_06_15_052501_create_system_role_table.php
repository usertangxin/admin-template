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
        Schema::create('system_roles', function (Blueprint $table) {
            $table->comment('角色信息表');
            $table->increments('id')->comment('主键');
            $table->unsignedInteger('parent_id')->nullable()->comment('父ID');
            $table->string('level', 500)->nullable()->comment('组级集合');
            $table->string('name', 30)->nullable()->comment('角色名称');
            $table->string('code', 100)->nullable()->comment('角色代码');
            $table->string('data_scope', 50)->nullable()->default('all')->comment('数据范围:dict=data_scope');
            $table->string('status', 20)->nullable()->default(1)->comment('状态:dict=data_status');
            $table->unsignedSmallInteger('sort')->nullable()->default(0)->comment('排序');
            $table->string('remark')->nullable()->comment('备注');
            $table->integer('created_by')->nullable()->comment('创建者');
            $table->integer('updated_by')->nullable()->comment('更新者');
            $table->dateTime('created_at')->nullable()->comment('创建时间');
            $table->dateTime('updated_at')->nullable()->comment('修改时间');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_roles');
    }
};
