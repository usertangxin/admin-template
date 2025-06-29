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
        Schema::create('system_dict_type', function (Blueprint $table) {
            $table->comment('字典类型表');
            $table->increments('id')->comment('主键');
            $table->string('name', 50)->nullable()->comment('字典名称');
            $table->string('code', 100)->nullable()->comment('字典标示');
            $table->string('remark')->nullable()->comment('备注');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_dict_type');
    }
};
