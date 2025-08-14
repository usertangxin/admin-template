<template>
    <div class="m-3 p-3 page-content">
        <save-form :model="formData" :rules="rules">
            <a-form-item label="角色名称" field="name">
                <a-input v-model="formData.name" placeholder="请输入角色名称"></a-input>
            </a-form-item>
            <a-form-item label="备注" field="remark">
                <a-textarea v-model="formData.remark" placeholder="请输入备注"></a-textarea>
            </a-form-item>
            <a-form-item label="状态" field="status">
                <dict-radio code="data_status"
                    v-model="formData.status"></dict-radio>
            </a-form-item>
        </save-form>
    </div>
</template>

<script setup>
import _ from 'lodash';
import { reactive, watch } from 'vue';

const props = defineProps(['data'])

const formData = reactive({
    name: '',
    remark: '',
    status: 'normal',
})

const rules = {
    name: [
        { required: true, message: '请输入角色名称' },
    ],
}

request.get(route('web.admin.SystemMenu.my-permission-tree')).then(res=>{
    
})

</script>