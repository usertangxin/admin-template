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
            $table->comment('参数配置信息表，用来存放用户自定的菜单数据，不存在于配置的菜单不会生效，他只适合用来覆盖配置中的默认值');
            $table->increments('id')->comment('不要使用此字段作为判断依据');
            $table->string('key', 32)->comment('配置键名');
            $table->longText('value')->nullable()->comment('配置值');
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
