<?php

namespace Modules\User\Tests\Unit;

use Modules\Admin\Tests\AbstractAuthTestCase;
use Modules\User\Models\User;
use Modules\User\Models\UserBalanceLog;
use Modules\User\Observers\UserBalanceObserver;

class UserBalanceObserverTest extends AbstractAuthTestCase
{
    protected User $user;

    protected UserBalanceObserver $observer;

    protected function setUp(): void
    {
        parent::setUp();

        // 创建测试用户
        $this->user = User::factory()->create([
            'balance'        => 100.00,
            'balance_freeze' => 0.00,
        ]);

        // 创建观察者实例
        $this->observer = new UserBalanceObserver;
    }

    public function test_recharge_operation()
    {
        $log = new UserBalanceLog([
            'user_id'   => $this->user->id,
            'balance'   => 50.00,
            'memo'      => '充值测试',
            'operation' => 'recharge',
        ]);

        $this->observer->creating($log);

        // 检查日志记录
        $this->assertEquals(100.00, $log->before);
        $this->assertEquals(150.00, $log->after);

        // 检查用户余额更新
        $this->user->refresh();
        $this->assertEquals(150.00, $this->user->balance);
    }

    public function test_recharge_with_negative_amount()
    {
        $log = new UserBalanceLog([
            'user_id'   => $this->user->id,
            'balance'   => -50.00,
            'memo'      => '负数充值测试',
            'operation' => 'recharge',
        ]);

        $this->expectExceptionMessage(__('user::messages.The amount of the recharge change cannot be less than 0'));

        $this->observer->creating($log);
    }

    public function test_withdraw_operation()
    {
        $log = new UserBalanceLog([
            'user_id'   => $this->user->id,
            'balance'   => -30.00,
            'memo'      => '提现测试',
            'operation' => 'withdraw',
        ]);

        $this->observer->creating($log);

        // 检查日志记录
        $this->assertEquals(100.00, $log->before);
        $this->assertEquals(70.00, $log->after);

        // 检查用户余额更新
        $this->user->refresh();
        $this->assertEquals(70.00, $this->user->balance);
    }

    public function test_withdraw_with_positive_amount()
    {
        $log = new UserBalanceLog([
            'user_id'   => $this->user->id,
            'balance'   => 30.00,
            'memo'      => '正数提现测试',
            'operation' => 'withdraw',
        ]);

        $this->expectExceptionMessage(__('user::messages.The amount for withdrawal modification cannot be greater than 0'));

        $this->observer->creating($log);
    }

    public function test_withdraw_with_insufficient_balance()
    {
        $log = new UserBalanceLog([
            'user_id'   => $this->user->id,
            'balance'   => -150.00,
            'memo'      => '余额不足提现测试',
            'operation' => 'withdraw',
        ]);

        $this->expectExceptionMessage(__('user::messages.Insufficient balance when withdrawing funds'));

        $this->observer->creating($log);
    }

    public function test_consumption_operation()
    {
        $log = new UserBalanceLog([
            'user_id'   => $this->user->id,
            'balance'   => -20.00,
            'memo'      => '消费测试',
            'operation' => 'consumption',
        ]);

        $this->observer->creating($log);

        // 检查日志记录
        $this->assertEquals(100.00, $log->before);
        $this->assertEquals(80.00, $log->after);

        // 检查用户余额更新
        $this->user->refresh();
        $this->assertEquals(80.00, $this->user->balance);
    }

    public function test_consumption_with_positive_amount()
    {
        $log = new UserBalanceLog([
            'user_id'   => $this->user->id,
            'balance'   => 20.00,
            'memo'      => '正数消费测试',
            'operation' => 'consumption',
        ]);

        $this->expectExceptionMessage(__('user::messages.The amount of the consumption change cannot be greater than 0'));

        $this->observer->creating($log);
    }

    public function test_consumption_with_insufficient_balance()
    {
        $log = new UserBalanceLog([
            'user_id'   => $this->user->id,
            'balance'   => -120.00,
            'memo'      => '余额不足消费测试',
            'operation' => 'consumption',
        ]);

        $this->expectExceptionMessage(__('user::messages.Insufficient balance when consuming funds'));

        $this->observer->creating($log);
    }

