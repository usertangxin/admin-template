<template>
    <upload-file list-type="picture-card" :fileSize="fileSize" :upload-mode="uploadMode"
                 image-preview :accept="accept" v-bind="$attrs"/>
</template>

<script setup>

import useConfigStore from '../data-share/config';
import _ from 'lodash';
import {storeToRefs} from "pinia";

const props = defineProps({
    accept: {
        type: String,
        default: () => {
            const configStore = useConfigStore()
            const {config_map} = storeToRefs(configStore)
            return config_map.value['upload_allow_image']?.value;
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
            const {config_map} = storeToRefs(configStore)
            return config_map.value['upload_size_image']?.value
        },
    },
})

</script>
