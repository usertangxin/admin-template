<template>
    <div class="m-3 p-3 page-content">
        <index-action></index-action>
        <index-table></index-table>
    </div>
</template>

<script setup>
import { provideIndexShareStore } from '../../IndexShare'

const store = provideIndexShareStore({
    columns: [
        { title: '存储模式', dataIndex: 'storage_mode', show: false, },
        { title: '原文件名', dataIndex: 'origin_name', show: false, },
        { title: '文件名', dataIndex: 'object_name', },
        { title: '文件hash', dataIndex: 'hash', show: false, },
        { title: '资源类型', dataIndex: 'mime_type', },
        { title: '存储目录', dataIndex: 'storage_path', },
        { title: '文件后缀', dataIndex: 'suffix', show: false, },
        { title: '字节数', dataIndex: 'size_byte', show: false, },
        { title: '文件大小', dataIndex: 'size_info', },
        { title: 'url地址', dataIndex: 'url', show: false, },
        { title: '备注', dataIndex: 'remark', },
    ]
});

</script>