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
        Schema::create('system_messages', function (Blueprint $table) {
            $table->comment('系统消息表');
            $table->uuid('id')->primary()->comment('主键');
            $table->unsignedInteger('message_id')->nullable()->index('system_message_message_id')->comment('消息ID');
            $table->string('title')->nullable()->comment('标题');
            $table->string('type', 20)->nullable()->comment('消息类型:dict=admin_message_type');
            $table->text('content')->nullable()->comment('消息内容');
            $table->unsignedInteger('click_num')->nullable()->default(0)->comment('浏览次数');
            $table->string('remark')->nullable()->comment('备注');
            $table->string('created_by', 36)->nullable()->comment('创建人');
            $table->string('updated_by', 36)->nullable()->comment('更新人');
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
        Schema::dropIfExists('system_messages');
    }
};
