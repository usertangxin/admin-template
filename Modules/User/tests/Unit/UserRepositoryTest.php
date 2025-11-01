<?php

namespace Modules\User\Tests\Unit;

use Exception;
use Modules\Admin\Tests\AbstractAuthTestCase;
use Modules\User\Models\User;
use Modules\User\Repositories\UserRepository;

class UserRepositoryTest extends AbstractAuthTestCase
{
    protected User $user;

    protected UserRepository $userRepository;

    protected function setUp(): void
    {
        parent::setUp();

        // 创建测试用户
        $this->user = User::factory()->create([
            'balance'           => 100.00,
            'commission'        => 50.00,
            'integral'          => 200,
            'balance_freeze'    => 10.00,
            'commission_freeze' => 5.00,
            'integral_freeze'   => 20,
        ]);

        // 创建UserRepository实例
        $this->userRepository = new UserRepository;
    }

    // 测试充值余额
    public function test_recharge_balance_success()
    {
        $log = $this->userRepository->rechargeBalance($this->user->id, 50.00, '充值测试');

        $this->assertEquals($this->user->id, $log->user_id);
        $this->assertEquals(50.00, $log->balance);
        $this->assertEquals('recharge', $log->operation);
        $this->assertEquals('充值测试', $log->memo);
    }

    // 测试充值余额负数异常
    public function test_recharge_balance_with_negative_amount()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(__('user::messages.Recharge amount cannot be negative'));

