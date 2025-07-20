<template>
    <a-dropdown trigger="hover">
        <icon-language class="cursor-pointer" v-bind="$attrs" />
        <template #content>
            <a-doption>中文</a-doption>
            <a-doption>English</a-doption>
        </template>
    </a-dropdown>
</template>

<script setup></script>