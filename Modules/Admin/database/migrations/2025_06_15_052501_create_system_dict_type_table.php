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
        Schema::create('system_dict_types', function (Blueprint $table) {
            $table->comment('字典类型');
            $table->uuid('id')->primary()->comment('主键');
            $table->string('name', 50)->nullable()->comment('字典名称');
            $table->string('code', 100)->nullable()->comment('字典标示');
            $table->string('remark')->nullable()->comment('备注');
            $table->dateTime('created_at')->comment('创建时间');
            $table->dateTime('updated_at')->comment('更新时间');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_dict_types');
    }
};
