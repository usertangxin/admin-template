import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import ArcoVue from '@arco-design/web-vue';
import ArcoVueIcon from '@arco-design/web-vue/es/icon';
import '@arco-design/web-vue/dist/arco.css';
import Size from './layouts/size.vue';
import { ZiggyVue } from 'ziggy-js';
import './axios'

document.body.setAttribute('arco-theme', window.localStorage.getItem('arco-theme') || 'light')

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
      .mount(el)
  },
})