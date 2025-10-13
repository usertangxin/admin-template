<template>
    <div class="m-3 p-3 page-content">
        <save-form :model="formData" :rules="rules">
            <a-form-item :label="$t('systemRole.name')" field="name">
                <a-input v-model="formData.name" :placeholder="$t('systemRole.inputRoleName')"></a-input>
            </a-form-item>
            <a-form-item :label="$t('systemRole.remark')" field="remark">
                <a-textarea v-model="formData.remark" :placeholder="$t('systemRole.inputRemark')"></a-textarea>
            </a-form-item>
            <a-form-item :label="$t('systemRole.status')" field="status">
                <dict-radio code="data_status" v-model="formData.status"></dict-radio>
            </a-form-item>
            <a-form-item :label="$t('systemRole.permissions')" field="permissions">
                <div>
                    <a-button-group>
                        <div class="arco-btn arco-btn-secondary arco-btn-shape-square arco-btn-size-large arco-btn-status-normal"
                            @click="handleToggleExpanded">{{ expandedKeys.length ? $t('global.foldAll') : $t('global.unfoldAll') }}
                        </div>
                        <a-button @click="handleToggleChecked">
                            {{ formData.permissions.length ? $t('global.cancelSelect') : $t('global.selectAll') }}
                        </a-button>
                    </a-button-group>
                    <custom-tree ref="permissionTreeRef" v-model:checked-keys="formData.permissions"
                        v-model:expanded-keys="expandedKeys" v-model:selected-keys="selectedKeys"
                        @select="handlePermissionSelect" :data="permissionTree" :default-expand-all="false"
                        :multiple="true" :show-line="true" :checkable="true"></custom-tree>
                </div>
            </a-form-item>
        </save-form>
    </div>
</template>

<script setup>
import _ from 'lodash';
import { reactive, ref, watch } from 'vue';
import { recursiveFilter, recursiveForEach, recursiveMap } from '../../util';
import { t } from '/Modules/Admin/resources/assets/js/i18n'

const props = defineProps(['data'])
const permissionTree = ref([]);
const selectedKeys = ref([]);
const expandedKeys = ref([]);
const permissionTreeRef = ref(null);
const allKeys = ref([]);

const formData = reactive({
    name: '',
    remark: '',
    status: 'normal',
    permissions: [],
})

const rules = {
    name: [
        { required: true, message: t('systemRole.inputRoleName'), },
    ],
}

const handlePermissionSelect = (_, data) => {
    selectedKeys.value = []
    const index = formData.permissions.indexOf(data.node.key)
    if (index > -1) {
        permissionTreeRef.value.checkNode(data.node.key, false)
    } else {
        permissionTreeRef.value.checkNode(data.node.key, true)
    }
}

const handleToggleExpanded = () => {
    expandedKeys.value = expandedKeys.value.length ? [] : allKeys.value;
}

const handleToggleChecked = () => {
    formData.permissions = formData.permissions.length ? [] : allKeys.value;
}

request.get(route('web.admin.SystemMenu.my-permission-tree')).then(res => {
    const data = res.data
    permissionTree.value = recursiveMap(data, (item) => {
        allKeys.value.push(item.code);
        return {
            title: item.name,
            key: item.code,
            children: item.children,
        }
    })
})

</script>