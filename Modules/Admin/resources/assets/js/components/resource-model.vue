<template>
    <a-modal body-class="resource-model-body" :title="title" :fullscreen="true" v-bind="$attrs" @ok="handleOk">
        <iframe ref="iframeRef" :src="comSrc" style="width: 100%; height: 100%;"></iframe>
    </a-modal>
</template>

<script setup>
import { computed, ref } from 'vue';
import qs from 'qs'

const props = defineProps({
    title: {
        type: String,
        default: '选择'
    },
    src: {
        type: String,
        default: ''
    },
    multiple: {
        type: Boolean,
        default: true
    },
    limit: {
        type: Number,
        default: 0
    },
})

const emit = defineEmits(['ok'])

const iframeRef = ref(null)

const comSrc = computed(function () {
    let src = props.src
    const search = (new URL(src)).search
    src = src.split('?')[0]
    const query = qs.parse(search, { ignoreQueryPrefix: true })
    query.__multiple__ = props.multiple
    query.__limit__ = props.limit >= 0 ? props.limit : 0
    query.__resource_select__ = true
    return src + '?' + qs.stringify(query)
})

const handleOk = () => {
    const selectedKeys = iframeRef.value.contentWindow.getSelectedKeys()
    emit('ok', selectedKeys)
}

</script>

<style lang="scss">
.resource-model-body {
    padding: 0;
    flex: 1;
}
</style>