<?php

namespace Modules\User\Repositories;

use Exception;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Repositories\AbstractRepository;
use Modules\User\Models\User;
use Modules\User\Models\UserBalanceLog;
use Modules\User\Models\UserCommissionLog;
use Modules\User\Models\UserIntegralLog;
use Throwable;

class UserRepository extends AbstractRepository
{
    public function __construct()
    {
        $this->model = app(User::class);
    }

    /**
     * 充值余额
     *
     * @return mixed|UserBalanceLog
     *
     * @throws Throwable
     */
    public function rechargeBalance($user_id, $balance, $memo)
    {
        // 确保金额为正数
        if ($balance < 0) {
            throw new Exception(trans('user::messages.Recharge amount cannot be negative'));
        }

        return DB::transaction(function () use ($user_id, $balance, $memo) {
            $log = new UserBalanceLog([
                'user_id'   => $user_id,
                'balance'   => $balance, // 正数表示增加
                'memo'      => $memo,
                'operation' => 'recharge',
            ]);

            $log->save();

            return $log;
        });
    }

    /**
     * 提现
     *
     * @return mixed|UserBalanceLog
     *
     * @throws Throwable
     */
    public function withdrawBalance($user_id, $balance, $memo)
    {
        // 确保金额为正数
        if ($balance < 0) {
            throw new Exception(trans('user::messages.Withdrawal amount cannot be negative'));
        }

        return DB::transaction(function () use ($user_id, $balance, $memo) {
            $log = new UserBalanceLog([
                'user_id'   => $user_id,
                'balance'   => -$balance, // 负数表示减少
                'memo'      => $memo,
                'operation' => 'withdraw',
            ]);

            $log->save();

            return $log;
        });
    }

    /**
     * 消费
     *
     * @return mixed|UserBalanceLog
     *
     * @throws Throwable
     */
    public function consumptionBalance($user_id, $balance, $memo)
    {
        // 确保金额为正数
        if ($balance < 0) {
            throw new Exception(trans('user::messages.Consumption amount cannot be negative'));
        }

        return DB::transaction(function () use ($user_id, $balance, $memo) {
            $log = new UserBalanceLog([
                'user_id'   => $user_id,
                'balance'   => -$balance, // 负数表示减少
                'memo'      => $memo,
                'operation' => 'consumption',
            ]);

            $log->save();

            return $log;
        });
    }

    /**
     * 退款
     *
     * @return mixed|UserBalanceLog
     *
     * @throws Throwable
     */
    public function refundBalance($user_id, $balance, $memo)
    {
        // 确保金额为正数
        if ($balance < 0) {
            throw new Exception(trans('user::messages.Refund amount cannot be negative'));
        }

        return DB::transaction(function () use ($user_id, $balance, $memo) {
            $log = new UserBalanceLog([
                'user_id'   => $user_id,
                'balance'   => $balance, // 正数表示增加
                'memo'      => $memo,
                'operation' => 'refund',
            ]);

            $log->save();

            return $log;
        });
    }

    /**
     * 冻结余额
     *
     * @return mixed|UserBalanceLog
     *
     * @throws Throwable
     */
    public function freezeBalance($user_id, $balance, $memo)
    {
        // 确保金额为正数
        if ($balance < 0) {
            throw new Exception(trans('user::messages.Freeze amount cannot be negative'));
        }

        return DB::transaction(function () use ($user_id, $balance, $memo) {
            $log = new UserBalanceLog([
                'user_id'   => $user_id,
                'balance'   => -$balance, // 负数表示从可用余额中减少
                'memo'      => $memo,
                'operation' => 'freeze',
            ]);

            $log->save();

            return $log;
        });
    }

    /**
     * 解冻余额
     *
     * @return mixed|UserBalanceLog
     *
     * @throws Throwable
     */
    public function unFreezeBalance($user_id, $balance, $memo)
    {
        // 确保金额为正数
        if ($balance < 0) {
            throw new Exception(trans('user::messages.Unfreeze amount cannot be negative'));
        }

        return DB::transaction(function () use ($user_id, $balance, $memo) {
            $log = new UserBalanceLog([
                'user_id'   => $user_id,
                'balance'   => $balance, // 正数表示增加到可用余额
                'memo'      => $memo,
                'operation' => 'unfreeze',
            ]);

            $log->save();

            return $log;
        });
    }

    /**
     * 消费返佣（发放佣金）
     *
     * @return mixed|UserCommissionLog
     *
     * @throws Throwable
     */
    public function consumptionReturnsCommission($user_id, $commission, $memo)
    {
        // 确保金额为正数
        if ($commission < 0) {
            throw new Exception(trans('user::messages.Commission amount cannot be negative'));
        }

        return DB::transaction(function () use ($user_id, $commission, $memo) {
            $log = new UserCommissionLog([
                'user_id'    => $user_id,
                'commission' => $commission, // 正数表示增加
                'memo'       => $memo,
                'operation'  => 'consumption_returns_commission',
            ]);

            $log->save();

            return $log;
        });
    }

