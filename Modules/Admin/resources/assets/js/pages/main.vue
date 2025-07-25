<template>
    <div class="w-full h-[100vh] flex">
        <div class="h-[100vh] side">
            <div class="logo">
                <img class="logo-img" src="../../images/logo.png" alt="">
                <span v-if="subMenus.length">Laravel Admin</span>
            </div>
            <div class="flex">
                <div class="menu-main" :style="[subMenus.length ? '' : 'border-right:none']">
                    <a-scrollbar style="height: calc(100vh - 60px);overflow-y: scroll;">
                        <template v-for="(item, index) in system_menus_tree" :key="index">
                            <div class="menu-item" :class="{ 'active': index == currentMainMenuIndex }"
                                @click="handleClickMainMenu(item, index)">
                                <icon :icon="item.icon" style="font-size: 18px;"></icon>
                                <span>{{ item.name }}</span>
                            </div>
                        </template>
                    </a-scrollbar>
                </div>
                <div class="menu-sub" v-if="subMenus.length">
                    <a-scrollbar style="height: calc(100vh - 60px);overflow-y: scroll;">
                        <a-menu :selected-keys="[currOpenMenuCode]" :style="{ width: '100%' }"
                            @menu-item-click="onClickMenuItem">
                            <recursion-menu :menus="subMenus"></recursion-menu>
                        </a-menu>
                    </a-scrollbar>
                </div>
            </div>
        </div>
        <div class="flex-1 flex flex-col">
            <div class="header">
                <div class="flex-1 h-full relative left">
                    <div class=" absolute top-0 left-0 right-0 bottom-0">
                        <a-scrollbar style="height: 60px;overflow-x: scroll;width: 100%;">
                            <div class="tabs">
                                <template v-for="(item, index) in openMenus" :key="index">
                                    <a-dropdown trigger="contextMenu" @popup-visible-change="onPopupVisibleChange">
                                        <div class="tab-item" :class="{ 'active': item.code == currOpenMenuCode }"
                                            @click="handleClickTab(item)">
                                            {{ item.name }}
                                            <IconClose @click.prevent.stop="handleClickCloseTab(item, index)">
                                            </IconClose>
                                        </div>
                                        <template #content>
                                            <a-doption @click="handleClickRefresh(item, index)">刷新</a-doption>
                                            <a-doption @click="handleClickCloseOtherTab(item, index)">关闭其他</a-doption>
                                            <a-doption @click="handleClickCloseAllTab(item, index)">关闭全部</a-doption>
                                        </template>
                                    </a-dropdown>
                                </template>
                            </div>
                        </a-scrollbar>
                    </div>
                </div>
                <div class="right h-full pl-3 ml-2">
                    <template v-for="(item, index) in navActions">
                        <component :is="item" style="font-size: 25px;"></component>
                        <a-divider direction="vertical" />
                    </template>
                    <a-dropdown trigger="click" @popup-visible-change="onPopupVisibleChange">
                        <a-space class="cursor-pointer">
                            <a-avatar shape="square">
                                <IconUser />
                            </a-avatar>
                            <span>{{ auth.nickname }}</span>
                        </a-space>
                        <template #content>
                            <a-dgroup title="个人">
                                <a-doption>个人中心</a-doption>
                                <a-doption @click="logout">退出登录</a-doption>
                            </a-dgroup>
                            <a-dgroup title="缓存">
                                <a-doption @click="clearSystemCache">清理系统缓存</a-doption>
                                <a-doption @click="clearBrowserCache">清理浏览器缓存</a-doption>
                            </a-dgroup>
                        </template>
                    </a-dropdown>
                </div>
            </div>
            <div class="flex-1 page-content">
                <div class="relative">
                    <div v-show="showNProgress" class="absolute top-0 left-0 right-0 ">
                        <div class="w-full h-[35px]" id="NProgress-container"></div>
                    </div>
                </div>
                <div class="absolute top-0 left-0 w-full h-full" v-if="contentMask">
                    <!-- 
                    由于 a-popover click 触发方式问题，iframe区域无法穿透事件，故此有了此元素，
                    他在 a-popover 打开时打开，关闭时关闭
                      -->
                </div>
                <iframe v-for="item in openMenus" :key="item.code" v-show="item.code == currOpenMenuCode"
                    frameborder="0" ref="iframeRef" :src="item.open_url" @load="endNProgress" width="100%"
                    height="100%"></iframe>
            </div>
        </div>
    </div>
</template>
<script setup>
import { computed, defineComponent, onMounted, ref, watch, nextTick } from 'vue';
import { Message, Modal } from '@arco-design/web-vue';
import RecursionMenu from '../components/recursion-menu.vue'
import nProgress from 'nprogress';
import _ from 'lodash';

