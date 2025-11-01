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

### 创建积分日志

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
所有积分操作都是通过观察者自动处理的。不要直接修改 `User` 模型的 `integral` 和 `integral_freeze` 字段，而应该通过创建 `UserIntegralLog` 记录来实现。
:::

::: tip
积分计算使用 `bcadd` 和 `bcsub` 函数，确保精度准确（整数计算）。
:::

::: danger
抵扣、冻结操作会自动验证积分是否充足，如果积分不足会抛出异常，请务必捕获处理。
:::
