<template>
    <div class="-m-3 p-3 mb-3 form-action sticky top-0 z-10">
        <a-row>
            <a-col flex="auto">
                <a-space>
                    <slot name="left-before"></slot>
                    <slot name="left">
                        <template v-if="!page.props.__page_index__">
                            <a-tooltip mini content="首页">
                                <a-button @click="toIndex">
                                    <template #icon>
                                        <icon icon="fas home"></icon>
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
                                <a-button type="secondary">
                                    重置
                                </a-button>
                            </slot>
                            <slot name="reset-after"></slot>
                            <slot name="submit-before"></slot>
                            <slot name="submit">
                                <a-button type="primary">
                                    提交
                                </a-button>
                            </slot>
                            <slot name="submit-after"></slot>
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

const page = usePage();

const refreshList = () => {
    router.reload()
}

const toIndex = () => {
    if(history.length > 1) {
        history.back()
    } else {
        router.visit('./index')
    }
}

</script>

<style lang="scss" scoped>
.form-action {
    border-bottom: 1px solid var(--color-border-3);
    background-color: var(--color-bg-2);
}
</style>