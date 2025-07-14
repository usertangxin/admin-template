import { computed, reactive, ref, provide, inject } from 'vue'
import { usePage, router } from '@inertiajs/vue3'

const page = usePage()

export function useIndexShareStore() {
    /** 搜索参数 */
    const searchQuery = reactive({
        page: page.props.current_page,
        per_page: page.props.per_page,
    })
    /** 内部是否调用fetchListData */
    const innerFetchListData = ref(true)
    /** 表格的列 */
    const columns = ref([])
    /** 操作列 */
    const actionColumn = ref({
        title: '操作',
        width: 120,
        fixed: 'right',
    })
    /** 表格的数据 */
    const listData = computed(() => {
        return page.props.data
    })

    /** 刷新表格数据 */
    const fetchListData = () => {
        innerFetchListData.value && router.visit('?' + Object.keys(searchQuery).map((item) => {
            return item + '=' + searchQuery[item]
        }).join('&'), {
            preserveState: true
        })
    }

    /** 重置搜索参数 */
    const resetSearchQuery = () => {
        searchQuery.page = 1
        fetchListData()
    }

    /** 设置搜索参数 */
    const setSearchQuery = (query) => {
        for (const key in query) {
            searchQuery[key] = query[key]
        }
    }

    /** 设置搜索参数项 */
    const setSearchQueryItem = (key, value) => {
        searchQuery[key] = value
    }

    /** 获取搜索参数项 */
    const getSearchQueryItem = (key) => {
        return searchQuery[key]
    }

    /** 获取搜索参数 */
    const getSearchQuery = () => {
        return searchQuery
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
    props.columns && (store.columns = props.columns)
    props.actionColumn !== undefined && (store.actionColumn.value = props.actionColumn)
    props.innerFetchListData !== undefined && (store.innerFetchListData.value = props.innerFetchListData)
    provide('indexShareStore', store)
    return store
}


export function useInjectIndexShareStore() {
    return inject('indexShareStore')
}