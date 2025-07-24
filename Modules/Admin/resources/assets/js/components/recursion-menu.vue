<template>
    <template v-for="(item, index) in menus" :key="index">
        <template v-if="item.type === 'G'">
            <a-menu-item-group :title="item.name">
                <recursion-menu :menus="item.children"></recursion-menu>
            </a-menu-item-group>
        </template>
        <a-menu-item v-else-if="item.type" :key="item.code">
            <template #icon>
                <icon :icon="item.icon" style="font-size: 18px;"></icon>
            </template>
            {{ item.name }}
        </a-menu-item>
    </template>
</template>

<script setup>
defineProps(['menus'])
</script>