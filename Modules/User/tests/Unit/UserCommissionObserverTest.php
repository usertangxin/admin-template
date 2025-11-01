<?php

namespace Modules\User\Tests\Unit;

use Modules\Admin\Tests\AbstractAuthTestCase;
use Modules\User\Models\User;
use Modules\User\Models\UserCommissionLog;
use Modules\User\Observers\UserCommissionObserver;

class UserCommissionObserverTest extends AbstractAuthTestCase
{
    protected User $user;

    protected UserCommissionObserver $observer;

    protected function setUp(): void
    {
        parent::setUp();

        // 创建测试用户
        $this->user = User::factory()->create([
            'commission'        => 100.00,
            'commission_freeze' => 0.00,
        ]);

        // 创建观察者实例
        $this->observer = new UserCommissionObserver;
    }

    public function test_consumption_returns_commission_operation()
    {
        $log = new UserCommissionLog([
            'user_id'    => $this->user->id,
            'commission' => 50.00,
            'memo'       => '消费返佣测试',
            'operation'  => 'consumption_returns_commission',
        ]);

        $this->observer->creating($log);

        // 检查日志记录
        $this->assertEquals(100.00, $log->before);
        $this->assertEquals(150.00, $log->after);

        // 检查用户佣金更新
        $this->user->refresh();
        $this->assertEquals(150.00, $this->user->commission);
    }

    public function test_consumption_returns_commission_with_negative_amount()
    {
        $log = new UserCommissionLog([
            'user_id'    => $this->user->id,
            'commission' => -50.00,
            'memo'       => '负数消费返佣测试',
            'operation'  => 'consumption_returns_commission',
        ]);

        $this->expectExceptionMessage(__('user::messages.The amount of the commission change cannot be less than 0'));

        $this->observer->creating($log);
    }

    public function test_withdraw_operation()
    {
        $log = new UserCommissionLog([
            'user_id'    => $this->user->id,
            'commission' => -30.00,
            'memo'       => '提现测试',
            'operation'  => 'withdraw',
        ]);

        $this->observer->creating($log);

        // 检查日志记录
        $this->assertEquals(100.00, $log->before);
        $this->assertEquals(70.00, $log->after);

        // 检查用户佣金更新
        $this->user->refresh();
        $this->assertEquals(70.00, $this->user->commission);
    }

    public function test_withdraw_with_positive_amount()
    {
        $log = new UserCommissionLog([
            'user_id'    => $this->user->id,
            'commission' => 30.00,
            'memo'       => '正数提现测试',
            'operation'  => 'withdraw',
        ]);

        $this->expectExceptionMessage(__('user::messages.The amount for withdrawal modification cannot be greater than 0'));

        $this->observer->creating($log);
    }

    public function test_withdraw_with_insufficient_commission()
    {
        $log = new UserCommissionLog([
            'user_id'    => $this->user->id,
            'commission' => -150.00,
            'memo'       => '佣金不足提现测试',
            'operation'  => 'withdraw',
        ]);

        $this->expectExceptionMessage(__('user::messages.Insufficient commission when withdrawing funds'));

        $this->observer->creating($log);
    }

    public function test_freeze_operation()
    {
        $this->user->commission_freeze = 10;
        $this->user->save();

        $log = new UserCommissionLog([
            'user_id'    => $this->user->id,
            'commission' => -30.00,
            'memo'       => '冻结测试',
            'operation'  => 'freeze',
        ]);

        $this->observer->creating($log);

        // 检查日志记录
        $this->assertEquals(100.00, $log->before);
        $this->assertEquals(70.00, $log->after);

        // 检查用户佣金和冻结佣金更新
        $this->user->refresh();
        $this->assertEquals(70.00, $this->user->commission);
        $this->assertEquals(40.00, $this->user->commission_freeze);
    }

    public function test_freeze_with_positive_amount()
    {
        $log = new UserCommissionLog([
            'user_id'    => $this->user->id,
            'commission' => 30.00,
            'memo'       => '正数冻结测试',
            'operation'  => 'freeze',
        ]);

        $this->expectExceptionMessage(__('user::messages.The amount of the freeze change cannot be greater than 0'));

        $this->observer->creating($log);
    }

    public function test_freeze_with_insufficient_commission()
    {
        $log = new UserCommissionLog([
            'user_id'    => $this->user->id,
            'commission' => -120.00,
            'memo'       => '佣金不足冻结测试',
            'operation'  => 'freeze',
        ]);

        $this->expectExceptionMessage(__('user::messages.Insufficient commission when freezing funds'));

        $this->observer->creating($log);
    }

    public function test_unfreeze_operation()
    {
        $this->user->commission_freeze = 50;
        $this->user->save();

        $log = new UserCommissionLog([
            'user_id'    => $this->user->id,
            'commission' => 20.00,
            'memo'       => '解冻测试',
            'operation'  => 'unfreeze',
        ]);

        $this->observer->creating($log);

        // 检查日志记录
        $this->assertEquals(100.00, $log->before);
        $this->assertEquals(120.00, $log->after);

        // 检查用户佣金和冻结佣金更新
        $this->user->refresh();
        $this->assertEquals(120.00, $this->user->commission);
        $this->assertEquals(30.00, $this->user->commission_freeze);
    }

    public function test_unfreeze_with_negative_amount()
    {
        $log = new UserCommissionLog([
            'user_id'    => $this->user->id,
            'commission' => -20.00,
            'memo'       => '负数解冻测试',
            'operation'  => 'unfreeze',
        ]);

        $this->expectExceptionMessage(__('user::messages.The amount of the unfreeze change cannot be less than 0'));

        $this->observer->creating($log);
    }

    public function test_unfreeze_with_insufficient_frozen_commission()
    {
        $this->user->commission_freeze = 10;
        $this->user->save();

        $log = new UserCommissionLog([
            'user_id'    => $this->user->id,
            'commission' => 20.00,
            'memo'       => '冻结佣金不足解冻测试',
            'operation'  => 'unfreeze',
        ]);

        $this->expectExceptionMessage(__('user::messages.The frozen commission is insufficient'));

        $this->observer->creating($log);
    }

    public function test_invalid_operation()
    {
        $log = new UserCommissionLog([
            'user_id'    => $this->user->id,
            'commission' => 50.00,
            'memo'       => '无效操作测试',
            'operation'  => 'invalid_operation',
        ]);

        // 不应该执行任何操作
        $this->observer->creating($log);

        // 用户佣金应该保持不变
        $this->user->refresh();
        $this->assertEquals(100.00, $this->user->commission);
    }
}
