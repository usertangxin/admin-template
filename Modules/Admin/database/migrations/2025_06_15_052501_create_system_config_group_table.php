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
        Schema::create('system_config_group', function (Blueprint $table) {
            $table->comment('参数配置分组表');
            $table->increments('id')->comment('主键');
            $table->string('name', 50)->nullable()->comment('字典名称');
            $table->string('code', 100)->nullable()->comment('字典标示');
            $table->string('remark')->nullable()->comment('备注');
            $table->integer('created_by')->nullable()->comment('创建人');
            $table->integer('updated_by')->nullable()->comment('更新人');
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
        Schema::dropIfExists('system_config_group');
    }
};
