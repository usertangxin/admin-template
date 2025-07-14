<template>
    <div class="mb-3">
        <a-row>
            <a-col flex="auto">
                <a-space>
                    <slot name="left-before"></slot>
                    <slot name="left">
                        <slot name="refresh-before"></slot>
                        <slot name="refresh">
                            <a-button status="normal">
                                <template #icon>
                                    <icon icon="a refresh"></icon>
                                </template>
                            </a-button>
                        </slot>
                        <slot name="create-before"></slot>
                        <slot name="create">
                            <a-button type="primary" status="normal">创建</a-button>
                        </slot>
                        <slot name="destroy-before"></slot>
                        <slot name="destroy">
                            <a-button type="primary" status="danger">删除</a-button>
                        </slot>
                        <slot name="destroy-after"></slot>
                    </slot>
                    <slot name="left-after"></slot>
                </a-space>
            </a-col>
            <a-col flex="none">
                <a-space>
                    <slot name="right-before"></slot>
                    <slot name="right">
                        <slot name="search-input-before"></slot>
                        <slot name="search-input">
                            <a-input-search placeholder="请输入搜索内容" />
                        </slot>
                        <slot name="columns-before"></slot>
                        <slot name="columns">
                            <a-dropdown position="br">
                                <a-button>
                                    <template #icon>
                                        <icon icon="fas table-columns"></icon>
                                    </template>
                                </a-button>
                                <template #content>
                                    <a-space direction="vertical" class="p-1 min-w-[150px]">
                                        <label class="block">
                                            <a-checkbox>
                                                用户名
                                            </a-checkbox>
                                        </label>
                                        <label class="block">
                                            <a-checkbox>
                                                手机号
                                            </a-checkbox>
                                        </label>
                                        <label class="block">
                                            <a-checkbox>
                                                电子邮箱
                                            </a-checkbox>
                                        </label>
                                    </a-space>
                                </template>
                            </a-dropdown>
                        </slot>
                        <slot name="search">
                            <a-button status="normal">
                                <template #icon>
                                    <icon icon="a search"></icon>
                                </template>
                            </a-button>
                        </slot>
                    </slot>
                    <slot name="right-after"></slot>
                </a-space>
            </a-col>
        </a-row>
    </div>
</template>