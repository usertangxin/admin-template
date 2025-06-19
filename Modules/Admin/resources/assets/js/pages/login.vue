<template>
    <div>
        <LoginBg />
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
            <a-card>
                <a-form>
                    <a-form-item :hide-label="true">
                        <a-input placeholder="请输入用户名">
                            <template #prefix>
                                <icon-user />
                            </template>
                        </a-input>
                    </a-form-item>
                    <a-form-item :hide-label="true">
                        <a-input placeholder="请输入密码">
                            <template #prefix>
                                <icon-lock />
                            </template>
                        </a-input>
                    </a-form-item>
                    <a-form-item :hide-label="true">
                        <a-checkbox>
                            记住我
                        </a-checkbox>
                    </a-form-item>
                    <a-button type="primary">
                        登录
                    </a-button>
                </a-form>
            </a-card>
        </div>
    </div>
</template>

<script setup>
import LoginBg from '../components/login-bg.vue'

</script>
