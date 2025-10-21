<template>
    <div>
        <LoginBg />
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 opacity-95">
            <a-card>
                <a-form ref="formRef" :model="form" :rules="rules" @submit="handleSubmit">
                    <a-form-item :hide-label="true" field="admin_name">
                        <a-input :placeholder="$t('login.inputUsername')" v-model="form.admin_name">
                            <template #prefix>
                                <icon-user />
                            </template>
                        </a-input>
                    </a-form-item>
                    <a-form-item :hide-label="true" field="password">
                        <a-input-password :placeholder="$t('login.inputPassword')" v-model="form.password">
                            <template #prefix>
                                <icon-lock />
                            </template>
                        </a-input-password>
                    </a-form-item>
                    <a-form-item :hide-label="true" field="remember">
                        <a-checkbox v-model="form.remember">
                            {{ $t('login.rememberMe') }}
                        </a-checkbox>
                    </a-form-item>
                    <a-button type="primary" html-type="submit">
                        {{ $t('login.login') }}
                    </a-button>
                </a-form>
            </a-card>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import LoginBg from '../components/login-bg.vue'
import { __ } from '../i18n'

const formRef = ref()
const form = ref({
    admin_name: '',
    password: '',
    remember: false,
})

const rules = {
    admin_name: [{ required: true, message: __('login.inputUsername') }],
    password: [{ required: true, message: __('login.inputPassword') }],
}

const handleSubmit = ({values, errors}) => {
    if(errors) {
        return
    }
    request.post('', values).then(res=>{
        if(res.code === 0) {
            window.location.href = route('web.admin.index');
        }
    })
}

</script>
