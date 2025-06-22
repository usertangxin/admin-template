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
        Schema::create('system_config', function (Blueprint $table) {
            $table->comment('参数配置信息表');
            $table->increments('id')->comment('不要使用此字段作为判断依据');
            // $table->integer('group_id')->nullable()->index('group_id')->comment('组id');
            $table->string('key', 32)->comment('配置键名');
            $table->longText('value')->nullable()->comment('配置值');
            // $table->string('name')->nullable()->comment('配置名称');
            // $table->string('input_type', 32)->nullable()->comment('数据输入类型');
            // $table->text('config_select_data')->nullable()->comment('配置选项数据');
            // $table->unsignedSmallInteger('sort')->nullable()->default(0)->comment('排序');
            // $table->string('remark')->nullable()->comment('备注');
            // $table->string('bind_p_config')->nullable()->comment('绑定上级配置');
            // $table->text('input_attr')->nullable()->comment('数据输入属性');

            $table->primary(['id', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_config');
    }
};
