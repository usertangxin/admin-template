<template>
    <div class="-m-3 p-3 mb-3 form-action sticky top-0 z-10">
        <a-row>
            <a-col flex="auto">
                <a-space>
                    <slot name="left-before"></slot>
                    <slot name="left">
                        <template v-if="!page.props.__page_index__">
                            <a-tooltip mini content="上一页">
                                <a-button @click="toIndex">
                                    <template #icon>
                                        <icon icon="fas arrow-left-long"></icon>
                                    </template>
                                </a-button>
                            </a-tooltip>
                        </template>
                        <slot name="refresh-before"></slot>
                        <slot name="refresh">
                            <a-tooltip mini content="刷新">
                                <a-button status="normal" @click="refreshList">
                                    <template #icon>
                                        <icon icon="a refresh"></icon>
                                    </template>
                                </a-button>
                            </a-tooltip>
                        </slot>
                        <slot name="refresh-after"></slot>
                        <slot name="fullscreen-before"></slot>
                        <slot name="fullscreen">
                            <a-tooltip mini content="全屏">
                                <a-button status="normal" @click="changeFullScreen">
                                    <template #icon>
                                        <icon icon="a fullscreen"></icon>
                                    </template>
                                </a-button>
                            </a-tooltip>
                        </slot>
                        <slot name="fullscreen-after"></slot>
                        <a-divider direction="vertical"></a-divider>
                        <template v-if="page.props.__page_create__ || page.props.__page_update__">
                            <slot name="reset-before"></slot>
                            <slot name="reset">
                                <a-button type="secondary" @click="handleReset">
                                    重置
                                </a-button>
                            </slot>
                            <slot name="reset-after"></slot>
                            <slot name="submit-before"></slot>
                            <slot name="submit">
                                <a-button type="primary" @click="handleSubmit">
                                    提交
                                </a-button>
                            </slot>
                            <slot name="submit-after"></slot>
                        </template>
                        <template v-if="page.props.__page_read__">
                            <template v-if="!page.props.data.deleted_at">
                                <slot name="update-before"></slot>
                                <slot name="update">
                                    <a-button type="primary" status="warning" @click="handleGoUpdate">
                                        去编辑
                                    </a-button>
                                </slot>
                                <slot name="update-after"></slot>
                                <slot name="destroy-before"></slot>
                                <slot name="destroy">
                                    <a-popconfirm content="确定要删除吗？" @ok="handleDestroy">
                                        <a-button type="primary" status="danger">
                                            删除
                                        </a-button>
                                    </a-popconfirm>
                                </slot>
                                <slot name="destroy-after"></slot>
                            </template>
                            <template v-else>
                                <slot name="restore-before"></slot>
                                <slot name="restore">
                                    <a-popconfirm content="确定要恢复吗？" @ok="handleRecovery">
                                        <a-button type="primary" status="success">
                                            恢复
                                        </a-button>
                                    </a-popconfirm>
                                </slot>
                                <slot name="restore-after"></slot>
                                <slot name="real-destroy-before"></slot>
                                <slot name="real-destroy">
                                    <a-popconfirm content="确定要永久删除吗？" @ok="handleRealDestroy">
                                        <a-button type="primary" status="danger">
                                            永久删除
                                        </a-button>
                                    </a-popconfirm>
                                </slot>
                                <slot name="real-destroy-after"></slot>
                            </template>
                        </template>
                    </slot>
                    <slot name="left-after"></slot>
                </a-space>
            </a-col>
            <a-col flex="none">
                <a-space>
                    <slot name="right-before"></slot>
                    <slot name="right"></slot>
                    <slot name="right-after"></slot>
                </a-space>
            </a-col>
        </a-row>
    </div>
</template>

<script setup>
import { router, usePage } from '@inertiajs/vue3';
import { changeFullScreen } from '../util'
import { property } from 'lodash';

const emits = defineEmits(['submit', 'reset'])

const page = usePage();

const refreshList = () => {
    router.reload()
}

const toIndex = () => {
    if (history.length > 1) {
        history.back()
    } else {
        router.visit('./index')
    }
}

const handleSubmit = () => {
    emits('submit')
}

const handleReset = () => {
    emits('reset')
}

const handleGoUpdate = () => {
    router.visit('./update?id=' + page.props.data.id)
}

const handleDestroy = () => {
    axios.delete('./destroy', {
        data: {
            ids: page.props.data.id,
        }
    }).then(() => {
        history.back()
    })
}

const handleRecovery = () => {
    axios.post('./recovery', { ids: page.props.data.id, }).then(() => {
        history.back()
    })
}

</script>

<style lang="scss" scoped>
.form-action {
    border-bottom: 1px solid var(--color-border-3);
    background-color: var(--color-bg-2);
}
</style>