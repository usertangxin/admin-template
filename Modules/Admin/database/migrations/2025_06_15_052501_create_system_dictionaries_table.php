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
        Schema::create('system_dictionaries', function (Blueprint $table) {
            $table->comment('字典数据');
            $table->uuid('id')->primary()->comment('主键');
            $table->json('label')->comment('字典标签');
            $table->string('value', 100)->comment('字典值');
            $table->string('code', 100)->comment('字典标示');
            $table->string('color', 10)->nullable()->comment('颜色');
            $table->json('remark')->nullable()->comment('备注');
            $table->string('status')->default('normal')->comment('状态:dict=data_status');
            $table->dateTime('created_at')->comment('创建时间');
            $table->dateTime('updated_at')->comment('更新时间');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_dictionaries');
    }
};
