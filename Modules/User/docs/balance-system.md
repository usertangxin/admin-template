---
title: 余额系统
---

# 余额系统

用户余额系统提供了完整的余额管理功能，包括充值、提现、消费、退款、冻结和解冻等操作。

## 功能说明

### 余额字段

用户表包含以下余额相关字段：
- `balance` - 用户可用余额（decimal(15), unsigned）
- `balance_freeze` - 用户冻结余额（decimal(15), unsigned）

### 操作类型

系统支持以下余额操作类型（字典：`user_balance_operation`）：

| 操作类型 | 值 | 说明 |
|---------|-----|------|
| 充值 | `recharge` | 用户余额增加 |
| 提现 | `withdraw` | 用户余额减少 |
| 消费 | `consumption` | 用户消费扣款 |
| 退款 | `refund` | 退款到用户余额 |
| 冻结 | `freeze` | 冻结用户余额 |
| 解冻 | `unfreeze` | 解冻用户余额 |

## 使用方法

### 方式一：使用 UserRepository 辅助方法（推荐）

`UserRepository` 提供了便捷的辅助方法，所有方法都在事务中执行，并自动处理金额的正负数转换：

```php
use Modules\User\Repositories\UserRepository;

$repository = app(UserRepository::class);

// 充值余额 - 传入正数金额
$log = $repository->rechargeBalance($userId, 100.00, '用户充值');

// 提现 - 传入正数金额，方法内部会自动转为负数
$log = $repository->withdrawBalance($userId, 50.00, '用户提现');

// 消费 - 传入正数金额，方法内部会自动转为负数
$log = $repository->consumptionBalance($userId, 80.00, '购买商品');

// 退款 - 传入正数金额
$log = $repository->refundBalance($userId, 30.00, '订单退款');

// 冻结余额 - 传入正数金额，方法内部会自动转为负数
$log = $repository->freezeBalance($userId, 20.00, '冻结余额');

// 解冻余额 - 传入正数金额
$log = $repository->unFreezeBalance($userId, 20.00, '解冻余额');
```

::: tip
推荐使用 `UserRepository` 的辅助方法，因为它们：
- 在事务中执行，确保数据一致性
- 自动验证金额不能为负数
- 自动处理金额的正负数转换
- 返回创建后的日志记录
:::

### 方式二：直接创建余额日志

余额系统使用观察者模式自动处理余额变更。只需创建 `UserBalanceLog` 记录，系统会自动：

1. 验证操作合法性
2. 更新用户余额
3. 记录变更前后余额

```php
use Modules\User\Models\UserBalanceLog;

// 充值示例
UserBalanceLog::create([
    'user_id' => $userId,
    'balance' => 100.00,  // 正数表示增加
    'operation' => 'recharge',
    'memo' => '用户充值',
]);

// 消费示例
UserBalanceLog::create([
    'user_id' => $userId,
    'balance' => -50.00,  // 负数表示减少
    'operation' => 'consumption',
    'memo' => '购买商品',
]);
```

## UserRepository 方法说明

### rechargeBalance($user_id, $balance, $memo)
充值余额
- **参数：**
  - `$user_id` - 用户ID
  - `$balance` - 充值金额（必须为正数）
  - `$memo` - 备注说明
- **返回：** `UserBalanceLog` 实例
- **异常：** 如果金额为负数，抛出异常

### withdrawBalance($user_id, $balance, $memo)
提现余额
- **参数：**
  - `$user_id` - 用户ID
  - `$balance` - 提现金额（必须为正数）
  - `$memo` - 备注说明
- **返回：** `UserBalanceLog` 实例
- **异常：** 如果金额为负数或余额不足，抛出异常

### consumptionBalance($user_id, $balance, $memo)
消费余额
- **参数：**
  - `$user_id` - 用户ID
  - `$balance` - 消费金额（必须为正数）
  - `$memo` - 备注说明
- **返回：** `UserBalanceLog` 实例
- **异常：** 如果金额为负数或余额不足，抛出异常

### refundBalance($user_id, $balance, $memo)
退款到余额
- **参数：**
  - `$user_id` - 用户ID
  - `$balance` - 退款金额（必须为正数）
  - `$memo` - 备注说明
- **返回：** `UserBalanceLog` 实例
- **异常：** 如果金额为负数，抛出异常

### freezeBalance($user_id, $balance, $memo)
冻结余额
- **参数：**
  - `$user_id` - 用户ID
  - `$balance` - 冻结金额（必须为正数）
  - `$memo` - 备注说明
- **返回：** `UserBalanceLog` 实例
- **异常：** 如果金额为负数或余额不足，抛出异常

### unFreezeBalance($user_id, $balance, $memo)
解冻余额
- **参数：**
  - `$user_id` - 用户ID
  - `$balance` - 解冻金额（必须为正数）
  - `$memo` - 备注说明
- **返回：** `UserBalanceLog` 实例
- **异常：** 如果金额为负数或冻结余额不足，抛出异常

## 操作验证规则

### 充值 (recharge)
- ✅ `balance` 必须 >= 0（正数）
- ✅ 自动增加用户余额

### 提现 (withdraw)
- ❌ `balance` 不能 > 0（必须是负数）
- ✅ 验证余额充足
- ✅ 自动减少用户余额

### 消费 (consumption)
- ❌ `balance` 不能 > 0（必须是负数）
- ✅ 验证余额充足
- ✅ 自动减少用户余额

### 退款 (refund)
- ✅ `balance` 必须 >= 0（正数）
- ✅ 自动增加用户余额

### 冻结 (freeze)
- ❌ `balance` 不能 > 0（必须是负数）
- ✅ 验证余额充足
- ✅ 减少可用余额，增加冻结余额

### 解冻 (unfreeze)
- ✅ `balance` 必须 >= 0（正数）
- ✅ 减少冻结余额，增加可用余额
- ✅ 验证冻结余额充足

## 余额日志字段

`UserBalanceLog` 模型包含以下字段：

- `user_id` - 用户ID
- `balance` - 变更金额（decimal(15)）
- `operation` - 操作类型
- `memo` - 备注说明
- `before` - 操作前余额（自动填充）
- `after` - 操作后余额（自动填充）

## 注意事项

::: warning
所有余额操作都是通过观察者自动处理的。不要直接修改 `User` 模型的 `balance` 和 `balance_freeze` 字段，而应该通过创建 `UserBalanceLog` 记录或使用 `UserRepository` 的辅助方法来实现。
:::

::: tip
余额计算使用 `bcadd` 和 `bcsub` 函数，确保精度准确（保留2位小数）。
:::

::: danger
提现、消费、冻结操作会自动验证余额是否充足，如果余额不足会抛出异常，请务必捕获处理。
:::

::: tip
使用 `UserRepository` 的辅助方法时，所有传入的金额都应该是正数，方法内部会根据操作类型自动处理正负数转换。
:::

::: danger
所有余额操作都应该在数据库事务中进行，以确保数据一致性。`UserRepository` 的辅助方法已经包含了事务处理，如果直接创建 `UserBalanceLog` 记录，请务必使用 `DB::transaction()` 包装操作。
:::
