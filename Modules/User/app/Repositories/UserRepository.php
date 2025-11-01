<?php

namespace Modules\User\Repositories;

use Modules\Admin\Repositories\AbstractRepository;
use Modules\User\Models\User;

class UserRepository extends AbstractRepository
{
    public function __construct()
    {
        $this->model = app(User::class);
    }

    /**
     * 充值余额
     */
    public function rechargeBalance($user_id, $balance, $memo)
    {
        // TODO: Implement rechargeBalance() method.
    }

    /**
     * 扣除余额
     */
    public function deductionBalance($user_id, $balance, $memo)
    {
        // TODO: Implement deductionBalance() method.
    }

    /**
     * 冻结余额
     */
    public function freezeBalance($user_id, $balance, $memo)
    {
        // TODO: Implement freezeBalance() method.
    }

    /**
     * 解冻余额
     */
    public function unFreezeBalance($user_id, $balance, $memo)
    {
        // TODO: Implement unFreezeBalance() method.
    }
}
