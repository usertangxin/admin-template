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
        Schema::create('user_yongjin_log', function (Blueprint $table) {
            $table->comment('用户佣金变更表');
            $table->increments('id')->comment('编号');
            $table->unsignedInteger('user_id')->comment('用户编号');
            $table->decimal('yongjin', 10, 0)->comment('变更金额');
            $table->decimal('before', 10, 0)->comment('变更前');
            $table->decimal('after', 10, 0)->comment('变更后');
            $table->string('memo')->comment('备注');
            $table->dateTime('create_time')->nullable()->comment('创建时间');
            $table->unsignedInteger('created_by')->nullable()->comment('创建者');
            $table->tinyInteger('order_type')->nullable()->comment('订单类型:dict=order_type');
            $table->unsignedInteger('order_house_id')->nullable()->comment('订房订单编号');
            $table->unsignedInteger('order_assembly_id')->nullable()->comment('轮住订单编号');
            $table->unsignedInteger('order_house_together_id')->nullable()->comment('拼房订单编号');
            $table->unsignedInteger('order_scenic_spot_ticket_id')->nullable()->comment('门票订单编号');
            $table->unsignedInteger('order_mall_id')->nullable()->comment('地标地产商城订单编号');
            $table->unsignedInteger('order_integral_id')->nullable()->comment('积分商城订单编号');
            $table->unsignedInteger('from_user_id')->nullable()->comment('金额来自某个用户');
            $table->tinyInteger('mark')->nullable()->default(6)->comment('标记:dict=yongjin_mark');
            $table->integer('base_id')->nullable()->comment('基地编号');
            $table->integer('scenic_spot_id')->nullable()->comment('景点编号');
            $table->decimal('overflow_price', 15)->unsigned()->nullable()->comment('溢价');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_yongjin_log');
    }
};