    public function test_refund_operation()
    {
        $log = new UserBalanceLog([
            'user_id'   => $this->user->id,
            'balance'   => 25.00,
            'memo'      => '退款测试',
            'operation' => 'refund',
        ]);

        $this->observer->creating($log);

        // 检查日志记录
        $this->assertEquals(100.00, $log->before);
        $this->assertEquals(125.00, $log->after);

        // 检查用户余额更新
        $this->user->refresh();
        $this->assertEquals(125.00, $this->user->balance);
    }

    public function test_refund_with_negative_amount()
    {
        $log = new UserBalanceLog([
            'user_id'   => $this->user->id,
            'balance'   => -25.00,
            'memo'      => '负数退款测试',
            'operation' => 'refund',
        ]);

        $this->expectExceptionMessage(__('user::messages.The amount of the refund change cannot be less than 0'));

        $this->observer->creating($log);
    }

    public function test_freeze_operation()
    {
        $this->user->balance_freeze = 10;
        $this->user->save();

        $log = new UserBalanceLog([
            'user_id'   => $this->user->id,
            'balance'   => -30.00,
            'memo'      => '冻结测试',
            'operation' => 'freeze',
        ]);

        $this->observer->creating($log);

        // 检查日志记录
        $this->assertEquals(100.00, $log->before);
        $this->assertEquals(70.00, $log->after);

        // 检查用户余额和冻结余额更新
        $this->user->refresh();
        $this->assertEquals(70.00, $this->user->balance);
        $this->assertEquals(40.00, $this->user->balance_freeze);
    }

    public function test_freeze_with_positive_amount()
    {
        $log = new UserBalanceLog([
            'user_id'   => $this->user->id,
            'balance'   => 30.00,
            'memo'      => '正数冻结测试',
            'operation' => 'freeze',
        ]);

        $this->expectExceptionMessage(__('user::messages.The amount of the freeze change cannot be greater than 0'));

        $this->observer->creating($log);
    }

    public function test_freeze_with_insufficient_balance()
    {
        $log = new UserBalanceLog([
            'user_id'   => $this->user->id,
            'balance'   => -120.00,
            'memo'      => '余额不足冻结测试',
            'operation' => 'freeze',
        ]);

        $this->expectExceptionMessage(__('user::messages.Insufficient balance when freezing funds'));

        $this->observer->creating($log);
    }

    public function test_unfreeze_operation()
    {
        $this->user->balance_freeze = 50;
        $this->user->save();

        $log = new UserBalanceLog([
            'user_id'   => $this->user->id,
            'balance'   => 20.00,
            'memo'      => '解冻测试',
            'operation' => 'unfreeze',
        ]);

        $this->observer->creating($log);

        // 检查日志记录
        $this->assertEquals(100.00, $log->before);
        $this->assertEquals(120.00, $log->after);

        // 检查用户余额和冻结余额更新
        $this->user->refresh();
        $this->assertEquals(120.00, $this->user->balance);
        $this->assertEquals(30.00, $this->user->balance_freeze);
    }

    public function test_unfreeze_with_negative_amount()
    {
        $log = new UserBalanceLog([
            'user_id'   => $this->user->id,
            'balance'   => -20.00,
            'memo'      => '负数解冻测试',
            'operation' => 'unfreeze',
        ]);

        $this->expectExceptionMessage(__('user::messages.The amount of the unfreeze change cannot be less than 0'));

        $this->observer->creating($log);
    }

    public function test_unfreeze_with_insufficient_frozen_balance()
    {
        $this->user->balance_freeze = 10;
        $this->user->save();

        $log = new UserBalanceLog([
            'user_id'   => $this->user->id,
            'balance'   => 20.00,
            'memo'      => '冻结余额不足解冻测试',
            'operation' => 'unfreeze',
        ]);

        $this->expectExceptionMessage(__('user::messages.The frozen balance is insufficient'));

        $this->observer->creating($log);
    }

    public function test_invalid_operation()
    {
        $log = new UserBalanceLog([
            'user_id'   => $this->user->id,
            'balance'   => 50.00,
            'memo'      => '无效操作测试',
            'operation' => 'invalid_operation',
        ]);

        // 不应该执行任何操作
        $this->observer->creating($log);

        // 用户余额应该保持不变
        $this->user->refresh();
        $this->assertEquals(100.00, $this->user->balance);
    }
}
