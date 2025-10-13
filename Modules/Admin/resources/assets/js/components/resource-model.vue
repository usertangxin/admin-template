<template>
    <a-modal v-model:visible="visible" body-class="resource-model-body" :fullscreen="true" :title="title"
        v-bind="$attrs" @ok="handleOk" :ok-text="t('resourceModel.select')" :cancel-text="t('global.cancel')">
        <!-- 此处如果不跟随 visible 就会导致导航 back 出现问题 -->
        <iframe v-if="visible" ref="iframeRef" :src="comSrc" @load="endNProgress" style="width: 100%; height: 100%;"></iframe>
    </a-modal>
</template>

<script setup>
import { computed, ref, watch } from 'vue';
import qs from 'qs'
import nProgress from 'nprogress';
import { globalCursorProgress, globalCursorDefault } from '../util.js'
import { t } from '../i18n'

const visible = defineModel('visible', {
    type: Boolean,
    default: false
})

watch(() => visible.value, (newVal) => {
    console.log('visible change to true')
    if (newVal) {
        setTimeout(() => {
            startNProgress()
        }, 0);
    }
})

const props = defineProps({
    title: {
        type: String,
        default: () => t('resourceModel.select')
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

const startNProgress = () => {
    nProgress.inc()
    globalCursorProgress()
}

const endNProgress = () => {
    nProgress.done()
    globalCursorDefault()
}

</script>

<style lang="scss">
.resource-model-body {
    padding: 0;
    flex: 1;
}
</style>