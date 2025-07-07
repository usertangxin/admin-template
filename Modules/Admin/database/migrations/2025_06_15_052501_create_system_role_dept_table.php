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
        Schema::create('system_role_dept', function (Blueprint $table) {
            $table->comment('角色与部门关联表');
            $table->increments('id')->comment('编号');
            $table->unsignedInteger('role_id')->index('idx_role_id')->comment('系统管理员主键');
            $table->unsignedInteger('dept_id')->index('idx_dept_id')->comment('角色主键');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_role_dept');
    }
};
