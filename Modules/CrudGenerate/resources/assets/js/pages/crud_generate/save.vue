<template>
    <div class=" m-3 p-3 page-content">
        <save-form :model="formData" class="!pr-0" :auto-label-width="true">
            <div v-self-resize="handleNavResize" class="fixed top-[95px] bottom-[20px] w-[150px] z-10">
                <a-scrollbar class="overflow-y-auto" :style="{ height: navSize.height + 'px' }">
                    <a-anchor :key="formData.column_list.length" line-less :change-hash="false" :smooth="true"
                        :boundary="95" @change="handleAnchorChange">
                        <a-anchor-link href="#table-design">
                            表格设计
                            <template #sublist>
                                <a-anchor-link href="#table-design-base">基础信息</a-anchor-link>
                                <draggable :list="formData.column_list" item-key="field_name">
                                    <template #item="{ element, index }">
                                        <a-anchor-link :href="`#table-design-column-${index}`">
                                            <span class="move cursor-ns-resize">
                                                <icon-drag-dot-vertical />
                                            </span>
                                            {{ element.comment || element.field_name || `字段${index + 1}` }}
                                        </a-anchor-link>
                                    </template>
                                </draggable>
                                <a-anchor-link href="#table-design-add-column">添加字段</a-anchor-link>
                            </template>
                        </a-anchor-link>
                        <a-anchor-link href="#menu-design">菜单设计</a-anchor-link>
                    </a-anchor>
                </a-scrollbar>
            </div>
            <div class="ml-[162px]">
                <div id="table-design"></div>
                <a-card title="表格设计">
                    <a-divider orientation="left" id="table-design-base">基础信息</a-divider>
                    <a-row :gutter="24">
                        <form-col>
                            <a-form-item label="数据表名" field="table_name">
                                <a-input v-model="formData.table_name" placeholder="请输入数据表名"></a-input>
                            </a-form-item>
                        </form-col>
                        <form-col>
                            <a-form-item label="数据表注释" field="table_comment">
                                <a-input v-model="formData.table_comment" placeholder="请输入数据表注释"></a-input>
                            </a-form-item>
                        </form-col>
                        <form-col>
                            <a-form-item label="主键" field="primary_key">
                                <a-input v-model="formData.primary_key" placeholder="请输入主键"></a-input>
                            </a-form-item>
                        </form-col>
                        <form-col>
                            <a-form-item label="是否软删" field="soft_delete">
                                <dict-radio v-model="formData.soft_delete" code="yes_or_no"></dict-radio>
                            </a-form-item>
                        </form-col>
                    </a-row>

                    <template v-for="(item, index) in formData.column_list">
                        <div class="text-right">
                            <a-link @click="addColumn(index)">
                                <icon-arrow-left class="mr-1" />
                                在此处插入字段
                            </a-link>
                        </div>
                        <a-divider orientation="left" :id="`table-design-column-${index}`">
                            {{ item.comment || item.field_name || `字段${index + 1}` }}
                        </a-divider>
                        <a-row :gutter="24">
                            <form-col>
                                <a-form-item label="字段名" field="field_name">
                                    <a-input v-model="item.field_name" placeholder="请输入字段名"></a-input>
                                </a-form-item>
                            </form-col>
                            <form-col>
                                <a-form-item label="注释" field="comment">
                                    <a-input v-model="item.comment" placeholder="请输入注释"></a-input>
                                </a-form-item>
                            </form-col>
                            <form-col>
                                <a-form-item label="默认值" field="default_value">
                                    <a-input v-model="item.default_value" placeholder="请输入默认值"></a-input>
                                </a-form-item>
                            </form-col>
                            <form-col>
                                <a-form-item label="字段控件" field="field_control">
                                    <a-input-group class="flex-1">
                                        <a-select v-model="item.field_control" placeholder="请选择字段控件" allow-search>
                                            <a-option v-for="item in fieldControls" :value="item.name"
                                                :label="item.label" />
                                        </a-select>

                                        <a-button v-if="fieldControls[item.field_control]?.specialParams.length > 0"
                                            type="primary" status="normal"
                                            @click="item.field_control_special_params_drawer_visible = true">配置</a-button>

                                        <a-drawer title="字段控件特殊参数配置"
                                            v-model:visible="item.field_control_special_params_drawer_visible"
                                            width="500px" :footer="false">
                                            <div class="mt-5">
                                                <a-form :model="item.field_control_special_params"
                                                    :auto-label-width="true" class=" min-w-[270px]">
                                                    <template
                                                        v-if="Array.isArray(fieldControls[item.field_control]?.specialParams)">
                                                        <a-form-item
                                                            v-for="param in fieldControls[item.field_control]?.specialParams"
                                                            :key="param.name" :label="param.label" :field="param.name"
                                                            :required="param.required">
                                                            <component :is="param.inputComponent"
                                                                v-model="item.field_control_special_params[param.name]"
                                                                :placeholder="param.placeholder"
                                                                :default-value="param.defaultValue"
                                                                v-bind="param.inputAttrs">
                                                            </component>
                                                        </a-form-item>
                                                    </template>
                                                    <template v-else>
                                                        <field-control-render :key="item.page_view_control"
                                                            :html="fieldControls[item.field_control]?.specialParams"
                                                            v-model:params="item.field_control_special_params"></field-control-render>
                                                    </template>
                                                </a-form>
                                            </div>
                                        </a-drawer>

                                    </a-input-group>
                                </a-form-item>
                            </form-col>
                            <form-col>
                                <a-form-item label="页面控件" field="page_view_control">
                                    <a-input-group class="flex-1">
                                        <a-select v-model="item.page_view_control" placeholder="请选择页面控件" allow-search>
                                            <a-option v-for="item in pageViewControls" :value="item.name"
                                                :label="item.label" />
                                        </a-select>
                                        <a-button v-if="item.page_view_control"
                                            type="primary" status="normal"
                                            @click="item.page_view_control_special_params_drawer_visible = true">配置</a-button>

                                        <a-drawer v-model:visible="item.page_view_control_special_params_drawer_visible"
                                            width="500px" :footer="false">
                                            <div class="mt-5">
                                                <template
                                                    v-if="pageViewControls[item.page_view_control]?.specialParams.length > 0">
                                                    <a-divider>页面参数配置</a-divider>
                                                    <a-form :model="item.page_view_control_special_params"
                                                        :auto-label-width="true" class="min-w-[270px]">
                                                        <template
                                                            v-if="Array.isArray(pageViewControls[item.page_view_control]?.specialParams)">
                                                            <a-form-item
                                                                v-for="param in pageViewControls[item.page_view_control]?.specialParams"
                                                                :key="param.name" :label="param.label"
                                                                :field="param.name" :required="param.required">
                                                                <component :is="param.inputComponent"
                                                                    v-model="item.page_view_control_special_params[param.name]"
                                                                    :placeholder="param.placeholder"
                                                                    :default-value="param.defaultValue"
                                                                    v-bind="param.inputAttrs">
                                                                </component>
                                                            </a-form-item>
                                                        </template>
                                                        <template v-else>
                                                            <field-control-render :key="item.page_view_control"
                                                                :html="pageViewControls[item.page_view_control]?.specialParams"
                                                                v-model:params="item.page_view_control_special_params"></field-control-render>
                                                        </template>
                                                    </a-form>
                                                </template>
                                                <template
                                                    v-if="pageViewControls[item.page_view_control]?.queryParams.length > 0">
                                                    <a-divider>查询参数配置</a-divider>
                                                    <a-form :model="item.page_view_control_query_params"
                                                        :auto-label-width="true" class="min-w-[270px]">
                                                        <template
                                                            v-if="Array.isArray(pageViewControls[item.page_view_control]?.queryParams)">
                                                            <a-form-item
                                                                v-for="param in pageViewControls[item.page_view_control]?.queryParams"
                                                                :key="param.name" :label="param.label"
                                                                :field="param.name" :required="param.required">
                                                                <component :is="param.inputComponent"
                                                                    v-model="item.page_view_control_query_params[param.name]"
                                                                    :placeholder="param.placeholder"
                                                                    :default-value="param.defaultValue"
                                                                    v-bind="param.inputAttrs">
                                                                </component>
                                                            </a-form-item>
                                                        </template>
                                                        <template v-else>
                                                            <field-control-render :key="item.page_view_control"
                                                                :html="pageViewControls[item.page_view_control]?.queryParams"
                                                                v-model:params="item.page_view_control_query_params"></field-control-render>
                                                        </template>
                                                    </a-form>
                                                </template>
                                            </div>
                                        </a-drawer>
                                    </a-input-group>
                                </a-form-item>
                            </form-col>
                            <form-col>
                                <a-form-item label="是否可空" field="nullable">
                                    <dict-radio v-model="item.nullable" code="yes_or_no"></dict-radio>
                                </a-form-item>
                            </form-col>
                            <form-col>
                                <a-form-item label="生成到表单" field="gen_form">
                                    <dict-radio v-model="item.gen_form" code="yes_or_no"></dict-radio>
                                </a-form-item>
                            </form-col>
                            <form-col>
                                <a-form-item label="生成到列表" field="gen_index">
                                    <dict-radio v-model="item.gen_index" code="yes_or_no"></dict-radio>
                                </a-form-item>
                            </form-col>
                            <form-col>
                                <a-form-item label="生成到查询" field="gen_query">
                                    <dict-radio v-model="item.gen_query" code="yes_or_no"></dict-radio>
                                </a-form-item>
                            </form-col>
                            <form-col>
                                <a-form-item label="参与排序" field="gen_sort">
                                    <dict-radio v-model="item.gen_sort" code="yes_or_no"></dict-radio>
                                </a-form-item>
                            </form-col>
                            <form-col>
                                <a-popconfirm content="确定要删除吗？" @ok="removeColumn(index, item)">
                                    <a-button type="primary" status="danger">删除</a-button>
                                </a-popconfirm>
                            </form-col>
                        </a-row>
                    </template>

                    <div id="table-design-add-column">
                        <a-button @click="addColumn(formData.column_list.length)" type="primary">添加字段</a-button>
                    </div>
                </a-card>

                <div id="menu-design" class="mt-3"></div>
                <a-card title="菜单设计">
                    <a-row :gutter="24">
                        <form-col>
                            <a-form-item label="上级菜单" field="parent_menu_code">
                                <a-cascader :options="menus" v-model="formData.parent_menu_code" placeholder="请选择上级菜单"
                                    check-strictly allow-search allow-clear></a-cascader>
                            </a-form-item>
                        </form-col>
                        <form-col>
                            <a-form-item label="菜单名称" field="menu_name">
                                <a-input v-model="formData.menu_name" placeholder="请输入菜单名称"></a-input>
                            </a-form-item>
                        </form-col>
                        <form-col>
                            <a-form-item label="菜单图标" field="menu_icon">
                                <a-input v-model="formData.menu_icon" placeholder="请输入菜单图标"></a-input>
                            </a-form-item>
                        </form-col>
                        <form-col>
                            <a-form-item label="生成方式" field="gen_mode">
                                <a-radio-group v-model="formData.gen_mode">
                                    <a-radio value="app">app</a-radio>
                                    <a-radio value="module">module</a-radio>
                                </a-radio-group>
                            </a-form-item>
                        </form-col>
                        <form-col v-if="formData.gen_mode == 'module'">
                            <a-form-item label="模块" field="module_name">
                                <a-select v-model="formData.module_name" placeholder="请选择模块">
                                    <a-option v-for="item of modules" :value="item.name" :label="item.name" />
                                </a-select>
                            </a-form-item>
                        </form-col>
                        <form-col>
                            <a-form-item label="类名" field="gen_class_name">
                                <a-input v-model="formData.gen_class_name" placeholder="请输入类名"></a-input>
                            </a-form-item>
                        </form-col>
                    </a-row>
                </a-card>
            </div>
        </save-form>
    </div>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { recursiveFilter, recursiveMap } from '/Modules/Admin/resources/assets/js/util';
