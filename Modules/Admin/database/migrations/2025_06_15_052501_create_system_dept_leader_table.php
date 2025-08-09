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
        Schema::create('system_dept_leaders', function (Blueprint $table) {
            // $table->uuid('id')->primary()->comment('主键');
            $table->comment('部门领导关联表');
            $table->increments('leader_id')->comment('编号');
            $table->unsignedInteger('dept_id')->index('system_dept_leader_idx_dept_id')->comment('部门主键');
            $table->unsignedInteger('admin_id')->index('system_dept_leader_idx_admin_id')->comment('管理员主键');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_dept_leaders');
    }
};
