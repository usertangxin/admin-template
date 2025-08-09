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
        Schema::create('system_role_menus', function (Blueprint $table) {
            $table->comment('角色与菜单关联表');
            $table->uuid('id')->primary()->comment('编号');
            $table->unsignedInteger('role_id')->index('system_role_menu_idx_role_id')->comment('角色主键');
            $table->unsignedInteger('url')->index('system_role_menu_idx_url')->comment('菜单');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_role_menus');
    }
};
