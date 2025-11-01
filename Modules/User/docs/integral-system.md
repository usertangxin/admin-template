---
title: 积分系统
---

# 积分系统

用户积分系统提供了完整的积分管理功能，支持消费返积分、积分抵扣、冻结和解冻等操作。

## 功能说明

### 积分字段

用户表包含以下积分相关字段：
- `integral` - 用户可用积分（unsigned integer）
- `integral_freeze` - 用户冻结积分（unsigned integer）

### 操作类型

系统支持以下积分操作类型（字典：`user_integral_operation`）：

| 操作类型 | 值 | 说明 |
|---------|-----|------|
| 消费返积分 | `consumption_returns_integral` | 用户消费后返还积分 |
| 抵扣 | `deduction` | 积分抵扣消费 |
| 冻结 | `freeze` | 冻结积分 |
| 解冻 | `unfreeze` | 解冻积分 |

## 使用方法

### 方式一：使用 UserRepository 辅助方法（推荐）

`UserRepository` 提供了便捷的辅助方法，所有方法都在事务中执行，并自动处理积分的正负数转换：

```php
use Modules\User\Repositories\UserRepository;

$repository = app(UserRepository::class);

// 消费返积分 - 传入正数积分
$log = $repository->consumptionReturnsIntegral($userId, 100, '消费返积分');

// 积分抵扣 - 传入正数积分，方法内部会自动转为负数
$log = $repository->deductionIntegral($userId, 50, '积分抵扣');

// 冻结积分 - 传入正数积分，方法内部会自动转为负数
$log = $repository->freezeIntegral($userId, 20, '冻结积分');

// 解冻积分 - 传入正数积分
$log = $repository->unFreezeIntegral($userId, 20, '解冻积分');
```

::: tip
推荐使用 `UserRepository` 的辅助方法，因为它们：
- 在事务中执行，确保数据一致性
- 自动验证积分不能为负数
- 自动处理积分的正负数转换
- 返回创建后的日志记录
:::

### 方式二：直接创建积分日志

积分系统使用观察者模式自动处理积分变更。只需创建 `UserIntegralLog` 记录，系统会自动：

1. 验证操作合法性
2. 更新用户积分
3. 记录变更前后积分

```php
use Modules\User\Models\UserIntegralLog;

// 消费返积分示例
UserIntegralLog::create([
    'user_id' => $userId,
    'integral' => 100,  // 正数表示增加
    'operation' => 'consumption_returns_integral',
    'memo' => '消费返积分',
]);

// 积分抵扣示例
UserIntegralLog::create([
    'user_id' => $userId,
    'integral' => -50,  // 负数表示减少
    'operation' => 'deduction',
    'memo' => '积分抵扣',
]);
```

## UserRepository 方法说明

### consumptionReturnsIntegral($user_id, $integral, $memo)
消费返积分（增加积分）
- **参数：**
  - `$user_id` - 用户ID
  - `$integral` - 积分数量（必须为正数）
  - `$memo` - 备注说明
- **返回：** `UserIntegralLog` 实例
- **异常：** 如果积分为负数，抛出异常

### deductionIntegral($user_id, $integral, $memo)
抵扣积分
- **参数：**
  - `$user_id` - 用户ID
  - `$integral` - 抵扣积分数量（必须为正数）
  - `$memo` - 备注说明
- **返回：** `UserIntegralLog` 实例
- **异常：** 如果积分为负数或积分不足，抛出异常

### freezeIntegral($user_id, $integral, $memo)
冻结积分
- **参数：**
  - `$user_id` - 用户ID
  - `$integral` - 冻结积分数量（必须为正数）
  - `$memo` - 备注说明
- **返回：** `UserIntegralLog` 实例
- **异常：** 如果积分为负数或积分不足，抛出异常

### unFreezeIntegral($user_id, $integral, $memo)
解冻积分
- **参数：**
  - `$user_id` - 用户ID
  - `$integral` - 解冻积分数量（必须为正数）
  - `$memo` - 备注说明
- **返回：** `UserIntegralLog` 实例
- **异常：** 如果积分为负数或冻结积分不足，抛出异常

## 操作验证规则

### 消费返积分 (consumption_returns_integral)
- ✅ `integral` 必须 >= 0（正数）
- ✅ 自动增加用户积分

### 抵扣 (deduction)
- ❌ `integral` 不能 > 0（必须是负数）
- ✅ 验证积分充足
- ✅ 自动减少用户积分

### 冻结 (freeze)
- ❌ `integral` 不能 > 0（必须是负数）
- ✅ 验证积分充足
- ✅ 减少可用积分，增加冻结积分

### 解冻 (unfreeze)
- ✅ `integral` 必须 >= 0（正数）
- ✅ 减少冻结积分，增加可用积分
- ✅ 验证冻结积分充足

## 积分日志字段

`UserIntegralLog` 模型包含以下字段：

- `user_id` - 用户ID
- `integral` - 变更数量（integer）
- `operation` - 操作类型
- `memo` - 备注说明
- `before` - 操作前积分（自动填充）
- `after` - 操作后积分（自动填充）

## 注意事项

::: warning
所有积分操作都是通过观察者自动处理的。不要直接修改 `User` 模型的 `integral` 和 `integral_freeze` 字段，而应该通过创建 `UserIntegralLog` 记录或使用 `UserRepository` 的辅助方法来实现。
:::

::: tip
积分计算使用 `bcadd` 和 `bcsub` 函数，确保精度准确（整数计算）。
:::

::: danger
抵扣、冻结操作会自动验证积分是否充足，如果积分不足会抛出异常，请务必捕获处理。
:::

::: tip
使用 `UserRepository` 的辅助方法时，所有传入的积分都应该是正数，方法内部会根据操作类型自动处理正负数转换。
:::

::: danger
所有积分操作都应该在数据库事务中进行，以确保数据一致性。`UserRepository` 的辅助方法已经包含了事务处理，如果直接创建 `UserIntegralLog` 记录，请务必使用 `DB::transaction()` 包装操作。
:::
