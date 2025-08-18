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
                <dict-radio code="data_status" v-model="formData.status"></dict-radio>
            </a-form-item>
            <a-form-item label="权限" field="permissions">
                <div>
                    <a-button-group>
                        <a-button @click="handleToggleExpanded">{{ expandedKeys.length ? '收起全部' : '展开全部' }}</a-button>
                        <a-button @click="handleToggleChecked">{{ formData.permissions.length ? '取消选中' : '全部选中' }}</a-button>
                    </a-button-group>
                    <a-tree ref="permissionTreeRef" v-model:checked-keys="formData.permissions"
                        v-model:expanded-keys="expandedKeys"
                        v-model:selected-keys="selectedKeys" @select="handlePermissionSelect" :data="permissionTree"
                        :default-expand-all="false" :multiple="true" :show-line="true" :checkable="true"></a-tree>
                </div>
            </a-form-item>
        </save-form>
    </div>
</template>

<script setup>
import _ from 'lodash';
import { reactive, ref, watch } from 'vue';
import { recursiveFilter, recursiveForEach, recursiveMap } from '../../util';

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
        { required: true, message: '请输入角色名称' },
    ],
}

const handlePermissionSelect = (_, data) => {
    selectedKeys.value = []
    const index = formData.permissions.indexOf(data.node.key)
    if(index > -1) {
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
    const data = recursiveFilter(res.data, (item) => {
        if (item.type == 'G' && (!item.children || item.children.length == 0)) {
            return false;
        }
        return true;
    })
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