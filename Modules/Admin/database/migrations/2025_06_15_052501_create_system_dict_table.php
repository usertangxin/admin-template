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
        Schema::create('system_dicts', function (Blueprint $table) {
            $table->comment('字典数据表，用来存放用户自定的菜单数据，不存在于配置的菜单不会生效，他只适合用来覆盖配置中的默认值');
            $table->increments('id')->comment('主键');
            $table->string('label', 50)->nullable()->comment('字典标签');
            $table->string('value', 100)->nullable()->comment('字典值');
            $table->string('code', 100)->nullable()->comment('字典标示');
            $table->string('color', 10)->nullable()->comment('颜色');
            $table->string('remark')->nullable()->comment('备注');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_dicts');
    }
};