const props = defineProps(['system_menus_tree', 'system_menus_list', 'auth'])

const showNProgress = ref(false)
const nProgressObj = nProgress.configure({
    parent: '#NProgress-container',
})

const navActionsMeta = import.meta.glob('../components/main-nav-actions/*.vue', { eager: true })
const navActions = {}

for (const [path, module] of Object.entries(navActionsMeta)) {
    // 从路径中提取组件名称（例如从 './components/Button.vue' 中提取 'Button'）
    const componentName = path.replace(/\.\.\/components\/main-nav-actions\/(.*)\.vue$/, '$1')
    // 默认导出的才是组件
    navActions[componentName] = module.default
}


const iframeRef = ref(null)
const contentMask = ref(false)
const fullScreen = ref(false)
const currentMainMenuIndex = ref(0)
const openMenus = ref([])
const currOpenMenuCode = ref(window.localStorage.getItem('currOpenMenuCode') || '')

let storageOpenMenuCodes = window.localStorage.getItem('openMenus')
onMounted(() => {
    if (storageOpenMenuCodes) {
        storageOpenMenuCodes = JSON.parse(storageOpenMenuCodes)
        storageOpenMenuCodes.forEach((code, index) => {
            if (props.system_menus_list[code]) {
                const m = props.system_menus_list[code];
                openMenus.value.push(m)
                if (m.code == currOpenMenuCode.value) {
                    openMenu(m)
                }
            }
        })
    }
    startNProgress()
})

const formatComponentName = (name) => {
    // 转换为驼峰命名并添加空格
    return name.replace(/([A-Z])/g, ' $1').trim()
}

const subMenus = computed(() => {
    const currentMainMenu = props.system_menus_tree[currentMainMenuIndex.value]
    if (!currentMainMenu) {
        return []
    }
    if (currentMainMenu.type != 'G') {
        return [];
    }
    return currentMainMenu.children
})

const recursionFindInitMainMenuIndex = (menus, is_main = false, index = 0) => {
    for (const element of menus) {
        if (element.code == currOpenMenuCode.value) {
            return index
        }
        if (element.type === 'G') {
            if (element.children) {
                let _index = recursionFindInitMainMenuIndex(element.children, false, index)
                if (_index !== -1) {
                    return _index
                }
            }
        }
        if (is_main) {
            index++
        }
    }
    return -1
}

currentMainMenuIndex.value = recursionFindInitMainMenuIndex(props.system_menus_tree, true)





const openMenu = (menu) => {
    if (menu.type === 'M' || menu.type === 'I') {
        const url = menu.type === 'M' ? '/' + menu.url : menu.url
        for (const element of openMenus.value) {
            if (element.code == menu.code) {
                element.open_url ??= url
                currOpenMenuCode.value = menu.code
                window.localStorage.setItem('currOpenMenuCode', currOpenMenuCode.value)
                return;
            }
        }
        menu.open_url = url
        openMenus.value.push(menu)
        let codes = openMenus.value.map(item => item.code)
        window.localStorage.setItem('openMenus', JSON.stringify(codes))
        currOpenMenuCode.value = menu.code
        window.localStorage.setItem('currOpenMenuCode', currOpenMenuCode.value)
    } else if (menu.type === 'L') {
        window.open(menu.url)
    }
}



const handleClickTab = (tab) => {
    openMenu(tab)
    currentMainMenuIndex.value = recursionFindInitMainMenuIndex(props.system_menus_tree, true)
}

const handleClickCloseTab = (tab, index) => {
    openMenus.value = openMenus.value.filter(item => item.code !== tab.code)
    window.localStorage.setItem('openMenus', JSON.stringify(openMenus.value.map(item => item.code)))
    if (tab.code === currOpenMenuCode.value) {
        if (index === 0) {
            handleClickTab(openMenus.value[index])
        } else {
            handleClickTab(openMenus.value[index - 1])
        }
    }
}

const handleClickRefresh = (tab, index) => {
    handleClickTab(tab)
    startNProgress()
    iframeRef.value[index].contentWindow.location.reload()
}

const handleClickCloseOtherTab = (tab, index) => {
    openMenus.value = openMenus.value.filter(item => item.code === tab.code)
    window.localStorage.setItem('openMenus', JSON.stringify(openMenus.value.map(item => item.code)))
    handleClickTab(tab)
}

const handleClickCloseAllTab = (tab, index) => {
    openMenus.value = []
    window.localStorage.setItem('openMenus', JSON.stringify(openMenus.value.map(item => item.code)))
    currOpenMenuCode.value = ''
    window.localStorage.setItem('currOpenMenuCode', currOpenMenuCode.value)
}

