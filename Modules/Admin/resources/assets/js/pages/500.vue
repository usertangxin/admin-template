<template>
    <a-result class="h-[100vh] flex flex-col justify-center" status="500" :subtitle="__flush_message__">
        <template #extra>
            <a-button type="primary" @click="goBack">返回上一页</a-button>
        </template>
    </a-result>
</template>

<script setup>

const props = defineProps(['__flush_message__', '__flush_code__'])

const goBack = () => {
    window.history.back()
}
</script>
