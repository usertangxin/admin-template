<template>
    <icon-sun-fill class="cursor-pointer" v-bind="$attrs" v-if="theme == 'light'"
        @click="changeTheme('dark')" />
    <icon-moon-fill class="cursor-pointer" v-bind="$attrs" v-if="theme == 'dark'"
        @click="changeTheme('light')" />
</template>

<script setup>
import { ref } from 'vue'

const theme = ref(window.localStorage.getItem('arco-theme') || 'light')

const changeTheme = (t) => {
    document.body.setAttribute('arco-theme', t)
    window.localStorage.setItem('arco-theme', t)
    theme.value = t
    document.querySelectorAll('iframe').forEach((item) => {
        item.contentWindow.changeTheme && item.contentWindow.changeTheme(t)
    })
}
</script>