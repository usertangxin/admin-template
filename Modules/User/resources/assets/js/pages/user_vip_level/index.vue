<template>
    <div class="p-3 m-3 page-content">
        <index-action>
            <template #search>
                <!-- TODO: 搜索 -->
            </template>
        </index-action>
        <index-table></index-table>
    </div>
</template>

<script setup>
import { provideIndexShareStore } from '/Modules/Admin/resources/assets/js/IndexShare'
import { __ } from '/Modules/Admin/resources/assets/js/i18n'

const store = provideIndexShareStore({
    columns: [
        { title: 'ID', dataIndex: 'id', show: false },
        { title: __('userVipLevel.name'), dataIndex: 'name' },
        { 
            title: __('userVipLevel.iconImage'), 
            dataIndex: 'icon_image', 
            type: 'image',
            align: 'center'
        },
        { 
            title: __('userVipLevel.level'), 
            dataIndex: 'level',
            align: 'center'
        },
        { 
            title: __('userVipLevel.status'), 
            dataIndex: 'status', 
            type: 'dict_tag', 
            dict: 'data_status',
            align: 'center'
        },
        { 
            title: __('common.createdAt'), 
            dataIndex: 'created_at',
            show: false,
        },
        { 
            title: __('common.updatedAt'), 
            dataIndex: 'updated_at',
            show: false,
        }
    ],
})

</script>
