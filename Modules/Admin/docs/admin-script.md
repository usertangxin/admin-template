# Admin Script

如果在模块`app\Classes`目录下，具有一个`AdminScript.php`文件，该文件实现了`AdminScriptInterface`接口。那么模块会在对应时机执行对应方法。<br>
该类不是必须的。

> [!tip]
> 可以在 `enable` 方法中执行一些初始化操作，例如注册 `字典`，`系统配置` 等

## 接口方法

### enable

启用模块。

### disable

禁用模块。

### delete

删除模块。