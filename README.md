# Laravel 12 后台管理系统

## 简介
本项目是基于 Laravel 12 开发的一套后台管理系统，包含多种实用功能，帮助您高效管理业务。

## 功能特性
- **管理员管理**：对系统用户进行全面管理，包括添加、编辑、删除和权限分配。
- **菜单管理**：灵活配置系统菜单，支持多级菜单结构。
- **角色管理**：定义不同角色的权限，实现精细化权限控制。
- **字典管理**：维护系统常用字典数据，方便数据统一管理。
- **配置管理**：维护系统常用配置数据，方便数据统一管理。
- **代码生成**：自动生成常用代码，提高开发效率。
- **模块管理**：对系统模块进行拆分，方便管理、维护、扩展、复用。

## 技术与依赖

### 后端技术栈
- **PHP 8.2+**：项目开发语言
- **Laravel 12.x**：PHP Web开发框架
- **Laravel Modules**：模块化开发管理
- **Laravel Sanctum**：API认证系统
- **Spatie Laravel Permission**：角色与权限管理
- **Inertia.js**：前后端分离交互方案
- **Ziggy**：JavaScript路由管理
- **Dedoc Scramble**：API文档自动生成
- **Yansongda Laravel Pay**：支付功能集成
- **Laravel Octane**：高性能应用服务器

### 前端技术栈
- **Vue 3**：JavaScript框架
- **Vite**：前端构建工具
- **Inertia.js Vue3**：前端适配Inertia
- **Pinia**：状态管理库
- **Tailwind CSS 4.0**：实用优先的CSS框架
- **Arco Design Vue**：企业级UI组件库
- **Font Awesome**：图标库
- **Vue-i18n**：国际化解决方案
- **WangEditor**：富文本编辑器
- **axios**：HTTP客户端

### 开发工具
- **Laravel Telescope**：开发调试工具
- **Laravel Pail**：日志查看工具
- **Laravel Pint**：代码格式化工具
- **PHPUnit**：单元测试框架

### 模块
- **Admin**：后台管理基础模块，请勿删除或禁用它，如果确实不需要，可以手动修改 module_status.json 文件来禁用它，手动删除 Admin模块 来删除他 √
- **CrudGenerate**：开发工具-CRUD生成。√
- **FileStorageExtend**: 扩展上传文件系统，支持阿里云、七牛云、腾讯云、亚马逊的对象存储。×
- **User**: 用户模块，c端。×
- **Map**: 地图模块，包括 高德地图，腾讯地图。×
- **Wechat**: 微信模块。包括 公众号，小程序。×
- **Sms**: 短信模块，包括 阿里云，腾讯云，七牛云。×
- **Pay**: 支付模块，包括 支付宝，微信支付。×
- **Message**: 消息模块。×

#### 打叉模块为以后可能会做的或者会完善的模块

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
php artisan module:enable 
// 启用所有模块，windows需要手动键入两次"All"
```

### 启动项目
```bash
composer run dev
```

### 查看离线文档
```bash
npm run docs:dev
```

## 许可证与版权

### 许可证
本项目采用 [MIT 许可证](LICENSE)。详细信息请参阅 [LICENSE](LICENSE) 文件。

### 版权信息
版权所有 © 2025 [tangxin]

### 免责声明
请在使用本项目前仔细阅读 [免责声明](DISCLAIMER.md)。使用本项目即表示您已理解并同意相关条款。
