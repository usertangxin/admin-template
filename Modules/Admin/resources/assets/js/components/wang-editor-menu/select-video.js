class SelectVideoMenu {
    // TS 语法
    // class MyButtonMenu {                       // JS 语法

    constructor() {
        this.title = '选择视频' // 自定义菜单标题
        this.iconSvg = "<svg viewBox=\"0 0 1024 1024\"><path d=\"M981.184 160.096C837.568 139.456 678.848 128 512 128S186.432 139.456 42.816 160.096C15.296 267.808 0 386.848 0 512s15.264 244.16 42.816 351.904C186.464 884.544 345.152 896 512 896s325.568-11.456 469.184-32.096C1008.704 756.192 1024 637.152 1024 512s-15.264-244.16-42.816-351.904zM384 704V320l320 192-320 192z\"></path></svg>"
        this.tag = 'button'
    }

    // 获取菜单执行时的 value ，用不到则返回空 字符串或 false
    getValue(editor){
        // TS 语法
        // getValue(editor) {                              // JS 语法
        return ' hello '
    }

    // 菜单是否需要激活（如选中加粗文本，“加粗”菜单会激活），用不到则返回 false
    isActive(editor){
        // TS 语法
        // isActive(editor) {                    // JS 语法
        return false
    }

    // 菜单是否需要禁用（如选中 H1 ，“引用”菜单被禁用），用不到则返回 false
    isDisabled(editor){
        // TS 语法
        // isDisabled(editor) {                     // JS 语法
        return false
    }

    // 点击菜单时触发的函数
    exec(editor, value) {
        // TS 语法
        // exec(editor, value) {                              // JS 语法
        if (this.isDisabled(editor)) return
        // editor.insertText(value) // value 即 this.value(editor) 的返回值
        editor.emit('select-video')
    }
  }

export default SelectVideoMenu