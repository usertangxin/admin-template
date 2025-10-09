<template>
    <div style="border: 1px solid var(--color-neutral-3)">
        <Toolbar style="border-bottom: 1px solid var(--color-neutral-3)" :editor="editorRef"
            :defaultConfig="toolbarConfig" :mode="mode" />
        <Editor style="height: 500px; overflow-y: hidden;" v-model="valueHtml" :defaultConfig="editorConfig"
            :mode="mode" @onCreated="handleCreated" />
    </div>

    <resource-model v-model:visible="visibleResourceModel" :multiple="true"
        :src="route('web.admin.SystemUploadFile.index') + '?&mime_type=' + selectModeMap[selectMode].mimeType"
        @ok="handleSelectOk"></resource-model>

</template>

<script setup>
import '@wangeditor/editor/dist/css/style.css' // 引入 css

import { onBeforeUnmount, ref, shallowRef, onMounted, defineModel, reactive } from 'vue'
import { Editor, Toolbar } from '@wangeditor/editor-for-vue'
import { DomEditor } from '@wangeditor/editor'
import { insertImageNode } from '@wangeditor/basic-modules'
import defaultToolbarKeys from './wang-editor-menu/default-toolbar-keys'
import useConfigStore from '../data-share/config';
import { Message } from '@arco-design/web-vue';
import Decimal from 'decimal.js';
import _ from 'lodash';

const configStore = useConfigStore()

const mode = 'default'
// 编辑器实例，必须用 shallowRef
const editorRef = shallowRef()

// 内容 HTML
const valueHtml = defineModel()

const visibleResourceModel = ref(false);

const handleSelectOk = (selectedKeys) => {
    if (selectedKeys.length == 0) {
        return
    }
    selectModeMap[selectMode.value].callback(selectedKeys)
}
console.log(configStore.config_map['upload_allow_image'])
const selectModeMap = {
    image: {
        mimeType: reactive(configStore.config_map['upload_allow_image'].value),
        callback: function (selectedKeys) {
            request.get(route('web.admin.SystemUploadFile.index'), {
                params: {
                    ids: selectedKeys,
                    '__list_type__': 'all',
                }
            }).then(res => {
                if (res.code == 0) {
                    res.data.forEach(item => {
                        insertImageNode(editorRef.value, item.url, item.name)
                    })
                }
            })
        }
    },
    video: {
        mimeType: reactive(configStore.config_map['upload_allow_video'].value),
        callback: function (selectedKeys) {
            request.get(route('web.admin.SystemUploadFile.index'), {
                params: {
                    ids: selectedKeys,
                    '__list_type__': 'all',
                }
            }).then(res => {
                if (res.code == 0) {
                    res.data.forEach(item => {
                        editorRef.value.insertNode({
                            type: 'video',
                            src: item.url,
                            // poster: item.url, // 封面
                            children: [{ text: '' }],
                        })
                    })
                }
            })
        }
    }
}

const selectMode = ref('image')

// 模拟 ajax 异步获取内容
onMounted(() => {
    // setTimeout(() => {
    //     valueHtml.value = '<p>模拟 Ajax 异步设置内容</p>'
    // }, 1500)
})

const handleSelectImage = () => {
    selectMode.value = 'image'
    visibleResourceModel.value = true;
}

const handleSelectVideo = () => {
    selectMode.value = 'video'
    visibleResourceModel.value = true;
}

const toolbarConfig = {
    toolbarKeys: defaultToolbarKeys,
}
const editorConfig = {
    placeholder: '请输入内容...',
    MENU_CONF: {
        uploadImage: {
            allowedFileTypes: _.map(configStore.config_map['upload_allow_image'].value.split(','), ext => ext.startsWith('.') ? ext : `.${ext}`),
            maxFileSize: configStore.config_map['upload_size_image'].value,

            // 自定义上传
            async customUpload(file, insertFn) {

                const fileSize = configStore.config_map['upload_size_image'].value;
                if (file.size > fileSize) {
                    const MB = new Decimal(fileSize).div(1024 * 1024).toFixed(2);
                    Message.error(`文件大小不能超过${MB}MB`);
                    return false;
                }

                const data = new FormData();
                data.append('file', file);
                data.append('upload_mode', 'image');

                const res = await request.post(route('web.admin.SystemUploadFile.upload'), data)

                res.data.forEach(item => {
                    insertFn(item.url, item.name)
                })

            },
        },
        uploadVideo: {
            allowedFileTypes: _.map(configStore.config_map['upload_allow_video'].value.split(','), ext => ext.startsWith('.') ? ext : `.${ext}`),
            maxFileSize: configStore.config_map['upload_size_video'].value,
            // 自定义上传
            async customUpload(file, insertFn) {

                const fileSize = configStore.config_map['upload_size_video'].value;
                if (file.size > fileSize) {
                    const MB = new Decimal(fileSize).div(1024 * 1024).toFixed(2);
                    Message.error(`文件大小不能超过${MB}MB`);
                    return false;
                }

                const data = new FormData();
                data.append('file', file);
                data.append('upload_mode', 'video');

                const res = await request.post(route('web.admin.SystemUploadFile.upload'), data)

                res.data.forEach(item => {
                    insertFn(item.url, '')
                })
            }
        }
    }
}

// 组件销毁时，也及时销毁编辑器
onBeforeUnmount(() => {
    const editor = editorRef.value
    if (editor == null) return
    editor.destroy()
})

const handleCreated = (editor) => {
    editorRef.value = editor // 记录 editor 实例，重要！
    editor.on('select-image', handleSelectImage)
    editor.on('select-video', handleSelectVideo)
}

</script>
