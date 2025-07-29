module.exports = {
    plugins: {
        autoprefixer: {
            // 配置需要兼容的浏览器范围
            overrideBrowserslist: [
                'last 2 versions', // 兼容各浏览器最新的两个版本
                '> 1%', // 覆盖全球使用率超过1%的浏览器
                'not dead' // 排除已停止维护的浏览器
            ]
        }
    }
  }