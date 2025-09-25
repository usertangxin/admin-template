<template>
    <a-tree :ref="treeFunRef" :selectable="selectable && !mergedDisabled" v-bind="$attrs"></a-tree>
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

function treeFunRef(a) {
    treeRef.value = a
    ins.exposed = a
}

</script>