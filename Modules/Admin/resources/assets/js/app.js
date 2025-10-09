import {createApp, h} from 'vue'
import {createInertiaApp, router} from '@inertiajs/vue3'
import Size from '/Modules/Admin/resources/assets/js//layouts/size.vue';
import NotFoundPage from '/Modules/Admin/resources/assets/js/pages/404.vue'
import _ from 'lodash';
import {globalCursorDefault, globalCursorProgress} from './util';
import nProgress from 'nprogress';
import {createPinia} from 'pinia'
import ArcoVue from '@arco-design/web-vue';
import ArcoVueIcon from '@arco-design/web-vue/es/icon';
import '@arco-design/web-vue/dist/arco.css';
import './axios'

createInertiaApp({
    resolve: async name => {
        const [prefix, moduleName, action] = name.split('.')
        let page = null
        if (prefix == 'module') {
            const modulePages = import.meta.glob('/Modules/**/resources/assets/js/pages/**/!(*components*/**).vue')
            page = await modulePages[`/Modules/${moduleName}/resources/assets/js/pages/${action}.vue`]()
        } else {
            const appPages = import.meta.glob('/resources/js/pages/**/!(*components*/**).vue')
            page = await appPages[`/resources/js/pages/${name}.vue`]()
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
    setup: ({el, App, props, plugin}) => {

        router.on('start', (event) => {
            console.log(`Starting a visit to ${event.detail.visit.url}`)
            nProgress.start()
            globalCursorProgress()
        })

        router.on('finish', (event) => {
            nProgress.done()
            globalCursorDefault()
        })


        const app = createApp({render: () => h(App, props)})
            .use(plugin)
            .use(ArcoVue)
            .use(ArcoVueIcon)
        const pinia = createPinia()

        const useModuleComms = import.meta.glob('/Modules/**/resources/assets/js/useComm.js', { eager: true })

        _.forEach(useModuleComms, (item, key) => {
            if (item.default) {
                app.use(item.default)
            }
        })

        const useAppComms = import.meta.glob('/resources/assets/js/useComm.js', { eager: true })
        _.forEach(useAppComms, (item, key) => {
            if (item.default) {
                app.use(item.default)
            }
        })

        app.use(pinia)
        app.mount(el)
    },
})