const onClickMenuItem = (key) => {
    const menu = props.system_menus_list[key];
    openMenu(menu)
}
const onPopupVisibleChange = (visible) => {
    contentMask.value = visible
}
const handleClickMainMenu = (item, index) => {
    currentMainMenuIndex.value = index
    openMenu(item)
}

const clearSystemCache = async () => {
    await axios.post(route('web.admin.clear-system-cache'))
    window.location.reload()
}

const clearBrowserCache = () => {
    Modal.info({
        title: '提示',
        content: '确定要清理吗？这会导致未保存的数据丢失',
        closable: true,
        hideCancel: false,
        onCancel: () => { },
        onOk: () => {
            localStorage.clear();
            window.location.reload()
        }
    })
}

const startNProgress = () => {
    showNProgress.value = true
    nProgressObj.inc()
}

const endNProgress = () => {
    nProgressObj.done()
    setTimeout(() => {
        showNProgress.value = false
    }, 1000);
}

const logout = () => {
    window.location.href = route('web.admin.logout');
}

watch(() => currOpenMenuCode.value, () => {
    nextTick(() => {
        _.forEach(openMenus.value, (item, index) => {
            if (item.code == currOpenMenuCode.value) {
                if (iframeRef.value[index].contentWindow.document.getElementsByTagName('div').length == 0) {
                    startNProgress()
                }
            }
        })
    })
})

</script>

<style scoped lang="scss">
.logo {
    height: 60px;
    box-sizing: border-box;
    border-bottom: 1px solid var(--color-border-3);
    // background-color: var(--color-bg-1);
    display: flex;
    align-items: center;
    color: var(--color-text-1);

    .logo-img {
        height: 50px;
        width: 50px;
        margin: 5px 10px 0 20px;
    }
}

.side {
    border-right: 1px solid var(--color-border-3);
    height: 100vh;
    overflow: hidden;
    background-color: var(--color-bg-2);
}

:deep(.arco-menu-vertical .arco-menu-inner) {
    padding: 0;
}

:deep(.arco-menu-light) {
    background-color: unset;

    .arco-menu-item {
        padding-right: 25px;
        padding: 7px 25px 7px 20px;
        // border-bottom: 1px solid var(--color-border-3);
        margin: 0;

        .arco-menu-icon {
            margin-right: 5px;
        }
    }

    .arco-menu-item,
    .arco-menu-inline-header {
        background-color: unset;
    }

    .arco-menu-item.arco-menu-selected {
        background-color: rgba(var(--primary-6), .05);
        // color: rgb(var(--primary-6));
        border-top: 1px solid var(--color-border-3);
        border-bottom: 1px solid var(--color-border-3);

        &:first-child {
            border-top: 0;
        }
    }
}

.menu-main {
    border-right: 1px solid var(--color-border-3);
    position: relative;
    width: 90px;
    height: 100%;
    overflow: hidden;
    color: var(--color-text-1);

    .menu-item {
        padding: 10px 0;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 5px;
        // border-bottom: 1px solid var(--color-border-3);
        font-size: 12px;

        &:hover {
            background-color: var(--color-fill-2);
        }

        &.active {
            background-color: rgba(var(--primary-6), .05);
            color: rgb(var(--primary-6));
            border-top: 1px solid var(--color-border-3);
            border-bottom: 1px solid var(--color-border-3);

            &:first-child {
                border-top: 0;
            }
        }
    }
}

.menu-sub {
    height: 100%;
    color: var(--color-text-1);
}

.header {
    height: 60px;
    color: var(--color-text-1);
    box-sizing: border-box;
    // border-bottom: 1px solid var(--color-border-3);
    // background-color: var(--color-bg-2);
    display: flex;
    align-items: center;

    .tabs {
        height: 100%;
        display: flex;
        flex: 1;

        .tab-item {
            height: 100%;
            line-height: 60px;
            padding: 0 20px;
            cursor: pointer;
            white-space: nowrap;
            // border-right: 1px solid var(--color-border-3);

            &:hover {
                background-color: var(--color-fill-2);
                color: rgb(var(--primary-7));
            }

            &.active {
                background-color: rgba(var(--primary-6), .05);
                color: rgb(var(--primary-6));
                // border-left: 1px solid var(--color-border-3);
                // border-right: 1px solid var(--color-border-3);

                &:first-child {
                    border-left: 0;
                }
            }
        }
    }

    .left {
        border-right: 1px solid var(--color-border-3);
        border-bottom: 1px solid var(--color-border-3);
        background-color: var(--color-bg-2);
    }

    .right {
        display: flex;
        align-items: center;
        padding-right: 10px;
        border-left: 1px solid var(--color-border-3);
        border-bottom: 1px solid var(--color-border-3);
        background-color: var(--color-bg-2);
    }
}
</style>
