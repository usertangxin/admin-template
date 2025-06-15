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
        Schema::create('tool_generate_columns', function (Blueprint $table) {
            $table->comment('代码生成业务字段表');
            $table->increments('id')->comment('主键');
            $table->unsignedInteger('table_id')->nullable()->comment('所属表ID');
            $table->string('column_name', 200)->nullable()->comment('字段名称');
            $table->string('column_comment')->nullable()->comment('字段注释');
            $table->string('column_type', 50)->nullable()->comment('字段类型');
            $table->string('default_value', 50)->nullable()->comment('默认值');
            $table->smallInteger('is_pk')->nullable()->default(1)->comment('1 非主键 2 主键');
            $table->smallInteger('is_required')->nullable()->default(1)->comment('1 非必填 2 必填');
            $table->smallInteger('is_insert')->nullable()->default(1)->comment('1 非插入字段 2 插入字段');
            $table->smallInteger('is_edit')->nullable()->default(1)->comment('1 非编辑字段 2 编辑字段');
            $table->smallInteger('is_list')->nullable()->default(1)->comment('1 非列表显示字段 2 列表显示字段');
            $table->smallInteger('is_query')->nullable()->default(1)->comment('1 非查询字段 2 查询字段');
            $table->smallInteger('is_sort')->nullable()->default(1)->comment('1 非排序 2 排序');
            $table->string('query_type', 100)->nullable()->default('eq')->comment('查询方式 eq 等于, neq 不等于, gt 大于, lt 小于, like 范围');
            $table->string('view_type', 100)->nullable()->default('text')->comment('页面控件,text, textarea, password, select, checkbox, radio, date, upload, ma-upload(封装的上传控件)');
            $table->string('dict_type', 200)->nullable()->comment('字典类型');
            $table->string('allow_roles')->nullable()->comment('允许查看该字段的角色');
            $table->string('options', 1000)->nullable()->comment('字段其他设置');
            $table->unsignedTinyInteger('sort')->nullable()->default(0)->comment('排序');
            $table->string('remark')->nullable()->comment('备注');
            $table->integer('created_by')->nullable()->comment('创建者');
            $table->integer('updated_by')->nullable()->comment('更新者');
            $table->dateTime('create_time')->nullable()->comment('创建时间');
            $table->dateTime('update_time')->nullable()->comment('修改时间');
            $table->dateTime('delete_time')->nullable()->comment('删除时间');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tool_generate_columns');
    }
};
