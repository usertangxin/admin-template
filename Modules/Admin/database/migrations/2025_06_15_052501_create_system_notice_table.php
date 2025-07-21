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
        Schema::create('system_notices', function (Blueprint $table) {
            $table->comment('系统公告表');
            $table->increments('id')->comment('主键');
            $table->integer('message_id')->nullable()->index('system_notice_message_id')->comment('消息ID');
            $table->string('title')->nullable()->comment('标题');
            $table->string('type', 20)->nullable()->comment('公告类型:dict=backend_notice_type');
            $table->text('content')->nullable()->comment('公告内容');
            $table->integer('click_num')->nullable()->default(0)->comment('浏览次数');
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
        Schema::dropIfExists('system_notices');
    }
};
