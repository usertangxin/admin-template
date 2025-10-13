<template>
    <a-config-provider size="large" :locale="map[locale]">
        <slot></slot>
    </a-config-provider>
</template>

<script setup>
import en_US from '@arco-design/web-vue/es/locale/lang/en-us';
import zh_CN from '@arco-design/web-vue/es/locale/lang/zh-cn';
import ja_JP from '@arco-design/web-vue/es/locale/lang/ja-jp';
import zh_TW from '@arco-design/web-vue/es/locale/lang/zh-tw';
import pt_PT from '@arco-design/web-vue/es/locale/lang/pt-pt';
import es_ES from '@arco-design/web-vue/es/locale/lang/es-es';
import id_ID from '@arco-design/web-vue/es/locale/lang/id-id';
import fr_FR from '@arco-design/web-vue/es/locale/lang/fr-fr';
import de_DE from '@arco-design/web-vue/es/locale/lang/de-de';
import ko_KR from '@arco-design/web-vue/es/locale/lang/ko-kr';
import it_IT from '@arco-design/web-vue/es/locale/lang/it-it';
import ms_MY from '@arco-design/web-vue/es/locale/lang/ms-my';
import th_TH from '@arco-design/web-vue/es/locale/lang/th-th';

import { usePage } from '@inertiajs/vue3'

const page = usePage()

const locale = page.props.locale

const map = {
    'en' : en_US,
    'zh' : zh_CN,
    'ja' : ja_JP,
    'en_US' : en_US,
    'zh_CN' : zh_CN,
    'ja_JP' : ja_JP,
    'zh_TW' : zh_TW,
    'pt_PT' : pt_PT,
    'es_ES' : es_ES,
    'id_ID' : id_ID,
    'fr_FR' : fr_FR,
    'de_DE' : de_DE,
    'ko_KR' : ko_KR,
    'it_IT' : it_IT,
    'ms_MY' : ms_MY,
    'th_TH' : th_TH,
}

</script>