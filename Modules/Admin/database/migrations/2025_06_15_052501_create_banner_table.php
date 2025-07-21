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
        Schema::create('banners', function (Blueprint $table) {
            $table->comment('轮播图表');
            $table->increments('id')->comment('编号');
            $table->text('img')->nullable()->comment('图片');
            $table->text('link')->nullable()->comment('跳转连接');
            $table->string('link_type')->nullable()->comment('跳转类型:dict=banner_link_type');
            $table->string('position')->nullable()->comment('位置:dict=banner_position');
            $table->integer('sort')->nullable()->default(0)->comment('排序');
            $table->boolean('status')->nullable()->comment('状态:dict=data_status');
            $table->unsignedInteger('created_by')->nullable()->comment('创建者');
            $table->unsignedInteger('updated_by')->nullable()->comment('更新者');
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
        Schema::dropIfExists('banners');
    }
};
