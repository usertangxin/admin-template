import { computed, reactive, ref, provide, inject, watch } from 'vue'
import { usePage, router, useRemember } from '@inertiajs/vue3'
import _ from 'lodash'
import qs from 'qs'
import { __ } from '/Modules/Admin/resources/assets/js/i18n'


const page = usePage()

export function useIndexShareStore() {
    /** 搜索参数 */
    const searchQuery = useRemember({
        __page__: page.props.meta?.current_page ?? 0,
        __per_page__: page.props.meta?.per_page ?? 0,
        fast_search: '',
    }, 'indexShareSearchQuery' + window.location.href.split('?')[0])
    /** 内部是否调用fetchListData */
    const innerFetchListData = ref(true)
    /** 表格的列 */
    const columns = useRemember([], 'indexShareColumns' + window.location.href.split('?')[0])
    /** 操作列 */
    const actionColumn = ref({
        title: __('global.action'),
        // width: 120,
        fixed: 'right',
        slotName: 'action-column',
    })
    /** 表格的数据 */
    const listData = computed(() => {
        return page.props.data
    })
    /** 选中的行 */
    const selectedKeys = useRemember([], 'indexShareSelectedKeys' + window.location.href.split('?')[0])

    /** 刷新表格数据 */
    const fetchListData = () => {
        let urlSearch = qs.parse(location.search, { ignoreQueryPrefix: true })
        innerFetchListData.value && router.get('', _.pickBy(_.assign({}, urlSearch, JSON.parse(JSON.stringify(searchQuery.value)),), (item, key) => {
            return item !== (void 0)
        }), { preserveState: true, })
    }

    const toPage1 = () => {
        searchQuery.value.__page__ = 1
        fetchListData()
    }

    /** 设置搜索参数 */
    const setSearchQuery = (query) => {
        for (const key in query) {
            searchQuery.value[key] = query[key]
        }
    }

    /** 设置搜索参数项 */
    const setSearchQueryItem = (key, value) => {
        searchQuery.value[key] = value
    }

    /** 删除搜索参数项 */
    const removeSearchQueryItem = (key) => {
        delete searchQuery.value[key]
        // 如果url中含有key的参数，就删除
        const urlSearch = qs.parse(location.search, { ignoreQueryPrefix: true })
        if (urlSearch[key]) {
            delete urlSearch[key]
            const newSearch = qs.stringify(urlSearch, { addQueryPrefix: true })
            window.history.replaceState({}, '', newSearch ? `${location.pathname}${newSearch}` : location.pathname)
        }
    }

    /** 获取搜索参数项 */
    const getSearchQueryItem = (key) => {
        return searchQuery.value[key]
    }

    /** 获取搜索参数 */
    const getSearchQuery = () => {
        return searchQuery.value
    }


    return {
        searchQuery,
        columns,
        innerFetchListData,
        actionColumn,
        selectedKeys,
        listData,
        fetchListData,
        toPage1,
        setSearchQuery,
        setSearchQueryItem,
        removeSearchQueryItem,
        getSearchQueryItem,
        getSearchQuery,
    }
}

export function provideIndexShareStore(props = {}) {
    const store = reactive(useIndexShareStore())
    if (props.columns && router.restore('indexShareColumns' + window.location.href.split('?')[0])?.length < 1) {
        store.columns = props.columns
    }
    if (props.searchQuery) {
        _.merge(store.searchQuery, props.searchQuery)
    }
    props.actionColumn !== undefined && (store.actionColumn = props.actionColumn)
    props.innerFetchListData !== undefined && (store.innerFetchListData = props.innerFetchListData)
    provide('indexShareStore', store)
    return store
}


export function useInjectIndexShareStore() {
    return inject('indexShareStore')
}