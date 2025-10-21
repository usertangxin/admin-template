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

<style>
.custom-feature {
    display: grid;
    /* grid-template-columns: repeat(3, 1fr); */
    grid-gap: 20px;
}

.custom-feature-item {
    padding: 20px;
    border-radius: 8px;
    background-color: var(--vp-c-bg-soft);
    cursor: pointer;
    text-decoration: none !important; 
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
</style>