<?php

namespace Modules\User\Tests\Unit;

use Modules\Admin\Tests\AbstractAuthTestCase;
use Modules\User\Models\User;
use Modules\User\Models\UserIntegralLog;
use Modules\User\Observers\UserIntegralObserver;

class UserIntegralObserverTest extends AbstractAuthTestCase
{
    protected User $user;

    protected UserIntegralObserver $observer;

    protected function setUp(): void
    {
        parent::setUp();

        // 创建测试用户
        $this->user = User::factory()->create([
            'integral'        => 100,
            'integral_freeze' => 0,
        ]);

        // 创建观察者实例
        $this->observer = new UserIntegralObserver;
    }

    public function test_consumption_returns_integral_operation()
    {
        $log = new UserIntegralLog([
            'user_id'   => $this->user->id,
            'integral'  => 50,
            'memo'      => '消费返积分测试',
            'operation' => 'consumption_returns_integral',
        ]);

        $this->observer->creating($log);

        // 检查日志记录
        $this->assertEquals(100, $log->before);
        $this->assertEquals(150, $log->after);

        // 检查用户积分更新
        $this->user->refresh();
        $this->assertEquals(150, $this->user->integral);
    }

    public function test_consumption_returns_integral_with_negative_value()
    {
        $log = new UserIntegralLog([
            'user_id'   => $this->user->id,
            'integral'  => -50,
            'memo'      => '消费返积分负值测试',
            'operation' => 'consumption_returns_integral',
        ]);

        $this->expectExceptionMessage(__('user::messages.The amount of the integral change cannot be less than 0'));

        $this->observer->creating($log);
    }

    public function test_deduction_operation()
    {
        $log = new UserIntegralLog([
            'user_id'   => $this->user->id,
            'integral'  => -30,
            'memo'      => '积分抵扣测试',
            'operation' => 'deduction',
        ]);

        $this->observer->creating($log);

        // 检查日志记录
        $this->assertEquals(100, $log->before);
        $this->assertEquals(70, $log->after);

        // 检查用户积分更新
        $this->user->refresh();
        $this->assertEquals(70, $this->user->integral);
    }

    public function test_deduction_with_positive_value()
    {
        $log = new UserIntegralLog([
            'user_id'   => $this->user->id,
            'integral'  => 30,
            'memo'      => '积分抵扣正值测试',
            'operation' => 'deduction',
        ]);

        $this->expectExceptionMessage(__('user::messages.The amount of the integral deduction cannot be greater than 0'));

        $this->observer->creating($log);
    }

    public function test_deduction_with_insufficient_integral()
    {
        $log = new UserIntegralLog([
            'user_id'   => $this->user->id,
            'integral'  => -150,
            'memo'      => '积分不足抵扣测试',
            'operation' => 'deduction',
        ]);

        $this->expectExceptionMessage(__('user::messages.Insufficient integral when deducting'));

        $this->observer->creating($log);
    }

    public function test_freeze_operation()
    {
        $log = new UserIntegralLog([
            'user_id'   => $this->user->id,
            'integral'  => -30,
            'memo'      => '积分冻结测试',
            'operation' => 'freeze',
        ]);

        $this->observer->creating($log);

        // 检查日志记录
        $this->assertEquals(100, $log->before);
        $this->assertEquals(70, $log->after);

        // 检查用户积分和冻结积分更新
        $this->user->refresh();
        $this->assertEquals(70, $this->user->integral);
        $this->assertEquals(30, $this->user->integral_freeze);
    }

    public function test_freeze_with_positive_value()
    {
        $log = new UserIntegralLog([
            'user_id'   => $this->user->id,
            'integral'  => 30,
            'memo'      => '积分冻结正值测试',
            'operation' => 'freeze',
        ]);

        $this->expectExceptionMessage(__('user::messages.The amount of the freeze change cannot be greater than 0'));

        $this->observer->creating($log);
    }

    public function test_freeze_with_insufficient_integral()
    {
        $log = new UserIntegralLog([
            'user_id'   => $this->user->id,
            'integral'  => -150,
            'memo'      => '积分不足冻结测试',
            'operation' => 'freeze',
        ]);

        $this->expectExceptionMessage(__('user::messages.Insufficient integral when freezing'));

        $this->observer->creating($log);
    }

    public function test_unfreeze_operation()
    {
        // 先冻结一些积分
        $this->user->integral        = 70;
        $this->user->integral_freeze = 30;
        $this->user->save();

        $log = new UserIntegralLog([
            'user_id'   => $this->user->id,
            'integral'  => 20,
            'memo'      => '积分解冻测试',
            'operation' => 'unfreeze',
        ]);

        $this->observer->creating($log);

        // 检查日志记录
        $this->assertEquals(70, $log->before);
        $this->assertEquals(90, $log->after);

        // 检查用户积分和冻结积分更新
        $this->user->refresh();
        $this->assertEquals(90, $this->user->integral);
        $this->assertEquals(10, $this->user->integral_freeze);
    }

    public function test_unfreeze_with_negative_value()
    {
        $log = new UserIntegralLog([
            'user_id'   => $this->user->id,
            'integral'  => -20,
            'memo'      => '积分解冻负值测试',
            'operation' => 'unfreeze',
        ]);

        $this->expectExceptionMessage(__('user::messages.The amount of the unfreeze change cannot be less than 0'));

        $this->observer->creating($log);
    }

    public function test_unfreeze_with_insufficient_frozen_integral()
    {
        $this->user->integral_freeze = 10;
        $this->user->save();

        $log = new UserIntegralLog([
            'user_id'   => $this->user->id,
            'integral'  => 20,
            'memo'      => '冻结积分不足解冻测试',
            'operation' => 'unfreeze',
        ]);

        $this->expectExceptionMessage(__('user::messages.The frozen integral is insufficient'));

        $this->observer->creating($log);
    }

    public function test_invalid_operation()
    {
        $log = new UserIntegralLog([
            'user_id'   => $this->user->id,
            'integral'  => 50,
            'memo'      => '无效操作测试',
            'operation' => 'invalid_operation',
        ]);

        // 不应该执行任何操作
        $this->observer->creating($log);

        // 用户积分应该保持不变
        $this->user->refresh();
        $this->assertEquals(100, $this->user->integral);
    }
}
