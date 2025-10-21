<template>
    <div class="m-3 p-3 page-content">
        <save-form :model="formData" :rules="rules">
            <a-form-item :label="$t('systemAdmin.avatar')" field="avatar">
                <upload-image :limit="1" :multiple="false" v-model="formData.avatar"></upload-image>
            </a-form-item>
            <a-form-item :label="$t('systemAdmin.adminName')" field="admin_name">
                <a-input v-model="formData.admin_name" :placeholder="$t('systemAdmin.adminNamePlaceholder')"></a-input>
            </a-form-item>
            <a-form-item :label="$t('systemAdmin.password')" field="password">
                <a-input-password v-model="formData.password" :placeholder="$t('systemAdmin.passwordPlaceholder')"></a-input-password>
            </a-form-item>
            <a-form-item :label="$t('systemAdmin.nickname')" field="nickname">
                <a-input v-model="formData.nickname" :placeholder="$t('systemAdmin.nicknamePlaceholder')"></a-input>
            </a-form-item>
            <a-form-item :label="$t('systemAdmin.phone')" field="phone">
                <a-input v-model="formData.phone" :placeholder="$t('systemAdmin.phonePlaceholder')"></a-input>
            </a-form-item>
            <a-form-item :label="$t('systemAdmin.email')" field="email">
                <a-input v-model="formData.email" :placeholder="$t('systemAdmin.emailPlaceholder')"></a-input>
            </a-form-item>
            <a-form-item :label="$t('systemAdmin.remark')" field="remark">
                <a-textarea v-model="formData.remark" :placeholder="$t('systemAdmin.remarkPlaceholder')"></a-textarea>
            </a-form-item>
            <a-form-item :label="$t('systemAdmin.status')" field="status">
                <dict-radio code="data_status" v-model="formData.status"></dict-radio>
            </a-form-item>
            <a-form-item :label="$t('systemAdmin.roles')" field="roles">
                <a-transfer :title="[$t('systemAdmin.unusedRoles'), $t('systemAdmin.usedRoles')]" :data="roles" one-way v-model:model-value="formData.roles" />
            </a-form-item>
            <a-form-item :label="$t('systemAdmin.dataScope')" field="data_scope_name">
                <dict-select code="data_scope" v-model="formData.data_scope_name"></dict-select>
            </a-form-item>
            <template v-if="data_scopes[formData.data_scope_name]?.extend_data_scope_view_name">
                <a-form-item :label="$t('systemAdmin.extendDataScope')" field="extend_data_scope">
                    <component :is="data_scopes[formData.data_scope_name].extend_data_scope_view_name" v-model="formData.extend_data_scope"></component>
                </a-form-item>
            </template>
        </save-form>
    </div>
</template>

<script setup>
import _ from 'lodash';
import {provide, reactive, ref} from 'vue';
import { t, __ } from '/Modules/Admin/resources/assets/js/i18n'

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
        { required: true, message: __('systemAdmin.adminNamePlaceholder') },
        { minLength: 3, message: __('systemAdmin.adminNameMinLength') },
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
