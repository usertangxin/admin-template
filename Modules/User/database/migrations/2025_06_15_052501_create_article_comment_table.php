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
        Schema::create('article_comments', function (Blueprint $table) {
            $table->comment('文章评论');
            $table->uuid('id')->primary();
            $table->unsignedInteger('parent_id')->nullable()->default(0)->comment('父评论编号');
            $table->unsignedInteger('article_id')->nullable()->default(0)->comment('文章编号');
            $table->unsignedInteger('user_id')->nullable()->default(0)->comment('用户编号');
            $table->text('content')->nullable()->comment('评论内容');
            $table->text('images')->nullable()->comment('图片');
            $table->text('videos')->nullable()->comment('视频');
            $table->string('ip', 45)->nullable()->comment('登录IP地址');
            $table->string('ip_location')->nullable()->comment('IP所属地');
            $table->string('os', 50)->nullable()->comment('操作系统');
            $table->string('browser', 50)->nullable()->comment('浏览器');
            $table->dateTime('created_at')->nullable()->comment('创建时间');
            $table->dateTime('updated_at')->nullable()->comment('更新时间');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_comments');
    }
};
