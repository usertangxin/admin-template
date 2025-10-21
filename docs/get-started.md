---
title: "Get Started"
---

# Get Started
做完以下步骤后，初始账号为 `super admin`，密码为 `123456`。

## 开发环境依赖
- PHP 8.2 或更高版本
- 必要的 PHP 扩展：pdo, pdo_sqlite, sqlite3
- Node.js 环境 20.x 或更高版本
- npm 包管理器 10.x 或更高版本
- 数据库（支持 SQLite、MySQL 等）版本请关注 [Laravel 12 文档](https://laravel.com/docs/12.x/database)

## 开始安装
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
