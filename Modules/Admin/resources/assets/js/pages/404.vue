<template>
    <a-result class="h-[100vh] flex flex-col justify-center" status="404" subtitle="哎呀，该页面已不存在。">
        <template #extra>
            <a-button type="primary" @click="goBack">返回上一页</a-button>
        </template>
    </a-result>
</template>

<script setup>


const goBack = () => {
    window.history.back()
}
</script>

