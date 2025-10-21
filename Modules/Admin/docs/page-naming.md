---
title: 页面命名规范
---

# 页面命名规范

以下是情况针对未显示申明页面的情况：
控制器继承至`AbstractController`<br>
假设现在有一个`Modules\Admin\Http\Controllers\MulDir\TestAbcController`控制器,
存在一个 getAbcGroup 方法,
那么他的视图路径将为 `Modules\Admin\resources\assets\js\pages\mul_dir\test_abc\abc-group.vue`<br>

方法名`get`，`post`，`put`，`delete`前缀不包含在文件名中

> [!tip]
> 目录结构为蛇形，文件名为蛇形减号分割<br>
> `Modules\Admin\Http\Controllers`命名空间对应前端目录`Modules\Admin\resources\assets\js\pages`<br>
> `MulDir\TestAbcController` 对应 `mul_dir\test_abc`目录，如果存在更多嵌套以此类推