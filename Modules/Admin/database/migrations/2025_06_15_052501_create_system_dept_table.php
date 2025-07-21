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
        Schema::create('system_depts', function (Blueprint $table) {
            $table->comment('部门信息表');
            $table->increments('id')->comment('主键');
            $table->unsignedInteger('parent_id')->nullable()->index('system_dept_parent_id')->comment('父ID');
            $table->string('level', 500)->nullable()->comment('组级集合');
            $table->string('name', 30)->nullable()->comment('部门名称');
            $table->smallInteger('status')->nullable()->default(1)->comment('状态:dict=data_status');
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
        Schema::dropIfExists('system_depts');
    }
};
