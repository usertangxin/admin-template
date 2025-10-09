import {createApp, h} from 'vue'
import {createInertiaApp, router} from '@inertiajs/vue3'
import Size from '/Modules/Admin/resources/assets/js//layouts/size.vue';
import NotFoundPage from '/Modules/Admin/resources/assets/js/pages/404.vue'
import _ from 'lodash';
import {globalCursorDefault, globalCursorProgress} from './util';
import nProgress from 'nprogress';
import {createPinia} from 'pinia'
import {createI18n} from 'vue-i18n'
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
        const i18n = createI18n({})

        const useComms = import.meta.glob('/Modules/**/resources/assets/js/useComm.js', { eager: true })

        _.forEach(useComms, (item, key) => {
            if (item.default) {
                app.use(item.default)
            }
        })

        app.use(pinia)
        app.use(i18n)
        app.mount(el)
    },
})
