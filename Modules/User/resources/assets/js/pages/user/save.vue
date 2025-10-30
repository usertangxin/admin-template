<template>
    <div class="m-3 p-3 page-content">
        <save-form :model="formData" :rules="rules">
            <a-form-item :label="$t('user.avatar')" field="avatar">
                <upload-image :limit="1" :multiple="false" v-model="formData.avatar"></upload-image>
            </a-form-item>
            <a-form-item :label="$t('user.username')" field="username">
                <a-input v-model="formData.username" :placeholder="$t('user.usernamePlaceholder')" :disabled="!!formData.id"></a-input>
            </a-form-item>
            <a-form-item v-if="!formData.id" :label="$t('user.password')" field="password">
                <a-input-password v-model="formData.password" :placeholder="$t('user.passwordPlaceholder')"></a-input-password>
            </a-form-item>
            <a-form-item :label="$t('user.nickname')" field="nickname">
                <a-input v-model="formData.nickname" :placeholder="$t('user.nicknamePlaceholder')"></a-input>
            </a-form-item>
            <a-form-item :label="$t('user.phone')" field="phone">
                <a-input v-model="formData.phone" :placeholder="$t('user.phonePlaceholder')"></a-input>
            </a-form-item>
            <a-form-item :label="$t('user.email')" field="email">
                <a-input v-model="formData.email" :placeholder="$t('user.emailPlaceholder')"></a-input>
            </a-form-item>
            <a-form-item :label="$t('user.sex')" field="sex">
                <dict-radio code="sex" v-model="formData.sex"></dict-radio>
            </a-form-item>
            <a-form-item :label="$t('user.birthday')" field="birthday">
                <a-date-picker v-model="formData.birthday" style="width: 100%" />
            </a-form-item>
            <a-form-item :label="$t('user.vip')" field="vip">
                <a-input-number v-model="formData.vip" :min="0" :step="1" />
            </a-form-item>
            <template v-if="!page.props.__page_create__">
                <a-form-item :label="$t('user.money')" field="money">
                    <a-input-number v-model="formData.money" :min="0" :precision="2" style="width: 100%" />
                </a-form-item>
                <a-form-item :label="$t('user.score')" field="score">
                    <a-input-number v-model="formData.score" :min="0" :step="1" style="width: 100%" />
                </a-form-item>
            </template>
            <a-form-item :label="$t('user.status')" field="status">
                <dict-radio code="data_status" v-model="formData.status"></dict-radio>
            </a-form-item>
            <a-divider orientation="center">{{ $t('user.alipayInfo') }}</a-divider>
            <a-form-item :label="$t('user.alipay_name')" field="alipay_name">
                <a-input v-model="formData.alipay_name" :placeholder="$t('user.alipayNamePlaceholder')"></a-input>
            </a-form-item>
            <a-form-item :label="$t('user.alipay_account')" field="alipay_account">
                <a-input v-model="formData.alipay_account" :placeholder="$t('user.alipayAccountPlaceholder')"></a-input>
            </a-form-item>
        </save-form>
    </div>
</template>

<script setup>
import _ from 'lodash';
import { provide, reactive, ref, onMounted } from 'vue';
import { t, __ } from '/Modules/Admin/resources/assets/js/i18n'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const props = defineProps({
    data: {
        type: Object,
        default: () => ({})
    }
})

const formData = reactive({
    id: '',
    avatar: '',
    username: '',
    password: '',
    nickname: '',
    phone: '',
    email: '',
    sex: 'unknown',
    birthday: '',
    vip: 0,
    money: 0,
    score: 0,
    status: 'normal',
    alipay_name: '',
    alipay_account: ''
})

// 如果有传入数据，则合并到formData
if (props.data && Object.keys(props.data).length > 0) {
    Object.assign(formData, props.data)
}

provide('formData', formData)

const rules = {
    username: [
        { required: true, message: t('user.usernameRequired') },
        { minLength: 3, message: t('user.usernameMinLength') },
        { maxLength: 20, message: t('user.usernameMaxLength') }
    ],
    password: [
        // { required: !formData.id, message: t('user.passwordRequired') },
        { minLength: 6, message: t('user.passwordMinLength') }
    ],
    phone: [
        { match: /^1[3-9]\d{9}$/, message: t('user.phoneFormatError') }
    ],
    email: [
        { type: 'email', message: t('user.emailFormatError') }
    ],
    alipay_account: [
        { match: /^1[3-9]\d{9}$|^\w+@[\w.-]+\.[a-z]{2,}$|^[a-z0-9A-Z]{16,28}$/, 
          message: t('user.alipayAccountFormatError') 
        }
    ]
}
</script>
