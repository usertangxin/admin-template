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
        Schema::create('system_dict_data', function (Blueprint $table) {
            $table->comment('字典数据表');
            $table->increments('id')->comment('主键');
            $table->string('label', 50)->nullable()->comment('字典标签');
            $table->string('value', 100)->nullable()->comment('字典值');
            $table->string('code', 100)->nullable()->comment('字典标示');
            $table->string('remark')->nullable()->comment('备注');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_dict_data');
    }
};
