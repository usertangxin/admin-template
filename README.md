# Laravel 12 后台管理系统

## 简介
本项目是基于 Laravel 12 开发的一套后台管理系统，包含多种实用功能，帮助您高效管理业务。

## 功能特性
- **用户管理**：对系统用户进行全面管理，包括添加、编辑、删除和权限分配。
- **菜单管理**：灵活配置系统菜单，支持多级菜单结构。
- **角色管理**：定义不同角色的权限，实现精细化权限控制。
- **字典管理**：维护系统常用字典数据，方便数据统一管理。
- **系统公告管理**：发布和管理系统公告，及时通知用户。
- **代码生成**：自动生成常用代码，提高开发效率。

## 项目结构
项目主要包含以下模块和文件：
```
├── Modules/
│   ├── Admin/
│   └── User/
├── app/
├── config/
├── database/
├── resources/
├── routes/
└── tests/
```

## 快速开始
### 安装依赖
```bash
composer install
npm install
```

### 配置环境
复制 `.env.example` 文件并重命名为 `.env`，然后配置数据库等信息。

### 数据库迁移
```bash
php artisan migrate
php artisan module:migrate
php artisan module:seed
```

### 启动项目
```bash
composer run dev
```

## 许可证
本项目采用 [MIT 许可证](LICENSE)。