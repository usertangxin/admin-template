import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import ArcoVue from '@arco-design/web-vue';
import '@arco-design/web-vue/dist/arco.css';
import { ZiggyVue } from 'ziggy-js';

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./pages/**/*.vue', { eager: true })
    return pages[`./pages/${name}.vue`]
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ArcoVue)
      .use(ZiggyVue)
      .mount(el)
  },
})