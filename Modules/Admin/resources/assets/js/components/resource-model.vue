<template>
    <a-modal body-class="resource-model-body" :title="title" :fullscreen="true" v-bind="$attrs">
        <iframe :src="src" style="width: 100%; height: 100%;"></iframe>
    </a-modal>
</template>

<script setup>

const props = defineProps({
    title: {
        type: String,
        default: '选择'
    },
    src: {
        type: String,
        default: ''
    }
})

</script>

<style lang="scss">
.resource-model-body {
    padding: 0;
    flex: 1;
}
</style>