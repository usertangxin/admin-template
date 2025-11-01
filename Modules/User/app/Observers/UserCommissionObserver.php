<?php

namespace Modules\User\Observers;

use Exception;
use Modules\User\Models\User;
use Modules\User\Models\UserCommissionLog;
use Throwable;

class UserCommissionObserver
{
    public function creating(UserCommissionLog $userCommissionLog): void
    {
        if (method_exists($this, $userCommissionLog->operation)) {
            $this->{$userCommissionLog->operation}($userCommissionLog);
        }
    }

    /**
     * 提现
     *
     * @return void
     *
     * @throws Throwable
     */
    protected function withdraw(UserCommissionLog $userCommissionLog)
    {
        $this->updateUserCommission($userCommissionLog, function ($commission, $change) {
            return bcadd($commission, $change, 2);
        }, function ($user, $change) {
            throw_if($change > 0, new Exception(__('user::messages.The amount for withdrawal modification cannot be greater than 0')));
            throw_if(bcadd($user->commission, $change, 2) < 0, new Exception(__('user::messages.Insufficient commission when withdrawing funds')));
        });
    }

    /**
     * 消费返佣
     *
     * @return void
     *
     * @throws Throwable
     */
    protected function consumption_returns_commission(UserCommissionLog $userCommissionLog)
    {
        throw_if($userCommissionLog->commission < 0, new Exception(__('user::messages.The amount of the commission change cannot be less than 0')));

        $this->updateUserCommission($userCommissionLog, function ($commission, $change) {
            return bcadd($commission, $change, 2);
        });
    }

    /**
     * 冻结
     *
     * @return void
     *
     * @throws Throwable
     */
    protected function freeze(UserCommissionLog $userCommissionLog)
    {
        $this->updateUserCommission($userCommissionLog, function ($commission, $change) {
            return bcadd($commission, $change, 2);
        }, function ($user, $change) {
            throw_if($change > 0, new Exception(__('user::messages.The amount of the freeze change cannot be greater than 0')));
            throw_if(bcadd($user->commission, $change, 2) < 0, new Exception(__('user::messages.Insufficient commission when freezing funds')));
        }, function ($user, $change) {
            $user->commission_freeze = bcsub($user->commission_freeze, $change, 2);
        });
    }

    /**
     * 解冻
     *
     * @return void
     *
     * @throws Throwable
     */
    protected function unfreeze(UserCommissionLog $userCommissionLog)
    {
        $this->updateUserCommission($userCommissionLog, function ($commission, $change) {
            return bcadd($commission, $change, 2);
        }, function ($user, $change) {
            throw_if($change < 0, new Exception(__('user::messages.The amount of the unfreeze change cannot be less than 0')));
        }, function ($user, $change) {
            $user->commission_freeze = bcsub($user->commission_freeze, $change, 2);
            throw_if($user->commission_freeze < 0, new Exception(__('user::messages.The frozen commission is insufficient')));
        });
    }

    /**
     * 更新用户佣金的通用方法
     *
     * @param  UserCommissionLog $userCommissionLog   佣金日志
     * @param  callable          $calculateCommission 佣金计算函数
     * @param  callable|null     $validate            验证函数（可选）
     * @param  callable|null     $afterUpdate         后续更新操作（可选）
     * @return void
     *
     * @throws Throwable
     */
    private function updateUserCommission(UserCommissionLog $userCommissionLog, callable $calculateCommission, ?callable $validate = null, ?callable $afterUpdate = null)
    {
        $user           = User::find($userCommissionLog->user_id);
        $userCommission = $user->commission;

        $userCommissionLog->before = $userCommission;

        // 执行验证
        if ($validate) {
            $validate($user, $userCommissionLog->commission);
        }

        // 计算新佣金
        $newCommission            = $calculateCommission($userCommission, $userCommissionLog->commission);
        $userCommissionLog->after = $newCommission;

        // 更新用户佣金
        $user->commission = $newCommission;

        // 执行后续更新操作
        if ($afterUpdate) {
            $afterUpdate($user, $userCommissionLog->commission);
        }

        $user->save();
    }
}
