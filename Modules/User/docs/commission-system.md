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

### 创建佣金日志

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
所有佣金操作都是通过观察者自动处理的。不要直接修改 `User` 模型的 `commission` 和 `commission_freeze` 字段，而应该通过创建 `UserCommissionLog` 记录来实现。
:::

::: tip
佣金计算使用 `bcadd` 和 `bcsub` 函数，确保精度准确（保留2位小数）。
:::

::: danger
提现、冻结操作会自动验证佣金是否充足，如果佣金不足会抛出异常，请务必捕获处理。
:::
