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
        Schema::create('system_user_role', function (Blueprint $table) {
            $table->comment('用户与角色关联表');
            $table->increments('id')->comment('编号');
            $table->unsignedInteger('user_id')->index('idx_user_id')->comment('用户主键');
            $table->unsignedInteger('role_id')->index('idx_role_id')->comment('角色主键');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_user_role');
    }
};
