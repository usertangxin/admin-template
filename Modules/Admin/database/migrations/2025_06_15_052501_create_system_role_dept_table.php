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
        Schema::create('system_role_depts', function (Blueprint $table) {
            $table->comment('角色与部门关联表');
            $table->increments('id')->comment('编号');
            $table->unsignedInteger('role_id')->index('system_role_dept_idx_role_id')->comment('系统角色主键');
            $table->unsignedInteger('dept_id')->index('system_role_dept_idx_dept_id')->comment('部门主键');
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
