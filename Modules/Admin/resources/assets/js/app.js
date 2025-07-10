import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import ArcoVue from '@arco-design/web-vue';
import ArcoVueIcon from '@arco-design/web-vue/es/icon';
import '@arco-design/web-vue/dist/arco.css';
import Size from './layouts/size.vue';
import { ZiggyVue } from 'ziggy-js';
import './axios'
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
// 引入所有实心图标
import * as solid from '@fortawesome/free-solid-svg-icons';
// 引入所有常规图标
import * as regular from '@fortawesome/free-regular-svg-icons';
// 引入所有品牌图标
import * as brands from '@fortawesome/free-brands-svg-icons';
import FasIcon from './components/fas-icon.vue'
import AIcon from './components/a-icon.vue'
import IndexTable from './components/index-table.vue'
import DictTag from './components/dict-tag.vue'

document.body.setAttribute('arco-theme', window.localStorage.getItem('arco-theme') || 'light')

// 合并所有图标集并去重
const allIcons = [...Object.values(solid), ...Object.values(regular), ...Object.values(brands)];

// 使用Map按前缀分组图标
const iconsByPrefix = allIcons.reduce((acc, icon) => {
  acc[icon.prefix] = acc[icon.prefix] || [];
  acc[icon.prefix].push(icon);
  return acc;
}, {});

// 一次性添加所有需要的图标
library.add(
  ...iconsByPrefix.fas || [],
  ...iconsByPrefix.far || [],
  ...iconsByPrefix.fab || []
);

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./pages/**/*.vue', { eager: true })
    let page = pages[`./pages/${name}.vue`]
    page.default.layout = page.default.layout || Size
    return page
  },
  setup({ el, App, props, plugin }) {

    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ArcoVue)
      .use(ArcoVueIcon)
      .use(ZiggyVue)
      .component('font-awesome-icon', FontAwesomeIcon)
      .component('fas-icon',FasIcon)
      .component('a-icon', AIcon)
      .component('index-table', IndexTable)
      .component('dict-tag', DictTag)
      .mount(el)
  },
})