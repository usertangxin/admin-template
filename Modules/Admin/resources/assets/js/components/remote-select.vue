<template>
    <a-select @search="handleSearch" allow-search :trigger-props="{ updateAtScroll: true }"
        :virtual-list-props="{ height: 200, onReachBottom: handleDropdownReachBottom }" :filter-option="false"
        :options="options" v-bind="$attrs"></a-select>
</template>

<script setup>
import { ref } from 'vue';
import _ from 'lodash'

const props = defineProps({
    url: {
        type: String,
    },
    pagination: {
        type: Boolean,
        default: true
    },
    perPage: {
        type: Number,
        default: 10
    },
    labelField: {
        type: String,
        default: 'name',
    },
    valueField: {
        type: String,
        default: 'id',
    },
    dataField: {
        type: String,
        default: 'data',
    },
    lastPageField: {
        type: String,
        default: 'meta.last_page',
    },
    fastSearchParamName: {
        type: String,
        default: 'fast_search',
    },
    pageParamName: {
        type: String,
        default: '__page__',
    },
    perPageParamName: {
        type: String,
        default: '__per_page__',
    },
    otherParams: {
        type: Object,
        default: () => {},
    }
})

const loading = ref(false)
const options = ref([])
let page = 0
let search_value = ''
let last_page = null

const handleSearch = (value) => {
    options.value = []
    page = 0
    search_value = value
    last_page = null
    getList()
}

const handleDropdownReachBottom = () => {
    if (loading.value) {
        return
    }
    if (!props.pagination) {
        return
    }
    if (last_page && page >= last_page) {
        return
    }
    getList()
}

const getList = () => {
    if (!props.url) {
        return
    }
    page++
    loading.value = true
    const params = {...props.otherParams};
    params[props.pageParamName] = page
    params[props.perPageParamName] = props.perPage
    params[props.fastSearchParamName] = search_value
    request.get(props.url, {
        params: params,
    }).then(res => {
        loading.value = false
        let res_data = _.get(res, props.dataField, []);
        last_page = _.get(res, props.lastPageField, null)
        res_data.forEach(item => {
            options.value.push({
                label: item[props.labelField],
                value: item[props.valueField],
            })
        })
    })
}

getList()


</script>