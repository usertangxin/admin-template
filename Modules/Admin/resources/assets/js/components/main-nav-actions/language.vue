<template>
    <a-dropdown trigger="hover">
        <icon-language class="cursor-pointer" v-bind="$attrs" />
        <template #content>
            <a-doption v-for="item in languageList" :key="item" @click="changeLanguage(item)">{{ mapLanguage[item] ?? item }}</a-doption>
        </template>
    </a-dropdown>
</template>

<script setup>
import { ref } from 'vue';

const languageList = ref([])

const mapLanguage = {
    'zh_CN': '中文-简体',
    'en': 'English',
}

request.get('/web/admin/SystemConfig/multi-language').then(res => {
    languageList.value = res.data.language_list
})

const changeLanguage = (locale) => {
    request.post('/web/admin/SystemConfig/change-language', {
        locale,
    }).then(res => {
        if (res.code === 0) {
            window.location.reload()
        }
    })
}


</script>