<template>
    <upload-file list-type="picture-card" :fileSize="fileSize" :upload-mode="uploadMode"
        image-preview :accept="accept" v-bind="$attrs" />
</template>

<script setup>

import { config_map } from '../data-share/config';
import _ from 'lodash';

const props = defineProps({
    accept: {
        type: String,
        default: () => {
            return config_map.value['upload_allow_image'].value;
        }
    },
    uploadMode: {
        type: String,
        default: 'image',
    },
    fileSize: {
        type: Number,
        default: () => config_map.value['upload_size_image'].value,
    },
})

</script>