import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import Size from '/Modules/Admin/resources/assets/js//layouts/size.vue';
import NotFoundPage from '/Modules/Admin/resources/assets/js/pages/404.vue'
import _ from 'lodash';

createInertiaApp({
  resolve: name => {
    const [prefix, moduleName, action] = name.split('.')
    let page = null
    if (prefix == 'module') {
      const pages = import.meta.glob('/Modules/**/resources/assets/js/pages/**/!(*components*/**).vue', { eager: true })
      page = pages[`/Modules/${moduleName}/resources/assets/js/pages/${action}.vue`]
    }
    if (!page) {
      console.error(prefix, moduleName, action)
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