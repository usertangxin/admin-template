<template>
    <div class="m-3 p-3 page-content">
        <save-form :model="formData" :rules="rules">
            <template #update></template>
            <template #destroy></template>
            <a-form-item :label="$t('user_score_log.user_id')" field="user_id">
                <remote-select v-model="formData.user_id" url="/web/user/User/index" labelField="username" valueField="id" :placeholder="$t('user_score_log.userIdPlaceholder')"></remote-select>
            </a-form-item>
            <a-form-item :label="$t('user_score_log.score')" field="score">
                <a-input-number v-model="formData.score" :placeholder="$t('user_score_log.scorePlaceholder')" style="width: 100%"></a-input-number>
            </a-form-item>
            <a-form-item :label="$t('user_score_log.memo')" field="memo">
                <a-textarea v-model="formData.memo" :placeholder="$t('user_score_log.memoPlaceholder')"></a-textarea>
            </a-form-item>
        </save-form>
    </div>
</template>

<script setup>
import { reactive } from 'vue';
import { t, __ } from '/Modules/Admin/resources/assets/js/i18n'

const formData = reactive({
    user_id: '',
    score: '',
    memo: '',
})

const rules = {
    user_id: [
        { required: true, message: t('user_score_log.user_id_required') }
    ],
    score: [
        { required: true, message: t('user_score_log.score_required') }
    ],
    memo: [
        { required: true, message: t('user_score_log.memo_required') }
    ]
}
</script>