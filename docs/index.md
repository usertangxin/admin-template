---
layout: home

hero:
  name: "Laravel Admin Doc"
  tagline: 基于 Laravel 12 开发的一套后台管理系统
  image:
    src: /logo.png
    alt: Laravel Admin Doc

  actions:
    - theme: brand
      text: 快速开始
      link: get-started
    - theme: alt
      text: 在 GitHub 上查看
      link: https://github.com/usertangxin/admin-template
---

<script setup>
import { data as featuresData } from "./.vitepress/features.data.js"
</script>

<div class="custom-feature">
    <a class="custom-feature-item" v-for="feature in featuresData" :key="feature.title" :href="'/Modules/' + feature.title + '/'">
        <h3 class="custom-feature-title">{{ feature.title }}</h3>
        <p class="custom-feature-details">{{ feature.details }}</p>
    </a>
</div>

### 加入我们的 QQ 群

<img src="/qq-group-code.jpg" alt="qq-group-code" style="width: 200px;margin-top: 20px;">

<style>
.custom-feature {
    /* 核心修改：使用 CSS Columns 实现瀑布流 */
    column-count: 3; /* 设置为 3 列 */
    column-gap: 20px; /* 列之间的间距 */
    
    /* 确保容器内的项目能正确换行 */
    display: block; 
}

.custom-feature-item {
    display: block;
    padding: 20px;
    border-radius: 8px;
    background-color: var(--vp-c-bg-soft);
    cursor: pointer;
    text-decoration: none !important; 
    
    /* 核心修改：防止项目在列中被分割 */
    break-inside: avoid;
    
    /* 由于使用了 column-gap，这里可以不需要 margin-bottom，让项目紧贴 */
    margin-bottom: 20px; /* 仍然保留项目底部的间距，让它们在列内有垂直距离 */
    
    /* 必须设置宽度为100%以填充列 */
    width: 100%;
    
    /* 修复某些浏览器中 break-inside 的问题 */
    box-sizing: border-box; 
}

.custom-feature .custom-feature-title {
    font-size: 18px;
    font-weight: bold;
    margin: 0;
}

.custom-feature .custom-feature-details {
    font-size: 14px;
    margin: 0;
}

/* 媒体查询：适配不同屏幕，例如小屏幕改为单列或两列 */
@media (max-width: 960px) {
    .custom-feature {
        column-count: 2;
    }
}

@media (max-width: 720px) {
    .custom-feature {
        column-count: 1;
        column-gap: 0;
    }
}
</style>