<template>
    <div class="m-3 p-3 page-content">
        <save-form :model="formData" :rules="rules">
            <a-form-item :label="$t('userVipLevel.name')" field="name">
                <a-input v-model="formData.name" :placeholder="$t('userVipLevel.namePlaceholder')" />
            </a-form-item>
            <a-form-item :label="$t('userVipLevel.level')" field="level">
                <a-input-number v-model="formData.level" :min="0" :step="1" :precision="0" 
                              :placeholder="$t('userVipLevel.levelPlaceholder')" style="width: 100%" />
            </a-form-item>
            <a-form-item :label="$t('userVipLevel.iconImage')" field="icon_image">
                <upload-image :limit="1" :multiple="false" v-model="formData.icon_image" />
            </a-form-item>
            <a-form-item :label="$t('userVipLevel.status')" field="status">
                <dict-radio code="data_status" v-model="formData.status" />
            </a-form-item>
        </save-form>
    </div>
</template>

<script setup>
import _ from 'lodash';
import {provide, reactive, ref, onMounted} from 'vue';
import {t, __} from '/Modules/Admin/resources/assets/js/i18n'
import {usePage} from '@inertiajs/vue3'

const page = usePage()
const props = defineProps({
    data: {
        type: Object,
        default: () => ({})
    }
})

const formData = reactive({
    id: '',
    name: '',
    level: 0,
    icon_image: '',
    status: 'normal'
})

const rules = {
    name: [
        { required: true, message: t('userVipLevel.nameRequired') },
        { min: 2, max: 20, message: t('userVipLevel.nameLengthError') }
    ],
    level: [
        { required: true, message: t('userVipLevel.levelRequired') },
        { type: 'number', min: 0, message: t('userVipLevel.levelMinError') }
    ],
    status: [
        { required: true, message: t('userVipLevel.statusRequired') }
    ]
}
</script>
