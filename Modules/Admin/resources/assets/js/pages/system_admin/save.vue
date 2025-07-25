<template>
    <div class="m-3 p-3 page-content">
        <form-action @submit="handleSubmit" @reset="formRef.resetFields()"></form-action>
        <a-form class="pr-[15%]" :disabled="disabled" ref="formRef" :model="formData" :rules="rules"
            @submit="handleSubmit">
            <a-form-item label="头像" field="avatar">
                <a-avatar class="" shape="square" :size="100">
                    <template #trigger-icon>
                        <IconCamera />
                    </template>
                </a-avatar>
            </a-form-item>
            <a-form-item label="账号" field="admin_name">
                <a-input v-model="formData.admin_name" placeholder="请输入账号"></a-input>
            </a-form-item>
            <a-form-item label="密码" field="password">
                <a-input-password v-model="formData.password" placeholder="不修改请留空"></a-input-password>
            </a-form-item>
            <a-form-item label="昵称" field="nickname">
                <a-input v-model="formData.nickname" placeholder="请输入昵称"></a-input>
            </a-form-item>
            <a-form-item label="手机号" field="phone">
                <a-input v-model="formData.phone" placeholder="请输入手机号"></a-input>
            </a-form-item>
            <a-form-item label="电子邮箱" field="email">
                <a-input v-model="formData.email" placeholder="请输入电子邮箱"></a-input>
            </a-form-item>
            <a-form-item label="备注" field="remark">
                <a-textarea v-model="formData.remark" placeholder="请输入备注"></a-textarea>
            </a-form-item>
            <a-form-item label="状态" field="status">
                <dict-radio code="data_status" type="info"
                    :merge="{ normal: { remark: '管理员正常登录' }, disabled: { remark: '管理员不允许登录' } }"
                    v-model="formData.status"></dict-radio>
            </a-form-item>
            <button type="submit" hidden></button>
        </a-form>
    </div>
</template>

<script setup>
import { Message } from '@arco-design/web-vue';
import _ from 'lodash';
import { computed, onMounted, reactive, ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps(['data', '__page_read__'])
const formRef = ref(null);

const formData = reactive({
    admin_name: '',
    password: '',
    nickname: '',
    phone: '',
    email: '',
    remark: '',
    status: 'normal',
})

watch(() => props.data, (newVal, oldVal) => {
    props.data && _.each(props.data, (item, key) => {
        formData[key] = item;
    })
}, {
    immediate: true,
})

const rules = {
    admin_name: [
        { required: true, message: '请输入账号' },
        { minLength: 3, message: '账号长度不能小于3个字符' },
    ],
}

const disabled = computed(() => {
    return props.__page_read__ ? true : false;
});


const handleSubmit = () => {
    formRef.value.validate((errors) => {
        if (errors) {
            _.each(errors, (item, key) => {
                Message.error(item.message);
            })
            return
        }
        axios.post('', formData).then(res => {
            if (res.code === 0) {
                window.history.back()
            }
        })
    })

}

</script>