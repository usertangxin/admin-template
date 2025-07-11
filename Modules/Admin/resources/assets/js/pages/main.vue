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
                                <component :is="item.icon.split(' ',2)[0] + '-icon'" :icon="item.icon.split(' ',2)[1]" style="font-size: 18px;"></component>
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
                <div class="flex-1 h-full relative">
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
                <div class="right">
                    <a-divider direction="vertical" />
                    <a-popover position="lt" trigger="click" @popup-visible-change="onPopupVisibleChange">
                        <a-badge :count="9"><icon-notification class="cursor-pointer" size="25" /></a-badge>
                        <template #content>
                            <a-list style="width: 500px;" :virtualListProps="{
                                height: 500,
                            }" :data="messages">
                                <template #item="{ item, index }">
                                    <a-list-item :key="index">
                                        <a-list-item-meta :title="item.title" :description="item.description">
                                            <template #avatar>
                                                <a-avatar shape="square">
                                                    <img :src="item.avatar" alt="">
                                                </a-avatar>
                                            </template>
                                        </a-list-item-meta>
                                        <template #actions>
                                            <div class="ml-2">
                                                <a-space>
                                                    <a-button type="primary" status="normal">
                                                        <template #icon>
                                                            <icon-import class="cursor-pointer" size="20" />
                                                        </template>
                                                    </a-button>
                                                    <a-button type="primary" status="warning">
                                                        <template #icon>
                                                            <icon-eye-invisible class="cursor-pointer" size="20" />
                                                        </template>
                                                    </a-button>
                                                </a-space>
                                            </div>
                                        </template>
                                    </a-list-item>
                                </template>
                            </a-list>
                        </template>
                    </a-popover>
                    <a-divider direction="vertical" />
                    <icon-fullscreen-exit v-if="fullScreen" class="cursor-pointer" size="25" @click="closeFullscreen" />
                    <icon-fullscreen v-else class="cursor-pointer" size="25" @click="openFullscreen" />
                    <a-divider direction="vertical" />
                    <a-dropdown trigger="hover">
                        <icon-language class="cursor-pointer" size="25" />
                        <template #content>
                            <a-doption>中文</a-doption>
                            <a-doption>English</a-doption>
                        </template>
                    </a-dropdown>
                    <a-divider direction="vertical" />
                    <icon-sun-fill class="cursor-pointer" size="25" v-if="theme == 'light'"
                        @click="changeTheme('dark')" />
                    <icon-moon-fill class="cursor-pointer" size="25" v-if="theme == 'dark'"
                        @click="changeTheme('light')" />
                    <a-divider direction="vertical" />
                    <a-dropdown trigger="click" @popup-visible-change="onPopupVisibleChange">
                        <a-space class="cursor-pointer">
                            <a-avatar shape="square">
                                <IconUser />
                            </a-avatar>
                            <span>Super Admin</span>
                        </a-space>
                        <template #content>
                            <a-dgroup title="个人">
                                <a-doption>个人中心</a-doption>
                                <a-doption>退出登录</a-doption>
                            </a-dgroup>
                            <a-dgroup title="缓存">
                                <a-doption>清理系统缓存</a-doption>
                                <a-doption>清理浏览器缓存</a-doption>
                            </a-dgroup>
                        </template>
                    </a-dropdown>
                </div>
            </div>
            <div class="flex-1 page-content">
                <div class="absolute top-0 left-0 w-full h-full" v-if="contentMask">
                    <!-- 
                    由于 a-popover click 触发方式问题，iframe区域无法穿透事件，故此有了此元素，
                    他在 a-popover 打开时打开，关闭时关闭
                      -->
                </div>
                <iframe v-for="item in openMenus" :key="item.code" v-show="item.code == currOpenMenuCode"
                    frameborder="0" ref="iframeRef" :src="item.open_url" width="100%" height="100%"></iframe>
            </div>
        </div>
    </div>
</template>
<script setup>
import { computed, defineComponent, onMounted, ref, watch } from 'vue';
import { Message } from '@arco-design/web-vue';
import RecursionMenu from '../components/recursion-menu.vue'

const iframeRef = ref(null)
const props = defineProps(['system_menus_tree', 'system_menus_list'])
const theme = ref(window.localStorage.getItem('arco-theme') || 'light')
const contentMask = ref(false)
const fullScreen = ref(false)
const currentMainMenuIndex = ref(0)
const openMenus = ref([])
const currOpenMenuCode = ref(window.localStorage.getItem('currOpenMenuCode') || '')

let storageOpenMenuCodes = window.localStorage.getItem('openMenus')
onMounted(()=>{
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
})

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

const changeTheme = (t) => {
    document.body.setAttribute('arco-theme', t)
    window.localStorage.setItem('arco-theme', t)
    theme.value = t
    iframeRef.value.forEach((item) => {
        item.contentWindow.changeTheme && item.contentWindow.changeTheme(t)
    })
}

