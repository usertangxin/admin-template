<template>
    <div class="m-3 p-3 page-content">
        <save-form :model="formData" :rules="rules">
            <a-form-item :label="$t('user_yongjin_log.user_id')" field="user_id">
                <a-input v-model="formData.user_id" :placeholder="$t('user_yongjin_log.userIdPlaceholder')"></a-input>
            </a-form-item>
            <a-form-item :label="$t('user_yongjin_log.yongjin')" field="yongjin">
                <a-input-number v-model="formData.yongjin" :placeholder="$t('user_yongjin_log.yongjinPlaceholder')" style="width: 100%"></a-input-number>
            </a-form-item>
            <a-form-item :label="$t('user_yongjin_log.before')" field="before">
                <a-input-number v-model="formData.before" :placeholder="$t('user_yongjin_log.beforePlaceholder')" style="width: 100%"></a-input-number>
            </a-form-item>
            <a-form-item :label="$t('user_yongjin_log.after')" field="after">
                <a-input-number v-model="formData.after" :placeholder="$t('user_yongjin_log.afterPlaceholder')" style="width: 100%"></a-input-number>
            </a-form-item>
            <a-form-item :label="$t('user_yongjin_log.memo')" field="memo">
                <a-textarea v-model="formData.memo" :placeholder="$t('user_yongjin_log.memoPlaceholder')"></a-textarea>
            </a-form-item>
            <a-form-item :label="$t('user_yongjin_log.created_by')" field="created_by">
                <a-input v-model="formData.created_by" :placeholder="$t('user_yongjin_log.createdByPlaceholder')"></a-input>
            </a-form-item>
        </save-form>
    </div>
</template>

<script setup>
import { reactive } from 'vue';
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
    user_id: '',
    yongjin: 0,
    before: 0,
    after: 0,
    memo: '',
    created_by: ''
})

const rules = {
    user_id: [
        { required: true, message: t('user_yongjin_log.user_id_required') }
    ],
    yongjin: [
        { required: true, message: t('user_yongjin_log.yongjin_required') }
    ],
    before: [
        { required: true, message: t('user_yongjin_log.before_required') }
    ],
    after: [
        { required: true, message: t('user_yongjin_log.after_required') }
    ],
    memo: [
        { required: true, message: t('user_yongjin_log.memo_required') }
    ]
}
</script>