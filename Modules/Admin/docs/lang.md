---
title: "国际化"
---

# 国际化

## 后端国际化
参阅 [Laravel 12 文档](https://laravel.com/docs/12.x/localization)<br>
参阅 [nwidart/laravel-modules 文档](https://laravelmodules.com/docs/12/advanced/languages)

> [!tip]
> 模块中的翻译文件可以导出到应用中，而不需要修改模块中的源代码

## 前端国际化
参阅 [Vue I18n 文档](https://vue-i18n.intlify.dev/)<br>
模块中多语言文件存放目录为`/Modules/**/resources/assets/js/locales/*.json`<br>
应用中多语言文件存放目录为`/resources/js/locales/*.json`<br>
文件名为当前语言的名称，例如`en.json`、`zh-CN.json`等<br>

> [!warning]
> 多语言文件内容都是全局的，后加载的多语言文件如果存在相同的键会覆盖先加载的多语言文件的内容<br>
> 因此请规划好键名称，除非你明确知道需要覆盖先加载的多语言文件的内容