<template>
    <upload-file list-type="picture-card" :upload-mode="uploadMode" image-preview :accept="accept" v-bind="$attrs"/>
</template>

<script setup>

import { config_map } from '../data-share/config';
import _ from 'lodash';

const props = defineProps({
    accept: {
        type: String,
        default: ()=>{
            const exts = config_map.value['upload_allow_file'].value.replace(/\s/g, '').split(',');
            return _.map(exts, ext => ext.startsWith('.') ? ext : `.${ext}`).join(',');
        }
    },
    uploadMode: {
        type: String,
        default: 'image',
    },
})

</script>