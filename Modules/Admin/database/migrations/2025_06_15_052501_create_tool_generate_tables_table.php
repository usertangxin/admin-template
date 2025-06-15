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
        Schema::create('tool_generate_tables', function (Blueprint $table) {
            $table->comment('代码生成业务表');
            $table->increments('id')->comment('主键');
            $table->string('table_name', 200)->nullable()->comment('表名称');
            $table->string('table_comment', 500)->nullable()->comment('表注释');
            $table->string('stub', 50)->nullable()->comment('stub类型');
            $table->string('template', 50)->nullable()->comment('模板名称');
            $table->string('namespace')->nullable()->comment('命名空间');
            $table->string('package_name', 100)->nullable()->comment('控制器包名');
            $table->string('business_name', 50)->nullable()->comment('业务名称');
            $table->string('class_name', 50)->nullable()->comment('类名称');
            $table->string('menu_name', 100)->nullable()->comment('生成菜单名');
            $table->integer('belong_menu_id')->nullable()->comment('所属菜单');
            $table->string('tpl_category', 100)->nullable()->comment('生成类型,single 单表CRUD,tree 树表CRUD,parent_sub父子表CRUD');
            $table->smallInteger('generate_type')->nullable()->default(1)->comment('1 压缩包下载 2 生成到模块');
            $table->string('generate_path', 100)->nullable()->default('saiadmin-vue')->comment('前端根目录');
            $table->smallInteger('generate_model')->nullable()->default(1)->comment('1 软删除 2 非软删除');
            $table->string('generate_menus')->nullable()->comment('生成菜单列表');
            $table->smallInteger('build_menu')->nullable()->default(1)->comment('是否构建菜单');
            $table->smallInteger('component_type')->nullable()->default(1)->comment('组件显示方式');
            $table->string('options', 1500)->nullable()->comment('其他业务选项');
            $table->integer('form_width')->nullable()->default(600)->comment('表单宽度');
            $table->boolean('is_full')->nullable()->default(true)->comment('是否全屏');
            $table->string('remark')->nullable()->comment('备注');
            $table->string('source')->nullable()->comment('数据源');
            $table->integer('created_by')->nullable()->comment('创建者');
            $table->integer('updated_by')->nullable()->comment('更新者');
            $table->dateTime('create_time')->nullable()->comment('创建时间');
            $table->dateTime('update_time')->nullable()->comment('修改时间');
            $table->dateTime('delete_time')->nullable()->comment('删除时间');
            $table->string('port_type')->nullable()->default('saiadmin')->comment('端口类型');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tool_generate_tables');
    }
};
