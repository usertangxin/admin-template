<template>
    <div class="m-3 p-3 page-content">
        <save-form :model="formData" :rules="rules">
            <template #update></template>
            <template #destroy></template>
            <a-form-item :label="$t('user_yongjin_log.user_id')" field="user_id">
                <remote-select v-model="formData.user_id" url="/web/user/User/index" labelField="username" valueField="id" :placeholder="$t('user_yongjin_log.userIdPlaceholder')"></remote-select>
            </a-form-item>
            <a-form-item :label="$t('user_yongjin_log.yongjin')" field="yongjin">
                <a-input-number v-model="formData.yongjin" :placeholder="$t('user_yongjin_log.yongjinPlaceholder')" style="width: 100%"></a-input-number>
            </a-form-item>
            <a-form-item :label="$t('user_yongjin_log.memo')" field="memo">
                <a-textarea v-model="formData.memo" :placeholder="$t('user_yongjin_log.memoPlaceholder')"></a-textarea>
            </a-form-item>
        </save-form>
    </div>
</template>

<script setup>
import { reactive } from 'vue';
import { t, __ } from '/Modules/Admin/resources/assets/js/i18n'

const formData = reactive({
    user_id: '',
    yongjin: '',
    memo: '',
})

const rules = {
    user_id: [
        { required: true, message: t('user_yongjin_log.user_id_required') }
    ],
    yongjin: [
        { required: true, message: t('user_yongjin_log.yongjin_required') }
    ],
    memo: [
        { required: true, message: t('user_yongjin_log.memo_required') }
    ]
}
</script>
