<template>
    <div>
        <LoginBg />
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 opacity-95">
            <a-card>
                <a-form ref="formRef" :model="form" :rules="rules" @submit="handleSubmit">
                    <a-form-item :hide-label="true" field="admin_name">
                        <a-input placeholder="请输入用户名" v-model="form.admin_name">
                            <template #prefix>
                                <icon-user />
                            </template>
                        </a-input>
                    </a-form-item>
                    <a-form-item :hide-label="true" field="password">
                        <a-input-password placeholder="请输入密码" v-model="form.password">
                            <template #prefix>
                                <icon-lock />
                            </template>
                        </a-input-password>
                    </a-form-item>
                    <a-form-item :hide-label="true" field="remember">
                        <a-checkbox v-model="form.remember">
                            记住我
                        </a-checkbox>
                    </a-form-item>
                    <a-button type="primary" html-type="submit">
                        登录
                    </a-button>
                </a-form>
            </a-card>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import LoginBg from '../components/login-bg.vue'

const formRef = ref()
const form = ref({
    admin_name: '',
    password: '',
    remember: false,
})

const rules = ref({
    admin_name: [{ required: true, message: '请输入用户名' }],
    password: [{ required: true, message: '请输入密码' }],
})

const handleSubmit = ({values, errors}) => {
    if(errors) {
        return
    }
    axios.post('', values).then(res=>{
        if(res.code === 0) {
            window.location.href = route('web.module.Admin.index');
        }
    })
}

</script>
