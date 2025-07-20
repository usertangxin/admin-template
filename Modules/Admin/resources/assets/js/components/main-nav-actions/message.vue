<template>
    <a-popover position="lt" trigger="click" @popup-visible-change="onPopupVisibleChange">
        <a-badge :count="9"><icon-notification class="cursor-pointer" v-bind="$attrs" /></a-badge>
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
    <div class="absolute top-0 left-0 w-full h-full" v-if="contentMask">
        <!-- 
                    由于 a-popover click 触发方式问题，iframe区域无法穿透事件，故此有了此元素，
                    他在 a-popover 打开时打开，关闭时关闭
                      -->
    </div>
</template>

<script setup>
import { ref } from 'vue'

const contentMask = ref(false)

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

const onPopupVisibleChange = (visible) => {
    contentMask.value = visible
}
</script>