import { computed, reactive, ref, provide, inject, watch } from 'vue'
import { usePage, router, useRemember } from '@inertiajs/vue3'
import _ from 'lodash'

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
        title: '操作',
        width: 120,
        fixed: 'right',
        slotName: 'action-column',
    })
    /** 表格的数据 */
    const listData = computed(() => {
        return page.props.data
    })

    /** 刷新表格数据 */
    const fetchListData = () => {
        innerFetchListData.value && router.get('', _.pickBy(searchQuery.value, (item, key) => {
            return item !== (void 0)
        }), { preserveState: true, })
    }

    /** 重置搜索参数 */
    const resetSearchQuery = () => {
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
        listData,
        fetchListData,
        resetSearchQuery,
        setSearchQuery,
        setSearchQueryItem,
        getSearchQueryItem,
        getSearchQuery,
    }
}

export function provideIndexShareStore(props) {
    const store = useIndexShareStore()
    if (props.columns && router.restore('indexShareColumns' + window.location.href.split('?')[0])?.length < 1) {
        store.columns.value = props.columns
    }
    props.actionColumn !== undefined && (store.actionColumn.value = props.actionColumn)
    props.innerFetchListData !== undefined && (store.innerFetchListData.value = props.innerFetchListData)
    provide('indexShareStore', store)
    return store
}


export function useInjectIndexShareStore() {
    return inject('indexShareStore')
}