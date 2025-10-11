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
        Schema::create('system_configs', function (Blueprint $table) {
            $table->comment('系统配置');
            $table->uuid('id')->primary()->comment('不要使用此字段作为判断依据');
            $table->string('group')->comment('分组');
            $table->json('name')->comment('配置名称');
            $table->string('key', 100)->unique('system_configs_key_unique')->comment('配置键名');
            $table->string('input_type')->comment('输入类型');
            $table->longText('value')->nullable()->comment('配置值');
            $table->json('remark')->nullable()->comment('备注');
            $table->string('bind_p_config')->nullable()->comment('绑定父配置');
            $table->json('input_attr')->nullable()->comment('输入属性');
            $table->dateTime('created_at')->comment('创建时间');
            $table->dateTime('updated_at')->comment('更新时间');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_configs');
    }
};
