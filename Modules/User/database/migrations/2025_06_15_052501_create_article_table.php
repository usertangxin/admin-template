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
        Schema::create('articles', function (Blueprint $table) {
            $table->comment('文章');
            $table->uuid('id')->primary()->comment('编号');
            $table->unsignedInteger('user_id')->comment('用户编号');
            $table->string('title')->comment('标题');
            $table->text('content')->nullable()->comment('内容');
            $table->text('imgs')->nullable()->comment('图集:type=array');
            $table->unsignedInteger('read')->default(0)->comment('阅读量');
            $table->unsignedInteger('collect')->default(0)->comment('收藏量');
            $table->unsignedInteger('sort')->nullable()->default(0)->comment('排序');
            $table->boolean('status')->nullable()->comment('状态:dict=data_status');
            $table->boolean('audit_status')->nullable()->comment('审核状态:dict=audit_status');
            $table->string('created_by',36)->nullable()->comment('创建者');
            $table->string('updated_by',36)->nullable()->comment('更新者');
            $table->dateTime('created_at')->nullable()->comment('创建时间');
            $table->dateTime('updated_at')->nullable()->comment('修改时间');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间');
            $table->string('ip', 45)->nullable()->comment('登录IP地址');
            $table->string('ip_location')->nullable()->comment('IP所属地');
            $table->string('os', 50)->nullable()->comment('操作系统');
            $table->string('browser', 50)->nullable()->comment('浏览器');
            $table->string('audit_remark')->nullable()->comment('审核意见');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
