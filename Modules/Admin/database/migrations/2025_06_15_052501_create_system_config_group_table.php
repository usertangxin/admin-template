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
        Schema::create('system_config_groups', function (Blueprint $table) {
            $table->comment('系统配置分组');
            $table->increments('id')->comment('不要使用此字段作为判断存在依据');
            $table->string('name', 32)->comment('分组名称');
            $table->string('code', 50)->unique('system_config_groups_code_unique')->comment('分组编码');
            $table->string('remark', 200)->nullable()->comment('分组备注');
            $table->datetime('created_at')->comment('创建时间');
            $table->datetime('updated_at')->comment('更新时间');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_config_groups');
    }
};
