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
        Schema::create('system_config', function (Blueprint $table) {
            $table->comment('参数配置信息表');
            $table->increments('id')->comment('不要使用此字段作为判断依据');
            $table->string('key', 32)->comment('配置键名');
            $table->longText('value')->nullable()->comment('配置值');
            $table->primary(['id', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_config');
    }
};
