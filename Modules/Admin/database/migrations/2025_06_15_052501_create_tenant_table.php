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
        Schema::create('tenants', function (Blueprint $table) {
            $table->comment('租户管理');
            $table->uuid('id')->primary()->comment('编号');
            $table->string('name')->unique('name_unique')->comment('租户名称');
            $table->string('contact_name')->nullable()->comment('联系人姓名');
            $table->string('phone')->nullable()->comment('联系电话');
            $table->string('db_type')->comment('数据库类型');
            $table->string('db_hostname')->comment('服务器地址');
            $table->string('db_database')->comment('数据库名');
            $table->string('db_username')->comment('数据库用户名');
            $table->string('db_password')->comment('数据库密码');
            $table->string('db_hostport')->comment('数据库连接端口');
            $table->string('status')->nullable()->default('normal')->comment('状态:dict=data_status');
            $table->dateTime('created_at')->nullable()->comment('创建时间');
            $table->dateTime('updated_at')->nullable()->comment('更新时间');
            $table->dateTime('deleted_at')->nullable()->comment('删除时间');
            $table->dateTime('expired_at')->nullable()->comment('到期时间');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
