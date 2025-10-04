<template>
    <div class="m-3 p-3 page-content text-white">
        <a-tabs>
            <a-tab-pane v-for="(item,key) in codes" :key="key" :title="item.file_name">
                <div class="text-[18px] code" v-html="item.html"></div>
            </a-tab-pane>
        </a-tabs>
    </div>
</template>
<script setup>
import {createHighlighterCore} from 'shiki/core'
import {createJavaScriptRegexEngine} from 'shiki/engine/javascript'
import {usePage} from '@inertiajs/vue3';
import _ from 'lodash'
import {onMounted, reactive} from "vue";

const page = usePage()
const codes = reactive({});

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
    code {
        font-family: JetBrainsMono, monospace, sans-serif;
    }
}

</style>
