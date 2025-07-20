<template>
    <div class="m-3 p-3 page-content">
        <form-action></form-action>
        <a-form class="pr-[15%]" :disabled="disabled">
            <a-form-item label="头像">
                <a-avatar class="" shape="square" :size="100">
                    <template #trigger-icon>
                        <IconCamera />
                    </template>
                </a-avatar>
            </a-form-item>
            <a-form-item label="账号">
                <a-input placeholder="请输入账号"></a-input>
            </a-form-item>
            <a-form-item label="密码">
                <a-input-password placeholder="不修改请留空"></a-input-password>
            </a-form-item>
            <a-form-item label="昵称">
                <a-input placeholder="请输入昵称"></a-input>
            </a-form-item>
            <a-form-item label="手机号">
                <a-input placeholder="请输入手机号"></a-input>
            </a-form-item>
            <a-form-item label="电子邮箱">
                <a-input placeholder="请输入电子邮箱"></a-input>
            </a-form-item>
            <a-form-item label="备注">
                <a-textarea placeholder="请输入备注"></a-textarea>
            </a-form-item>
        </a-form>

    </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();

const disabled = computed(() => {
    return page.props.__page_read__ ? true : false;
});
</script>