        $this->userRepository->rechargeBalance($this->user->id, -50.00, '充值测试');
    }

    // 测试提现余额
    public function test_withdraw_balance_success()
    {
        $log = $this->userRepository->withdrawBalance($this->user->id, 30.00, '提现测试');

        $this->assertEquals($this->user->id, $log->user_id);
        $this->assertEquals(-30.00, $log->balance);
        $this->assertEquals('withdraw', $log->operation);
        $this->assertEquals('提现测试', $log->memo);
    }

    // 测试提现余额负数异常
    public function test_withdraw_balance_with_negative_amount()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(__('user::messages.Withdrawal amount cannot be negative'));

        $this->userRepository->withdrawBalance($this->user->id, -30.00, '提现测试');
    }

    // 测试消费余额
    public function test_consumption_balance_success()
    {
        $log = $this->userRepository->consumptionBalance($this->user->id, 20.00, '消费测试');

        $this->assertEquals($this->user->id, $log->user_id);
        $this->assertEquals(-20.00, $log->balance);
        $this->assertEquals('consumption', $log->operation);
        $this->assertEquals('消费测试', $log->memo);
    }

    // 测试消费余额负数异常
    public function test_consumption_balance_with_negative_amount()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(__('user::messages.Consumption amount cannot be negative'));

        $this->userRepository->consumptionBalance($this->user->id, -20.00, '消费测试');
    }

    // 测试退款余额
    public function test_refund_balance_success()
    {
        $log = $this->userRepository->refundBalance($this->user->id, 25.00, '退款测试');

        $this->assertEquals($this->user->id, $log->user_id);
        $this->assertEquals(25.00, $log->balance);
        $this->assertEquals('refund', $log->operation);
        $this->assertEquals('退款测试', $log->memo);
    }

    // 测试退款余额负数异常
    public function test_refund_balance_with_negative_amount()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(__('user::messages.Refund amount cannot be negative'));

        $this->userRepository->refundBalance($this->user->id, -25.00, '退款测试');
    }

    // 测试冻结余额
    public function test_freeze_balance_success()
    {
        $log = $this->userRepository->freezeBalance($this->user->id, 30.00, '冻结测试');

        $this->assertEquals($this->user->id, $log->user_id);
        $this->assertEquals(-30.00, $log->balance);
        $this->assertEquals('freeze', $log->operation);
        $this->assertEquals('冻结测试', $log->memo);
    }

    // 测试冻结余额负数异常
    public function test_freeze_balance_with_negative_amount()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(__('user::messages.Freeze amount cannot be negative'));

        $this->userRepository->freezeBalance($this->user->id, -30.00, '冻结测试');
    }

    // 测试解冻余额
    public function test_unfreeze_balance_success()
    {
        $log = $this->userRepository->unFreezeBalance($this->user->id, 10.00, '解冻测试');

        $this->user->refresh();
        $this->assertEquals($this->user->id, $log->user_id);
        $this->assertEquals(110.00, $this->user->balance);
        $this->assertEquals(10, $log->balance);
        $this->assertEquals('unfreeze', $log->operation);
        $this->assertEquals('解冻测试', $log->memo);
    }

    // 测试解冻余额负数异常
    public function test_unfreeze_balance_with_negative_amount()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(__('user::messages.Unfreeze amount cannot be negative'));

        $this->userRepository->unFreezeBalance($this->user->id, -20.00, '解冻测试');
    }

    // 测试消费返佣（发放佣金）
    public function test_consumption_returns_commission_success()
    {
        $log = $this->userRepository->consumptionReturnsCommission($this->user->id, 15.00, '返佣测试');

        $this->assertEquals($this->user->id, $log->user_id);
        $this->assertEquals(15.00, $log->commission);
        $this->assertEquals('consumption_returns_commission', $log->operation);
        $this->assertEquals('返佣测试', $log->memo);
    }

    // 测试消费返佣负数异常
    public function test_consumption_returns_commission_with_negative_amount()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(__('user::messages.Commission amount cannot be negative'));

        $this->userRepository->consumptionReturnsCommission($this->user->id, -15.00, '返佣测试');
    }

    // 测试提现佣金
    public function test_withdraw_commission_success()
    {
        $log = $this->userRepository->withdrawCommission($this->user->id, 10.00, '提现佣金测试');

        $this->assertEquals($this->user->id, $log->user_id);
        $this->assertEquals(-10.00, $log->commission);
        $this->assertEquals('withdraw', $log->operation);
        $this->assertEquals('提现佣金测试', $log->memo);
    }

    // 测试提现佣金负数异常
    public function test_withdraw_commission_with_negative_amount()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(__('user::messages.Withdraw commission amount cannot be negative'));

        $this->userRepository->withdrawCommission($this->user->id, -10.00, '提现佣金测试');
    }

    // 测试冻结佣金
    public function test_freeze_commission_success()
    {
        $log = $this->userRepository->freezeCommission($this->user->id, 5.00, '冻结佣金测试');

        $this->assertEquals($this->user->id, $log->user_id);
        $this->assertEquals(-5.00, $log->commission);
        $this->assertEquals('freeze', $log->operation);
        $this->assertEquals('冻结佣金测试', $log->memo);
    }

    // 测试冻结佣金负数异常
    public function test_freeze_commission_with_negative_amount()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(__('user::messages.Freeze commission amount cannot be negative'));

        $this->userRepository->freezeCommission($this->user->id, -5.00, '冻结佣金测试');
    }

    // 测试解冻佣金
    public function test_unfreeze_commission_success()
    {
        $log = $this->userRepository->unFreezeCommission($this->user->id, 3.00, '解冻佣金测试');

        $this->user->refresh();
        $this->assertEquals($this->user->id, $log->user_id);
        $this->assertEquals(53.00, $this->user->commission);
        $this->assertEquals(3.00, $log->commission);
        $this->assertEquals('unfreeze', $log->operation);
        $this->assertEquals('解冻佣金测试', $log->memo);
    }

    // 测试解冻佣金负数异常
    public function test_unfreeze_commission_with_negative_amount()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(__('user::messages.Unfreeze commission amount cannot be negative'));

        $this->userRepository->unFreezeCommission($this->user->id, -8.00, '解冻佣金测试');
    }

    // 测试消费返积分（增加积分）
    public function test_consumption_returns_integral_success()
    {
        $log = $this->userRepository->consumptionReturnsIntegral($this->user->id, 30, '返积分测试');

        $this->assertEquals($this->user->id, $log->user_id);
        $this->assertEquals(30, $log->integral);
        $this->assertEquals('consumption_returns_integral', $log->operation);
        $this->assertEquals('返积分测试', $log->memo);
    }

    // 测试消费返积分负数异常
    public function test_consumption_returns_integral_with_negative_amount()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(__('user::messages.Integral amount cannot be negative'));

        $this->userRepository->consumptionReturnsIntegral($this->user->id, -30, '返积分测试');
    }

    // 测试抵扣积分
    public function test_deduction_integral_success()
    {
        $log = $this->userRepository->deductionIntegral($this->user->id, 20, '抵扣积分测试');

        $this->assertEquals($this->user->id, $log->user_id);
        $this->assertEquals(-20, $log->integral);
        $this->assertEquals('deduction', $log->operation);
        $this->assertEquals('抵扣积分测试', $log->memo);
    }

    // 测试抵扣积分负数异常
    public function test_deduction_integral_with_negative_amount()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(__('user::messages.Deduction integral amount cannot be negative'));

        $this->userRepository->deductionIntegral($this->user->id, -20, '抵扣积分测试');
    }

    // 测试冻结积分
    public function test_freeze_integral_success()
    {
        $log = $this->userRepository->freezeIntegral($this->user->id, 10, '冻结积分测试');

        $this->assertEquals($this->user->id, $log->user_id);
        $this->assertEquals(-10, $log->integral);
        $this->assertEquals('freeze', $log->operation);
        $this->assertEquals('冻结积分测试', $log->memo);
    }

    // 测试冻结积分负数异常
    public function test_freeze_integral_with_negative_amount()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(__('user::messages.Freeze integral amount cannot be negative'));

        $this->userRepository->freezeIntegral($this->user->id, -10, '冻结积分测试');
    }

    // 测试解冻积分
    public function test_unfreeze_integral_success()
    {
        $log = $this->userRepository->unFreezeIntegral($this->user->id, 15, '解冻积分测试');

        $this->assertEquals($this->user->id, $log->user_id);
        $this->assertEquals(15, $log->integral);
        $this->assertEquals('unfreeze', $log->operation);
        $this->assertEquals('解冻积分测试', $log->memo);
    }

    // 测试解冻积分负数异常
    public function test_unfreeze_integral_with_negative_amount()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(__('user::messages.Unfreeze integral amount cannot be negative'));

        $this->userRepository->unFreezeIntegral($this->user->id, -15, '解冻积分测试');
    }
}
