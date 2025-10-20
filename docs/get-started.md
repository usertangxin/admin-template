---
title: "Get Started"
---

# Get Started
### Step 1: 安装 Composer 依赖
```bash
composer install
```

### Step 2: 安装 NPM 依赖
```bash
npm install
```
### Step 3: 复制 .env.example 到 .env
> [!TIP]
> 复制 .env.example 文件并将其重命名为 .env，然后配置数据库等信息。

### Step 4: 生成应用密钥
```bash
php artisan key:generate
```
### Step 5: 运行数据库迁移
```bash
php artisan migrate
```
### Step 6: 启用模块
> [!TIP]
> 启用所有模块。对于 Windows 用户，需要手动输入 "All" 两次。

```bash
php artisan module:enable
```

### Step 7: 运行项目
```bash
composer run dev
```
> [!TIP]
> 以上命令在 Windows 控制台中存在代码着色问题。如果有强迫症，您可以运行以下命令：
```bash
npm run php
```
