<template>
    <div class="w-full h-[100vh] flex">
        <div class="flex flex-col h-[100vh] side">
            <div class="logo" />
            <div class="flex-1 flex">
                <div class="menu-main">
                    <div
                        style="overflow-y: scroll;position: absolute;top: 0;left: 0;right: 0;bottom: 0;width: 100%;height: 100%;">
                        <div class="w-[70px] h-[100px]"></div>
                    </div>
                </div>
                <div class="menu-sub">
                    <a-menu :default-open-keys="['1']" :default-selected-keys="['0_3']" :style="{ width: '100%' }"
                        @menu-item-click="onClickMenuItem">
                        <a-menu-item key="0_1">
                            <IconHome></IconHome>
                            Menu 1
                        </a-menu-item>
                        <a-menu-item key="0_2">
                            <IconCalendar></IconCalendar>
                            Menu 2
                        </a-menu-item>
                        <a-menu-item key="0_3">
                            <IconCalendar></IconCalendar>
                            Menu 3
                        </a-menu-item>
                        <a-sub-menu key="1">
                            <template #title>
                                <IconCalendar></IconCalendar> Navigation 1
                            </template>
                            <a-menu-item key="1_1">Menu 1</a-menu-item>
                            <a-menu-item key="1_2">Menu 2</a-menu-item>
                            <a-sub-menu key="2" title="Navigation 2">
                                <a-menu-item key="2_1">Menu 1</a-menu-item>
                                <a-menu-item key="2_2">Menu 2</a-menu-item>
                            </a-sub-menu>
                            <a-sub-menu key="3" title="Navigation 3">
                                <a-menu-item key="3_1">Menu 1</a-menu-item>
                                <a-menu-item key="3_2">Menu 2</a-menu-item>
                                <a-menu-item key="3_3">Menu 3</a-menu-item>
                            </a-sub-menu>
                        </a-sub-menu>
                        <a-sub-menu key="4">
                            <template #title>
                                <IconCalendar></IconCalendar> Navigation 4
                            </template>
                            <a-menu-item key="4_1">Menu 1</a-menu-item>
                            <a-menu-item key="4_2">Menu 2</a-menu-item>
                            <a-menu-item key="4_3">Menu 3</a-menu-item>
                        </a-sub-menu>
                    </a-menu>

                </div>
            </div>
        </div>
        <div class="flex-1 flex flex-col">
            <div class="header">
                <div class="tabs">
                    <div class="tab-item">
                        首页
                        <IconClose></IconClose>
                    </div>
                    <div class="tab-item active">
                        系统管理
                        <IconClose></IconClose>
                    </div>
                    <div class="tab-item">
                        日志管理
                        <IconClose></IconClose>
                    </div>
                </div>
            </div>
            <div class="flex-1">
                <iframe src="" frameborder="0" width="100%" height="100%"></iframe>
            </div>
        </div>
    </div>
</template>
<script>
import { defineComponent } from 'vue';
import { Message } from '@arco-design/web-vue';

document.body.setAttribute('arco-theme', 'dark')

export default defineComponent({
    methods: {
        onClickMenuItem(key) {
            Message.info({ content: `You select ${key}`, showIcon: true });
        }
    }
});
</script>
<style scoped lang="scss">
.logo {
    height:     60px;
    background-color: var(--color-bg-1);
}
.side{
    border-right: 1px solid var(--color-border-3);
    height: 100vh; /* 确保侧边栏高度为视口高度 */
}
.menu-main {
    border-right: 1px solid var(--color-border-3);
    position: relative;
    width: 70px;
}
.menu-sub{
    height: calc(100vh - 60px);
    overflow-y: scroll;
}
.header{
    height: 44px; 
    color: var(--color-text-1);
    border-bottom: 1px solid var(--color-border-3);

    .tabs{
        height: 100%;
        display: flex;
        .tab-item{
            height: 100%;
            line-height: 44px;
            padding: 0 10px;
            cursor: pointer;
            border-right: 1px solid var(--color-border-3);
            &:hover{
                background-color: var(--color-fill-2);
                color: rgb(var(--primary-7));
            }
            &.active{
                background-color: var(--color-fill-2);
                color: rgb(var(--primary-6));
            }
        }
    }
}
</style>
