<template>
    <a-tree ref="treeRef" :selectable="selectable && !mergedDisabled" v-bind="$attrs"></a-tree>
</template>

<script setup>
import { useFormItem } from '@arco-design/web-vue';
import { onMounted, ref, getCurrentInstance } from 'vue';

const { mergedDisabled } = useFormItem();
const treeRef = ref(null);

const props = defineProps({
    selectable: {
        type: Boolean,
        default: true,
    }
})

const ins = getCurrentInstance();

onMounted(()=>{
    if (treeRef.value) {
        for(const a in treeRef.value) {
            ins.exposeProxy[a] ??= treeRef.value[a]
        }
    }
})

</script>