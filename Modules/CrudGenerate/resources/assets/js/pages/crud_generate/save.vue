<template>
    <div class="m-3 p-3 page-content">
        <save-form :model="formData" class="!pr-0" :auto-label-width="true">
            <div v-self-resize="handleNavResize" class="fixed top-[95px] bottom-[20px] w-[150px] z-10">
                <a-scrollbar class="overflow-y-auto" :style="{ height: navSize.height + 'px' }">
                    <a-anchor line-less :change-hash="false" :smooth="true" :boundary="95" @change="handleAnchorChange">
                        <a-anchor-link href="#table-design">
                            表格设计
                            <template #sublist>
                                <a-anchor-link href="#table-design-base">基础信息</a-anchor-link>
                                <template v-for="(item, index) in formData.column_list" :key="index">
                                    <a-anchor-link :href="`#table-design-column-${index}`">
                                        {{ item.comment || item.field_name || `字段${index + 1}` }}
                                    </a-anchor-link>
                                </template>
                                <a-anchor-link href="#table-design-add-column">添加字段</a-anchor-link>
                            </template>
                        </a-anchor-link>
                    </a-anchor>
                </a-scrollbar>
            </div>
            <div class="ml-[162px]">
                <a-card title="表格设计">
                    <div id="table-design"></div>
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
                    </a-row>

                    <template v-for="(item, index) in formData.column_list">
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
                                <a-form-item label="字段类型" field="field_control">
                                    <a-select placeholder="请选择字段类型"></a-select>
                                </a-form-item>
                            </form-col>
                            <form-col>
                                <a-form-item label="页面控件" field="page_view_control">
                                    <a-select placeholder="请选择页面控件"></a-select>
                                </a-form-item>
                            </form-col>
                            <form-col>
                                <a-form-item label="查询控件" field="query_view_control">
                                    <a-select placeholder="请选择查询控件"></a-select>
                                </a-form-item>
                            </form-col>
                            <form-col>
                                <a-form-item label="是否可空" field="nullable">
                                    <a-radio-group v-model="item.nullable">
                                        <a-radio :value="true">是</a-radio>
                                        <a-radio :value="false">否</a-radio>
                                    </a-radio-group>
                                </a-form-item>
                            </form-col>
                            <form-col>
                                <a-form-item label="生成到表单" field="gen_form">
                                    <a-radio-group v-model="item.gen_form">
                                        <a-radio :value="true">是</a-radio>
                                        <a-radio :value="false">否</a-radio>
                                    </a-radio-group>
                                </a-form-item>
                            </form-col>
                            <form-col>
                                <a-form-item label="生成到列表" field="gen_index">
                                    <a-radio-group v-model="item.gen_index">
                                        <a-radio :value="true">是</a-radio>
                                        <a-radio :value="false">否</a-radio>
                                    </a-radio-group>
                                </a-form-item>
                            </form-col>
                            <form-col>
                                <a-form-item label="生成到查询" field="gen_query">
                                    <a-radio-group v-model="item.gen_query">
                                        <a-radio :value="true">是</a-radio>
                                        <a-radio :value="false">否</a-radio>
                                    </a-radio-group>
                                </a-form-item>
                            </form-col>
                            <form-col>
                                <a-form-item label="参与排序" field="gen_sort">
                                    <a-radio-group v-model="item.gen_sort">
                                        <a-radio :value="true">是</a-radio>
                                        <a-radio :value="false">否</a-radio>
                                    </a-radio-group>
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
                        <a-button @click="addColumn" type="primary">添加字段</a-button>
                    </div>
                </a-card>
            </div>
        </save-form>
    </div>
</template>

<script setup>
import { reactive } from 'vue';

const formData = reactive({
    table_name: '',
    table_comment: '',
    column_list: [],
})

const navSize = reactive({
    width: 0,
    height: 0,
})

const addColumn = () => {
    formData.column_list.push({
        field_name: '',
        comment: '',
        field_control: '',
        field_control_special_params: {},
        page_view_control: '',
        page_view_control_special_params: {},
        query_view_control: '',
        query_view_control_special_params: {},
        nullable: false,
        gen_form: true,
        gen_index: true,
        gen_query: false,
        gen_sort: false,
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

</script>