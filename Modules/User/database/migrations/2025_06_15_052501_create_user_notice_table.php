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
        Schema::create('user_notices', function (Blueprint $table) {
            $table->comment('用户公告');
            $table->uuid('id')->primary()->comment('主键');
            $table->string('title')->nullable()->comment('标题');
            $table->string('type')->nullable()->comment('公告类型:dict=user_notice_type');
            $table->text('content')->nullable()->comment('公告内容');
            $table->unsignedInteger('click_num')->nullable()->default(0)->comment('浏览次数');
            $table->string('remark')->nullable()->comment('备注');
            $table->uuid('created_by')->nullable()->comment('创建人');
            $table->uuid('updated_by')->nullable()->comment('更新人');
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
        Schema::dropIfExists('user_notices');
    }
};
