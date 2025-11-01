<?php

namespace Modules\User\Observers;

use Exception;
use Modules\User\Models\User;
use Modules\User\Models\UserIntegralLog;
use Throwable;

class UserIntegralObserver
{
    public function creating(UserIntegralLog $userIntegralLog): void
    {
        if (method_exists($this, $userIntegralLog->operation)) {
            $this->{$userIntegralLog->operation}($userIntegralLog);
        }
    }

    /**
     * 消费返积分处理
     *
     * @param  UserIntegralLog $userIntegralLog 积分日志模型实例
     * @return void
     *
     * @throws Throwable
     */
    protected function consumption_returns_integral(UserIntegralLog $userIntegralLog)
    {
        throw_if($userIntegralLog->integral < 0, new Exception(__('user::messages.The amount of the integral change cannot be less than 0')));

        $this->updateUserIntegral($userIntegralLog, function ($integral, $change) {
            return bcadd($integral, $change, 0);
        });
    }

    /**
     * 抵扣
     *
     * @param  UserIntegralLog $userIntegralLog
     * @return void
     *
     * @throws Throwable
     */
    protected function deduction(UserIntegralLog $userIntegralLog)
    {
        $this->updateUserIntegral($userIntegralLog, function ($integral, $change) {
            return bcadd($integral, $change, 0);
        }, function ($user, $change) {
            throw_if($change > 0, new Exception(__('user::messages.The amount of the integral deduction cannot be greater than 0')));
            throw_if(bcadd($user->integral, $change, 0) < 0, new Exception(__('user::messages.Insufficient integral when deducting')));
        });
    }

    /**
     * 冻结
     *
     * @param  UserIntegralLog $userIntegralLog
     * @return void
     *
     * @throws Throwable
     */
    protected function freeze(UserIntegralLog $userIntegralLog)
    {
        $this->updateUserIntegral($userIntegralLog, function ($integral, $change) {
            return bcadd($integral, $change, 0);
        }, function ($user, $change) {
            throw_if($change > 0, new Exception(__('user::messages.The amount of the freeze change cannot be greater than 0')));
            throw_if(bcadd($user->integral, $change, 0) < 0, new Exception(__('user::messages.Insufficient integral when freezing')));
        }, function ($user, $change) {
            $user->integral_freeze = bcsub($user->integral_freeze, $change, 0);
        });
    }

    /**
     * 解冻
     *
     * @param  UserIntegralLog $userIntegralLog
     * @return void
     *
     * @throws Throwable
     */
    protected function unfreeze(UserIntegralLog $userIntegralLog)
    {
        $this->updateUserIntegral($userIntegralLog, function ($integral, $change) {
            return bcadd($integral, $change, 0);
        }, function ($user, $change) {
            throw_if($change < 0, new Exception(__('user::messages.The amount of the unfreeze change cannot be less than 0')));
        }, function ($user, $change) {
            $user->integral_freeze = bcsub($user->integral_freeze, $change, 0);
            throw_if($user->integral_freeze < 0, new Exception(__('user::messages.The frozen integral is insufficient')));
        });
    }

    /**
     * 更新用户积分的通用方法
     *
     * @param  UserIntegralLog $userIntegralLog   积分日志
     * @param  callable        $calculateIntegral 积分计算函数
     * @param  callable|null   $validate          验证函数（可选）
     * @param  callable|null   $afterUpdate       后续更新操作（可选）
     * @return void
     *
     * @throws Throwable
     */
    private function updateUserIntegral(UserIntegralLog $userIntegralLog, callable $calculateIntegral, ?callable $validate = null, ?callable $afterUpdate = null)
    {
        $user         = User::find($userIntegralLog->user_id);
        $userIntegral = $user->integral;

        $userIntegralLog->before = $userIntegral;

        // 执行验证
        if ($validate) {
            $validate($user, $userIntegralLog->integral);
        }

        // 计算新积分
        $newIntegral            = $calculateIntegral($userIntegral, $userIntegralLog->integral);
        $userIntegralLog->after = $newIntegral;

        // 更新用户积分
        $user->integral = $newIntegral;

        // 执行后续更新操作
        if ($afterUpdate) {
            $afterUpdate($user, $userIntegralLog->integral);
        }

        $user->save();
    }
}