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

### 创建余额日志

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
所有余额操作都是通过观察者自动处理的。不要直接修改 `User` 模型的 `balance` 和 `balance_freeze` 字段，而应该通过创建 `UserBalanceLog` 记录来实现。
:::

::: tip
余额计算使用 `bcadd` 和 `bcsub` 函数，确保精度准确（保留2位小数）。
:::

::: danger
提现、消费、冻结操作会自动验证余额是否充足，如果余额不足会抛出异常，请务必捕获处理。
:::
