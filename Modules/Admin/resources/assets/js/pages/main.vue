<template>
    <div class="w-full h-[100vh] flex">
        <div class="h-[100vh] side">
            <div class="logo">
                <img class="logo-img" src="../../images/logo.png" alt="">
                <span>Laravel Admin</span>
            </div>
            <div class="flex">
                <div class="menu-main">
                    <a-scrollbar style="height: calc(100vh - 60px);overflow-y: scroll;">
                        <template v-for="i in 100" :key="i">
                            <div class="menu-item" :class="{ 'active': i == 1 }">
                                <icon-menu-unfold size="25" />
                                <span>菜单{{ i }}</span>
                            </div>
                        </template>
                    </a-scrollbar>
                </div>
                <div class="menu-sub">
                    <a-scrollbar style="height: calc(100vh - 60px);overflow-y: scroll;">
                        <a-menu :default-open-keys="['1']" :default-selected-keys="['0_3']" :style="{ width: '100%' }"
                            @menu-item-click="onClickMenuItem">
                            <a-menu-item key="0_1">
                                <template #icon>
                                    <IconHome size="20"></IconHome>
                                </template>
                                首页
                            </a-menu-item>
                            <a-menu-item key="0_2">
                                <template #icon>
                                    <IconSettings size="20"></IconSettings>
                                </template>
                                系统管理
                            </a-menu-item>
                            <a-menu-item key="0_3">
                                <template #icon>
                                    <IconSettings size="20"></IconSettings>
                                </template>
                                日志管理
                            </a-menu-item>
                            <a-menu-item key="0_4">
                                <template #icon>
                                    <IconLock size="20"></IconLock>
                                </template>
                                权限管理
                            </a-menu-item>
                            <a-menu-item key="0_5">
                                <template #icon>
                                    <IconSettings size="20"></IconSettings>
                                </template>
                                角色管理
                            </a-menu-item>
                            <a-menu-item key="0_6">
                                <template #icon>
                                    <IconSettings size="20"></IconSettings>
                                </template>
                                菜单管理
                            </a-menu-item>
                            <a-menu-item key="0_7">
                                <template #icon>
                                    <IconSettings size="20"></IconSettings>
                                </template>
                                操作日志
                            </a-menu-item>
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
                                <template v-for="i in 10" :key="i">
                                    <a-dropdown trigger="contextMenu" @popup-visible-change="onPopupVisibleChange">
                                        <div class="tab-item" :class="{ 'active': i == 1 }">
                                            系统管理{{ i }}
                                            <IconClose></IconClose>
                                        </div>
                                        <template #content>
                                            <a-doption>刷新</a-doption>
                                            <a-doption>关闭其他</a-doption>
                                            <a-doption>关闭全部</a-doption>
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
                <iframe frameborder=" 0" width="100%" height="100%"></iframe>
            </div>
        </div>
    </div>
</template>
<script setup>
import { defineComponent, ref, watch } from 'vue';
import { Message } from '@arco-design/web-vue';

const theme = ref(window.localStorage.getItem('arco-theme') || 'light')

const changeTheme = (t) => {
    document.body.setAttribute('arco-theme', t)
    window.localStorage.setItem('arco-theme', t)
    theme.value = t
}

const contentMask = ref(false)
const fullScreen = ref(false)

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

const onClickMenuItem = (key) => {
    Message.info({ content: `You select ${key}`, showIcon: true });
}
const onPopupVisibleChange = (visible) => {
    contentMask.value = visible
}

</script>
<style lang="scss">
body[arco-theme='dark'] {
    .page-content {
        background-color: var(--color-bg-1);
    }
}
</style>
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

:deep(.arco-scrollbar-track-direction-vertical) {
    width: 2px;

    .arco-scrollbar-thumb-bar {
        width: 2px !important;
        margin: 0 !important;
        border-radius: 0;
    }
}

:deep(.arco-scrollbar-track-direction-horizontal) {
    height: 2px;

    .arco-scrollbar-thumb-bar {
        height: 2px !important;
        margin: 0 !important;
        border-radius: 0;
    }
}

:deep(.arco-list-virtual) {
    &::-webkit-scrollbar {
        width: 3px;
        background-color: unset;
        border-radius: 0;

        &-thumb {
            background-color: var(--color-neutral-4);
            border-radius: 0;
        }
    }
}

.page-content {
    background-color: var(--color-neutral-2);
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
        gap: 10px;
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
