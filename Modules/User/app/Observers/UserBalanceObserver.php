<?php

namespace Modules\User\Observers;

use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\InvalidCastException;
use InvalidArgumentException;
use Modules\User\Models\User;
use Modules\User\Models\UserBalanceLog;
use Throwable;

class UserBalanceObserver
{
    public function creating(UserBalanceLog $userBalanceLog): void
    {
        if (method_exists($this, $userBalanceLog->operation)) {
            $this->{$userBalanceLog->operation}($userBalanceLog);
        }
    }

    /**
     * 充值
     *
     * @return void
     *
     * @throws Throwable
     */
    protected function recharge(UserBalanceLog $userBalanceLog)
    {
        throw_if($userBalanceLog->balance < 0, new Exception(__('user::messages.The amount of the recharge change cannot be less than 0')));

        $this->updateUserBalance($userBalanceLog, function ($balance, $change) {
            return bcadd($balance, $change, 2);
        });
    }

    /**
     * 提现
     *
     * @return void
     *
     * @throws Throwable
     */
    protected function withdraw(UserBalanceLog $userBalanceLog)
    {
        $this->updateUserBalance($userBalanceLog, function ($balance, $change) {
            return bcadd($balance, $change, 2);
        }, function ($user, $change) {
            throw_if($change > 0, new Exception(__('user::messages.The amount for withdrawal modification cannot be greater than 0')));
            throw_if(bcadd($user->balance, $change, 2) < 0, new Exception(__('user::messages.Insufficient balance when withdrawing funds')));
        });
    }

    /**
     * 消费
     *
     * @return void
     *
     * @throws Throwable
     */
    protected function consumption(UserBalanceLog $userBalanceLog)
    {
        $this->updateUserBalance($userBalanceLog, function ($balance, $change) {
            return bcadd($balance, $change, 2);
        }, function ($user, $change) {
            throw_if($change > 0, new Exception(__('user::messages.The amount of the consumption change cannot be greater than 0')));
            throw_if(bcadd($user->balance, $change, 2) < 0, new Exception(__('user::messages.Insufficient balance when consuming funds')));
        });
    }

    /**
     * 退款
     *
     * @return void
     *
     * @throws BindingResolutionException
     * @throws InvalidArgumentException
     * @throws InvalidCastException|Throwable
     */
    protected function refund(UserBalanceLog $userBalanceLog)
    {
        throw_if($userBalanceLog->balance < 0, new Exception(__('user::messages.The amount of the refund change cannot be less than 0')));

        $this->updateUserBalance($userBalanceLog, function ($balance, $change) {
            return bcadd($balance, $change, 2);
        });
    }

    /**
     * 冻结
     *
     * @return void
     *
     * @throws Throwable
     */
    protected function freeze(UserBalanceLog $userBalanceLog)
    {
        $this->updateUserBalance($userBalanceLog, function ($balance, $change) {
            return bcadd($balance, $change, 2);
        }, function ($user, $change) {
            throw_if($change > 0, new Exception(__('user::messages.The amount of the freeze change cannot be greater than 0')));
            throw_if(bcadd($user->balance, $change, 2) < 0, new Exception(__('user::messages.Insufficient balance when freezing funds')));
        }, function ($user, $change) {
            $user->balance_freeze = bcsub($user->balance_freeze, $change, 2);
        });
    }

    /**
     * 解冻
     *
     * @return void
     *
     * @throws Throwable
     */
    protected function unfreeze(UserBalanceLog $userBalanceLog)
    {
        $this->updateUserBalance($userBalanceLog, function ($balance, $change) {
            return bcadd($balance, $change, 2);
        }, function ($user, $change) {
            throw_if($change < 0, new Exception(__('user::messages.The amount of the unfreeze change cannot be less than 0')));
        }, function ($user, $change) {
            $user->balance_freeze = bcsub($user->balance_freeze, $change, 2);
            throw_if($user->balance_freeze < 0, new Exception(__('user::messages.The frozen balance is insufficient')));
        });
    }

    /**
     * 更新用户余额的通用方法
     *
     * @param  UserBalanceLog $userBalanceLog   余额日志
     * @param  callable       $calculateBalance 余额计算函数
     * @param  callable|null  $validate         验证函数（可选）
     * @param  callable|null  $afterUpdate      后续更新操作（可选）
     * @return void
     *
     * @throws Throwable
     */
    private function updateUserBalance(UserBalanceLog $userBalanceLog, callable $calculateBalance, ?callable $validate = null, ?callable $afterUpdate = null)
    {
        $user        = User::find($userBalanceLog->user_id);
        $userBalance = $user->balance;

        $userBalanceLog->before = $userBalance;

        // 执行验证
        if ($validate) {
            $validate($user, $userBalanceLog->balance);
        }

        // 计算新余额
        $newBalance            = $calculateBalance($userBalance, $userBalanceLog->balance);
        $userBalanceLog->after = $newBalance;

        // 更新用户余额
        $user->balance = $newBalance;

        // 执行后续更新操作
        if ($afterUpdate) {
            $afterUpdate($user, $userBalanceLog->balance);
        }

        $user->save();
    }
}
