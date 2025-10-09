<template>
    <upload-file list-type="picture-card" :fileSize="fileSize" :upload-mode="uploadMode"
                 image-preview :accept="accept" v-bind="$attrs"/>
</template>

<script setup>

import useConfigStore from '../data-share/config';
import _ from 'lodash';

const props = defineProps({
    accept: {
        type: String,
        default: () => {
            const configStore = useConfigStore()
            return configStore.config_map['upload_allow_image'].value;
        }
    },
    uploadMode: {
        type: String,
        default: 'image',
    },
    fileSize: {
        type: Number,
        default: () => {
            const configStore = useConfigStore()
            return configStore.config_map['upload_size_image'].value
        },
    },
})

</script>
