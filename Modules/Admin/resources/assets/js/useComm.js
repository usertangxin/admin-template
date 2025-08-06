import './axios'
import { Boot } from '@wangeditor/editor'
import selectFile from './components/wang-editor-menu/select-file'
import { router } from '@inertiajs/vue3';
import ArcoVue from '@arco-design/web-vue';
import ArcoVueIcon from '@arco-design/web-vue/es/icon';
import '@arco-design/web-vue/dist/arco.css';
import { ZiggyVue } from 'ziggy-js';
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
// 引入所有实心图标
import * as solid from '@fortawesome/free-solid-svg-icons';
// 引入所有常规图标
import * as regular from '@fortawesome/free-regular-svg-icons';
// 引入所有品牌图标
import * as brands from '@fortawesome/free-brands-svg-icons';
import FasIcon from './components/fas-icon.vue'
import FabIcon from './components/fab-icon.vue'
import FarIcon from './components/far-icon.vue'
import AIcon from './components/a-icon.vue'
import Icon from './components/icon.vue'
import IndexTable from './components/index-table.vue'
import DictTag from './components/dict-tag.vue'
import IndexAction from './components/index-action.vue'
import FormAction from './components/form-action.vue'
import FormCol from './components/form-col.vue'
import DictRadio from './components/dict-radio.vue'
import UploadFile from './components/upload-file.vue'
import UploadImage from './components/upload-image.vue'
import SaveForm from './components/save-form.vue'
import ResourceModel from './components/resource-model.vue'

const selectFileConfig = {
  key: 'selectFile',
  factory() {
    return new selectFile()
  },
}

Boot.registerMenu(selectFileConfig)

document.body.setAttribute('arco-theme', window.localStorage.getItem('arco-theme') || 'light')

window.changeTheme = (t) => {
  document.body.setAttribute('arco-theme', t)
}

window.addEventListener('popstate', function () {
  // 这里需要加一个延迟，否则首次返回时页面时 remember 数据会丢失
  setTimeout(() => {
    router.reload()
  }, 0);
})

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

const useComm = {
  install(app, options) {
    app.use(ArcoVue)
      .use(ArcoVueIcon)
      .use(ZiggyVue)
      .component('font-awesome-icon', FontAwesomeIcon)
      .component('fas-icon', FasIcon)
      .component('fab-icon', FabIcon)
      .component('far-icon', FarIcon)
      .component('a-icon', AIcon)
      .component('icon', Icon)
      .component('index-table', IndexTable)
      .component('dict-tag', DictTag)
      .component('dict-radio', DictRadio)
      .component('upload-file', UploadFile)
      .component('upload-image', UploadImage)
      .component('save-form', SaveForm)
      .component('index-action', IndexAction)
      .component('form-action', FormAction)
      .component('form-col', FormCol)
      .component('resource-model', ResourceModel)
  }
}

export default useComm
