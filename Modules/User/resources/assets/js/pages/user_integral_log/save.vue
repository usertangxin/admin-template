<template>
    <div class="m-3 p-3 page-content">
        <save-form :model="formData" :rules="rules">
            <template #update></template>
            <template #destroy></template>
            <a-form-item :label="$t('user_integral_log.user_id')" field="user_id">
                <remote-select v-model="formData.user_id" url="/web/user/User/index" labelField="username" valueField="id" :placeholder="$t('user_integral_log.userIdPlaceholder')"></remote-select>
            </a-form-item>
            <a-form-item :label="$t('user_integral_log.integral')" field="integral">
                <a-input-number v-model="formData.integral" :placeholder="$t('user_integral_log.integralPlaceholder')" style="width: 100%"></a-input-number>
            </a-form-item>
            <a-form-item :label="$t('user_integral_log.memo')" field="memo">
                <a-textarea v-model="formData.memo" :placeholder="$t('user_integral_log.memoPlaceholder')"></a-textarea>
            </a-form-item>
        </save-form>
    </div>
</template>

<script setup>
import { reactive } from 'vue';
import { t, __ } from '/Modules/Admin/resources/assets/js/i18n'

const formData = reactive({
    user_id: '',
    integral: '',
    memo: '',
})

const rules = {
    user_id: [
        { required: true, message: t('user_integral_log.user_id_required') }
    ],
    integral: [
        { required: true, message: t('user_integral_log.integral_required') }
    ],
    memo: [
        { required: true, message: t('user_integral_log.memo_required') }
    ]
}
</script>