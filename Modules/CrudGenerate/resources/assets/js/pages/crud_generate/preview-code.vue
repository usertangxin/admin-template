<template>
    <div class="m-3 p-3 page-content text-white">
        <div class="sticky top-0" style="background-color: var(--color-bg-2);">
            <a-tabs hide-content v-model:active-key="currKey">
                <a-tab-pane v-for="(item,key) in codes" :key="key" :title="item.file_name"></a-tab-pane>
            </a-tabs>
        </div>
        <template v-for="(item,key) in codes" :key="key">
            <div v-show="key === currKey" class="code" v-html="item.html"></div>
        </template>
    </div>
</template>
<script setup>
import {createHighlighterCore} from 'shiki/core'
import {createJavaScriptRegexEngine} from 'shiki/engine/javascript'
import {usePage} from '@inertiajs/vue3';
import _ from 'lodash'
import {onMounted, reactive, ref} from "vue";

const page = usePage()
const codes = reactive({});
const currKey = ref(null);

onMounted(async function () {
    const highlighter = await createHighlighterCore({
        themes: [
            import('@shikijs/themes/dark-plus'),
        ],
        langs: [
            import('@shikijs/langs/vue'),
            import('@shikijs/langs/php'),
        ],
        engine: createJavaScriptRegexEngine()
    })

    _.forEach(page.props.data, (value, key) => {
        currKey.value ??= key
        const a = {...value}
        a.html = highlighter.codeToHtml(value.content, {
            lang: value.lang,
            theme: 'dark-plus',
        })
        codes[key] = a
    })
})


</script>

<style scoped lang="scss">

@font-face {
    font-family: 'JetBrainsMono'; /* 自定义字体名称 */
    src: url('../../../fonts/JetBrainsMonoNL-Regular.ttf') format('truetype'); /* 字体路径，@ 指向 src 目录 */
    font-weight: normal;
    font-style: normal;
}

:deep(.code) {

    .shiki {
        padding: 15px;
        white-space: pre-wrap !important; /* 关键：允许换行 */
        word-wrap: break-word; /* 当单词过长时强制换行 */
        overflow-x: auto; /* 保留横向滚动以防换行影响阅读 */
    }

    code {

        font-family: JetBrainsMono, monospace, sans-serif;
        font-size: 17px;
        line-height: 1.6;

    }
}

</style>
