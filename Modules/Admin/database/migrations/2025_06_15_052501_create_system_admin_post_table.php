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
        Schema::create('system_admin_post', function (Blueprint $table) {
            $table->comment('系统管理员与岗位关联表');
            $table->increments('id')->comment('主键');
            $table->unsignedInteger('admin_id')->index('idx_admin_id')->comment('系统管理员主键');
            $table->unsignedInteger('post_id')->index('idx_post_id')->comment('岗位主键');

            $table->primary(['id', 'admin_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_admin_post');
    }
};
