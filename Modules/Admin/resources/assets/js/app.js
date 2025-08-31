import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import Size from '/Modules/Admin/resources/assets/js//layouts/size.vue';
import NotFoundPage from '/Modules/Admin/resources/assets/js/pages/404.vue'
import _ from 'lodash';

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./pages/**/!(*components*/**).vue', { eager: true })
    let page = pages[`./pages/${name}.vue`]
    if (!page) {
      page = NotFoundPage
    }
    if (page.default) {
      page.default.layout = page.default.layout || Size
    }
    return page
  },
  setup({ el, App, props, plugin }) {

    const app = createApp({ render: () => h(App, props) })
      .use(plugin)

    const useComms = import.meta.glob('/Modules/**/resources/assets/js/useComm.js', { eager: true })

    _.forEach(useComms, (item, key) => {
      if (item.default) {
        app.use(item.default)
      }
    })

    app.mount(el)
  },
})