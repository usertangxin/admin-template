<template>
    <icon-fullscreen class="cursor-pointer" v-bind="$attrs" @click="changeFullScreen" />
</template>

<script setup>
import { changeFullScreen } from '../..//util'

</script>