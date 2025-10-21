import { defineConfig } from 'vitepress'
import { loadSidebarConfigs, copyDocs } from './util.js'

copyDocs()
const sidebarConfigs = loadSidebarConfigs()

export default defineConfig({
  title: "Laravel Admin Doc",
  themeConfig: {
    nav: [
      { text: 'Home', link: '/' },
    ],
    sidebar: [
      {
        "text": "开始",
        "items": [
          {
            "text": "快速开始",
            "link": "/get-started"
          },
        ]
      },
      ...sidebarConfigs,
    ],
    socialLinks: [
      { icon: 'github', link: 'https://github.com/usertangxin/admin-template' }
    ],
  },
  vite: {
    configFile: false,
    server: {
      port: 5172,
    }
  }
})
