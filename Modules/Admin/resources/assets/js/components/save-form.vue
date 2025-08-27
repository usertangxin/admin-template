<template>

    <form-action @submit="handleSubmit" @reset="formRef.resetFields()">
        <template v-for="key in Object.keys($slots)" #[key] :key="key">
            <slot :name="key"></slot>
        </template>
    </form-action>
    <div>
        <a-form class="pr-[15%]" :disabled="disabled" :class="{ 'disabled-form': disabled }" ref="formRef"
            @submit="handleSubmit" :model="model" v-bind="$attrs">
            <slot></slot>
            <slot name="default-submit">
                <button v-if="!disabled && !$slots['default-submit']" type="submit" hidden></button>
            </slot>
        </a-form>
    </div>

</template>

<script setup>
import { Message } from '@arco-design/web-vue';
import { ref, computed, watch } from 'vue'
import { usePage } from '@inertiajs/vue3';
import _ from 'lodash';

const page = usePage();
const formData = defineModel('model')
const formRef = ref(null);

const props = defineProps(['submit-url'])

const disabled = computed(() => {
    return page.props.__page_read__ ? true : false;
});

watch(() => page.props.data, (newVal, oldVal) => {
    page.props.data && _.each(page.props.data, (item, key) => {
        formData.value[key] = item;
    })
}, {
    immediate: true,
})

function refreshFormToken() {
    request.get(route('web.admin.Util.form-token')).then(res => {
        if (res.code === 0) {
            formData.value.__form_token__ = res.data.token;
        }
    })
}

if (!page.props.__page_read__) {
    refreshFormToken()
}

const handleSubmit = () => {
    formRef.value.validate((errors) => {
        if (errors) {
            _.each(errors, (item, key) => {
                Message.error(item.message);
            })
            return
        }
        const url = props['submit-url'] ?? ''
        request.post(url, formData.value).then(res => {
            if (res.code === 0) {
                window.history.back()
            } else {
                refreshFormToken()
            }
        })
    })
}

</script>

<style scoped lang="scss">
:deep(.disabled-form) {
    [disabled] {
        color: var(--color-text-1);
        -webkit-text-fill-color: var(--color-text-1);

        &::placeholder {
            opacity: 0;
        }
    }
}
</style>