import draggable from "vuedraggable";
import fieldControlRender from '../../fieldControlRender';


const formData = reactive({
    table_name: '',
    table_comment: '',
    column_list: [],
    soft_delete: 'yes',
    gen_mode: 'app',
})

const modules = ref([])
const menus = ref([])
const fieldControls = ref([])
const pageViewControls = ref([])
const queryViewControls = ref([])

const navSize = reactive({
    width: 0,
    height: 0,
})

const addColumn = (index) => {
    formData.column_list.splice(index, 0, {
        field_name: '',
        comment: '',
        default_value: '',
        field_control: '',
        field_control_special_params: {},
        page_view_control: '',
        page_view_control_special_params: {},
        page_view_control_query_params: {},
        // query_view_control: '',
        // query_view_control_special_params: {},
        nullable: 'no',
        gen_form: 'yes',
        gen_index: 'yes',
        gen_query: 'no',
        gen_sort: 'no',
    })
}

const removeColumn = (index, item) => {
    formData.column_list.splice(index, 1)
}

const handleNavResize = (e) => {
    navSize.width = e.width
    navSize.height = e.height
}

const handleAnchorChange = (e) => {
    const el = document.querySelector('a[href="' + e + '"]');
    if (el) {
        el.scrollIntoView({
            behavior: 'smooth',
        })
    }
}

request.get('/web/admin/ModuleManager/index').then(res => {
    modules.value = res.data
})

request.get('/web/admin/SystemMenu/index').then(res => {
    let a = res.data.tree
    a = recursiveFilter(a, (item) => {
        return item.type == 'G'
    })
    a = recursiveMap(a, (item) => {
        const b = {
            value: item.code,
            label: item.name,
        }
        if (item.children?.length > 0) {
            b.children = item.children
        }
        return b
    })
    menus.value = a
})

// request.get('field-controls').then(res => {
//     fieldControls.value = res.data
// })

// request.get('page-view-controls').then(res => {
//     pageViewControls.value = res.data
// })

request.get('controls').then(res => {
    fieldControls.value = res.data.field_controls
    pageViewControls.value = res.data.page_view_controls
})

</script>
