---
title: 佣金系统
---

# 佣金系统

用户佣金系统提供了完整的佣金管理功能，支持佣金提现、消费返佣、冻结和解冻等操作。

## 功能说明

### 佣金字段

用户表包含以下佣金相关字段：
- `commission` - 用户可用佣金（decimal(15), unsigned）
- `commission_freeze` - 用户冻结佣金（decimal(15), unsigned）

### 操作类型

系统支持以下佣金操作类型（字典：`user_commission_operation`）：

| 操作类型 | 值 | 说明 |
|---------|-----|------|
| 提现 | `withdraw` | 佣金提现 |
| 消费返佣 | `consumption_returns_commission` | 用户消费后返佣 |
| 冻结 | `freeze` | 冻结佣金 |
| 解冻 | `unfreeze` | 解冻佣金 |

## 使用方法

### 方式一：使用 UserRepository 辅助方法（推荐）

`UserRepository` 提供了便捷的辅助方法，所有方法都在事务中执行，并自动处理金额的正负数转换：

```php
use Modules\User\Repositories\UserRepository;

$repository = app(UserRepository::class);

// 消费返佣 - 传入正数金额
$log = $repository->consumptionReturnsCommission($userId, 10.50, '消费返佣');

// 提现佣金 - 传入正数金额，方法内部会自动转为负数
$log = $repository->withdrawCommission($userId, 100.00, '佣金提现');

// 冻结佣金 - 传入正数金额，方法内部会自动转为负数
$log = $repository->freezeCommission($userId, 50.00, '冻结佣金');

// 解冻佣金 - 传入正数金额
$log = $repository->unFreezeCommission($userId, 50.00, '解冻佣金');
```

::: tip
推荐使用 `UserRepository` 的辅助方法，因为它们：
- 在事务中执行，确保数据一致性
- 自动验证金额不能为负数
- 自动处理金额的正负数转换
- 返回创建后的日志记录
:::

### 方式二：直接创建佣金日志

佣金系统使用观察者模式自动处理佣金变更。只需创建 `UserCommissionLog` 记录，系统会自动：

1. 验证操作合法性
2. 更新用户佣金
3. 记录变更前后佣金

```php
use Modules\User\Models\UserCommissionLog;

// 消费返佣示例
UserCommissionLog::create([
    'user_id' => $userId,
    'commission' => 10.50,  // 正数表示增加
    'operation' => 'consumption_returns_commission',
    'memo' => '消费返佣',
]);

// 提现示例
UserCommissionLog::create([
    'user_id' => $userId,
    'commission' => -100.00,  // 负数表示减少
    'operation' => 'withdraw',
    'memo' => '佣金提现',
]);
```

## UserRepository 方法说明

### consumptionReturnsCommission($user_id, $commission, $memo)
消费返佣（发放佣金）
- **参数：**
  - `$user_id` - 用户ID
  - `$commission` - 佣金金额（必须为正数）
  - `$memo` - 备注说明
- **返回：** `UserCommissionLog` 实例
- **异常：** 如果金额为负数，抛出异常

### withdrawCommission($user_id, $commission, $memo)
提现佣金
- **参数：**
  - `$user_id` - 用户ID
  - `$commission` - 提现金额（必须为正数）
  - `$memo` - 备注说明
- **返回：** `UserCommissionLog` 实例
- **异常：** 如果金额为负数或佣金不足，抛出异常

### freezeCommission($user_id, $commission, $memo)
冻结佣金
- **参数：**
  - `$user_id` - 用户ID
  - `$commission` - 冻结金额（必须为正数）
  - `$memo` - 备注说明
- **返回：** `UserCommissionLog` 实例
- **异常：** 如果金额为负数或佣金不足，抛出异常

### unFreezeCommission($user_id, $commission, $memo)
解冻佣金
- **参数：**
  - `$user_id` - 用户ID
  - `$commission` - 解冻金额（必须为正数）
  - `$memo` - 备注说明
- **返回：** `UserCommissionLog` 实例
- **异常：** 如果金额为负数或冻结佣金不足，抛出异常

## 操作验证规则

### 提现 (withdraw)
- ❌ `commission` 不能 > 0（必须是负数）
- ✅ 验证佣金充足
- ✅ 自动减少用户佣金

### 消费返佣 (consumption_returns_commission)
- ✅ `commission` 必须 >= 0（正数）
- ✅ 自动增加用户佣金

### 冻结 (freeze)
- ❌ `commission` 不能 > 0（必须是负数）
- ✅ 验证佣金充足
- ✅ 减少可用佣金，增加冻结佣金

### 解冻 (unfreeze)
- ✅ `commission` 必须 >= 0（正数）
- ✅ 减少冻结佣金，增加可用佣金
- ✅ 验证冻结佣金充足

## 佣金日志字段

`UserCommissionLog` 模型包含以下字段：

- `user_id` - 用户ID
- `commission` - 变更金额（decimal(15)）
- `operation` - 操作类型
- `memo` - 备注说明
- `before` - 操作前佣金（自动填充）
- `after` - 操作后佣金（自动填充）

## 注意事项

::: warning
所有佣金操作都是通过观察者自动处理的。不要直接修改 `User` 模型的 `commission` 和 `commission_freeze` 字段，而应该通过创建 `UserCommissionLog` 记录或使用 `UserRepository` 的辅助方法来实现。
:::

::: tip
佣金计算使用 `bcadd` 和 `bcsub` 函数，确保精度准确（保留2位小数）。
:::

::: danger
提现、冻结操作会自动验证佣金是否充足，如果佣金不足会抛出异常，请务必捕获处理。
:::

::: tip
使用 `UserRepository` 的辅助方法时，所有传入的金额都应该是正数，方法内部会根据操作类型自动处理正负数转换。
:::

::: danger
所有佣金操作都应该在数据库事务中进行，以确保数据一致性。`UserRepository` 的辅助方法已经包含了事务处理，如果直接创建 `UserCommissionLog` 记录，请务必使用 `DB::transaction()` 包装操作。
:::
