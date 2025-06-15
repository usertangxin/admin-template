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
        Schema::create('system_dict_data', function (Blueprint $table) {
            $table->comment('字典数据表');
            $table->increments('id')->comment('主键');
            $table->unsignedInteger('type_id')->nullable()->index('type_id')->comment('字典类型ID');
            $table->string('label', 50)->nullable()->comment('字典标签');
            $table->string('value', 100)->nullable()->comment('字典值');
            $table->string('code', 100)->nullable()->comment('字典标示');
            $table->unsignedSmallInteger('sort')->nullable()->default(0)->comment('排序');
            $table->smallInteger('status')->nullable()->default(1)->comment('状态 (1正常 2停用)');
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
        Schema::dropIfExists('system_dict_data');
    }
};
