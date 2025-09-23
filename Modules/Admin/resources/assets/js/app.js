import { createApp, h} from 'vue'
import { createInertiaApp, router } from '@inertiajs/vue3'
import Size from '/Modules/Admin/resources/assets/js//layouts/size.vue';
import NotFoundPage from '/Modules/Admin/resources/assets/js/pages/404.vue'
import _ from 'lodash';
import { globalCursorDefault, globalCursorProgress } from './util';
import nProgress from 'nprogress';

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
    
    router.on('start', (event) => {
      console.log(`Starting a visit to ${event.detail.visit.url}`)
      nProgress.start()
      globalCursorProgress()
    })

    router.on('finish', (event) => {
      nProgress.done()
      globalCursorDefault()
    })


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