    /**
     * 提现佣金
     *
     * @return mixed|UserCommissionLog
     *
     * @throws Throwable
     */
    public function withdrawCommission($user_id, $commission, $memo)
    {
        // 确保金额为正数
        if ($commission < 0) {
            throw new Exception(trans('user::messages.Withdraw commission amount cannot be negative'));
        }

        return DB::transaction(function () use ($user_id, $commission, $memo) {
            $log = new UserCommissionLog([
                'user_id'    => $user_id,
                'commission' => -$commission, // 负数表示减少
                'memo'       => $memo,
                'operation'  => 'withdraw',
            ]);

            $log->save();

            return $log;
        });
    }

    /**
     * 冻结佣金
     *
     * @return mixed|UserCommissionLog
     *
     * @throws Throwable
     */
    public function freezeCommission($user_id, $commission, $memo)
    {
        // 确保金额为正数
        if ($commission < 0) {
            throw new Exception(trans('user::messages.Freeze commission amount cannot be negative'));
        }

        return DB::transaction(function () use ($user_id, $commission, $memo) {
            $log = new UserCommissionLog([
                'user_id'    => $user_id,
                'commission' => -$commission, // 负数表示从可用佣金中减少
                'memo'       => $memo,
                'operation'  => 'freeze',
            ]);

            $log->save();

            return $log;
        });
    }

    /**
     * 解冻佣金
     *
     * @return mixed|UserCommissionLog
     *
     * @throws Throwable
     */
    public function unFreezeCommission($user_id, $commission, $memo)
    {
        // 确保金额为正数
        if ($commission < 0) {
            throw new Exception(trans('user::messages.Unfreeze commission amount cannot be negative'));
        }

        return DB::transaction(function () use ($user_id, $commission, $memo) {
            $log = new UserCommissionLog([
                'user_id'    => $user_id,
                'commission' => $commission, // 正数表示增加到可用佣金
                'memo'       => $memo,
                'operation'  => 'unfreeze',
            ]);

            $log->save();

            return $log;
        });
    }

    /**
     * 消费返积分（增加积分）
     *
     * @return mixed|UserIntegralLog
     *
     * @throws Throwable
     */
    public function consumptionReturnsIntegral($user_id, $integral, $memo)
    {
        // 确保积分为正数
        if ($integral < 0) {
            throw new Exception(trans('user::messages.Integral amount cannot be negative'));
        }

        return DB::transaction(function () use ($user_id, $integral, $memo) {
            $log = new UserIntegralLog([
                'user_id'   => $user_id,
                'integral'  => $integral, // 正数表示增加
                'memo'      => $memo,
                'operation' => 'consumption_returns_integral',
            ]);

            $log->save();

            return $log;
        });
    }

    /**
     * 抵扣积分
     *
     * @return mixed|UserIntegralLog
     *
     * @throws Throwable
     */
    public function deductionIntegral($user_id, $integral, $memo)
    {
        // 确保积分为正数
        if ($integral < 0) {
            throw new Exception(trans('user::messages.Deduction integral amount cannot be negative'));
        }

        return DB::transaction(function () use ($user_id, $integral, $memo) {
            $log = new UserIntegralLog([
                'user_id'   => $user_id,
                'integral'  => -$integral, // 负数表示减少
                'memo'      => $memo,
                'operation' => 'deduction',
            ]);

            $log->save();

            return $log;
        });
    }

    /**
     * 冻结积分
     *
     * @return mixed|UserIntegralLog
     *
     * @throws Throwable
     */
    public function freezeIntegral($user_id, $integral, $memo)
    {
        // 确保积分为正数
        if ($integral < 0) {
            throw new Exception(trans('user::messages.Freeze integral amount cannot be negative'));
        }

        return DB::transaction(function () use ($user_id, $integral, $memo) {
            $log = new UserIntegralLog([
                'user_id'   => $user_id,
                'integral'  => -$integral, // 负数表示从可用积分中减少
                'memo'      => $memo,
                'operation' => 'freeze',
            ]);

            $log->save();

            return $log;
        });
    }

    /**
     * 解冻积分
     *
     * @return mixed|UserIntegralLog
     *
     * @throws Throwable
     */
    public function unFreezeIntegral($user_id, $integral, $memo)
    {
        // 确保积分为正数
        if ($integral < 0) {
            throw new Exception(trans('user::messages.Unfreeze integral amount cannot be negative'));
        }

        return DB::transaction(function () use ($user_id, $integral, $memo) {
            $log = new UserIntegralLog([
                'user_id'   => $user_id,
                'integral'  => $integral, // 正数表示增加到可用积分
                'memo'      => $memo,
                'operation' => 'unfreeze',
            ]);

            $log->save();

            return $log;
        });
    }
}
