import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import Size from '/Modules/Admin/resources/assets/js//layouts/size.vue';
import useComm from '/Modules/Admin/resources/assets/js/useComm.js'
import NotFoundPage from '/Modules/Admin/resources/assets/js/pages/404.vue'

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./pages/**/*.vue', { eager: true })
    let page = pages[`./pages/${name}.vue`]
    if(!page) {
      page = NotFoundPage
    }
    if (page.default) {
      page.default.layout = page.default.layout || Size
    }
    return page
  },
  setup({ el, App, props, plugin }) {

    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(useComm)
      .mount(el)
  },
  progress: {
    // The delay after which the progress bar will appear, in milliseconds...
    delay: 200,

    // The color of the progress bar...
    color: '#29d',

    // Whether to include the default NProgress styles...
    includeCSS: true,

    // Whether the NProgress spinner will be shown...
    showSpinner: true,
  },
})