function openFullscreen() {
    const elem = document.getElementById('app')
    // 标准方法
    if (elem.requestFullscreen) {
        elem.requestFullscreen();
    }
    // WebKit内核浏览器
    else if (elem.webkitRequestFullscreen) {
        elem.webkitRequestFullscreen();
    }
    // Firefox
    else if (elem.mozRequestFullScreen) {
        elem.mozRequestFullScreen();
    }
    // IE/Edge
    else if (elem.msRequestFullscreen) {
        elem.msRequestFullscreen();
    }
}

// 退出全屏函数
function closeFullscreen() {
    // 标准方法
    if (document.exitFullscreen) {
        document.exitFullscreen();
    }
    // WebKit内核浏览器
    else if (document.webkitExitFullscreen) {
        document.webkitExitFullscreen();
    }
    // Firefox
    else if (document.mozCancelFullScreen) {
        document.mozCancelFullScreen();
    }
    // IE/Edge
    else if (document.msExitFullscreen) {
        document.msExitFullscreen();
    }
}

document.addEventListener('fullscreenchange', handleFullscreenChange);
document.addEventListener('webkitfullscreenchange', handleFullscreenChange);
document.addEventListener('mozfullscreenchange', handleFullscreenChange);
document.addEventListener('MSFullscreenChange', handleFullscreenChange);

// 检查当前是否处于全屏状态
function isFullscreen() {
    fullScreen.value = document.fullscreenElement ||
        document.webkitFullscreenElement ||
        document.mozFullScreenElement ||
        document.msFullscreenElement || (window.innerWidth === screen.width && window.innerHeight === screen.height)
}

function handleFullscreenChange() {
    isFullscreen()
}

window.addEventListener('resize', isFullscreen);

const messages = ref([
    {
        title: '系统消息',
        description: '您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息',
        avatar: 'https://p1-arco.byteimg.com/tos-cn-i-uwbnlip3yd/3ee5f13fb09879ecb5185e440cef6eb9.png~tplv-uwbnlip3yd-webp.webp',
    },
    {
        title: '系统消息',
        description: '您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息',
        avatar: 'https://p1-arco.byteimg.com/tos-cn-i-uwbnlip3yd/3ee5f13fb09879ecb5185e440cef6eb9.png~tplv-uwbnlip3yd-webp.webp',
    },
    {
        title: '系统消息',
        description: '您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息',
        avatar: 'https://p1-arco.byteimg.com/tos-cn-i-uwbnlip3yd/3ee5f13fb09879ecb5185e440cef6eb9.png~tplv-uwbnlip3yd-webp.webp',
    },
    {
        title: '系统消息',
        description: '您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息',
        avatar: 'https://p1-arco.byteimg.com/tos-cn-i-uwbnlip3yd/3ee5f13fb09879ecb5185e440cef6eb9.png~tplv-uwbnlip3yd-webp.webp',
    },
    {
        title: '系统消息',
        description: '您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息',
        avatar: 'https://p1-arco.byteimg.com/tos-cn-i-uwbnlip3yd/3ee5f13fb09879ecb5185e440cef6eb9.png~tplv-uwbnlip3yd-webp.webp',
    },
    {
        title: '系统消息',
        description: '您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息',
        avatar: 'https://p1-arco.byteimg.com/tos-cn-i-uwbnlip3yd/3ee5f13fb09879ecb5185e440cef6eb9.png~tplv-uwbnlip3yd-webp.webp',
    },
    {
        title: '系统消息',
        description: '您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息',
        avatar: 'https://p1-arco.byteimg.com/tos-cn-i-uwbnlip3yd/3ee5f13fb09879ecb5185e440cef6eb9.png~tplv-uwbnlip3yd-webp.webp',
    },
    {
        title: '系统消息',
        description: '您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息',
        avatar: 'https://p1-arco.byteimg.com/tos-cn-i-uwbnlip3yd/3ee5f13fb09879ecb5185e440cef6eb9.png~tplv-uwbnlip3yd-webp.webp',
    },
    {
        title: '系统消息',
        description: '您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息',
        avatar: 'https://p1-arco.byteimg.com/tos-cn-i-uwbnlip3yd/3ee5f13fb09879ecb5185e440cef6eb9.png~tplv-uwbnlip3yd-webp.webp',
    },
    {
        title: '系统消息',
        description: '您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息您有一条新的系统消息',
        avatar: 'https://p1-arco.byteimg.com/tos-cn-i-uwbnlip3yd/3ee5f13fb09879ecb5185e440cef6eb9.png~tplv-uwbnlip3yd-webp.webp',
    },
])

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

const handleClickRefresh = (tab,index) => {
    handleClickTab(tab)
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
    border-bottom: 1px solid var(--color-border-3);
    background-color: var(--color-bg-2);
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
                border-left: 1px solid var(--color-border-3);
                border-right: 1px solid var(--color-border-3);

                &:first-child {
                    border-left: 0;
                }
            }
        }
    }

    .right {
        display: flex;
        align-items: center;
        margin-right: 10px;
    }
}
</style>
