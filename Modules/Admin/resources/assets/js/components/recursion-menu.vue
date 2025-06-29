<template>
    <template v-for="(item, index) in menus" :key="index">
        <template v-if="item.type === 'G'">
            <a-menu-item-group :title="item.name">
                <recursion-menu :menus="item.children"></recursion-menu>
            </a-menu-item-group>
        </template>
        <a-menu-item v-else-if="item.type === 'M'" :key="item.code">
            <template #icon>
                <component :is="item.icon.split(' ',2)[0] + '-icon'" :icon="item.icon.split(' ',2)[1]"
                    style="font-size: 18px;"></component>
            </template>
            {{ item.name }}
        </a-menu-item>
    </template>
</template>

<script setup>
defineProps(['menus'])
</script>