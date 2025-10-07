<template>
    <div class="m-3 p-3 page-content">
        <save-form :model="formData" :rules="rules">
            <a-form-item label="头像" field="avatar">
                <upload-image :limit="1" :multiple="false" v-model="formData.avatar"></upload-image>
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
            <a-form-item label="角色" field="roles">
                <a-transfer :title="['未使用', '已使用']" :data="roles" one-way v-model:model-value="formData.roles" />
            </a-form-item>
            <a-form-item label="数据权限" field="data_scope_name">
                <dict-select code="data_scope" v-model="formData.data_scope_name"></dict-select>
            </a-form-item>
            <template v-if="data_scopes[formData.data_scope_name]?.extend_data_scope_view_name">
                <a-form-item label="数据权限扩展配置" field="extend_data_scope">
                    <component :is="data_scopes[formData.data_scope_name].extend_data_scope_view_name" v-model="formData.extend_data_scope"></component>
                </a-form-item>
            </template>
        </save-form>
    </div>
</template>

<script setup>
import _ from 'lodash';
import {provide, reactive, ref} from 'vue';

const props = defineProps(['data'])
const roles = ref([]);
const data_scopes = ref([])

const formData = reactive({
    avatar: '',
    admin_name: '',
    password: '',
    nickname: '',
    phone: '',
    email: '',
    remark: '',
    status: 'normal',
    roles: [],
    data_scope_name: 'all',
    extend_data_scope: {},
})

provide('formData', formData)

const rules = {
    admin_name: [
        { required: true, message: '请输入账号' },
        { minLength: 3, message: '账号长度不能小于3个字符' },
    ],
}

request.get(route('web.admin.SystemMenu.my-roles')).then(res => {
    roles.value = res.data.map(item => {
        return {
            label: item.name,
            value: item.name,
        }
    })
})

request.get('./data-scopes').then(res=>{
    data_scopes.value = res.data;
})

</script>
