import { computed, reactive, ref, provide, inject } from 'vue'
import { usePage, router } from '@inertiajs/vue3'
const page = usePage()

export function useIndexShareStore() {
    const searchQuery = reactive({
        page: page.props.current_page,
        per_page: page.props.per_page,
    })
    const columns = ref([])
    const actionColumn = ref({
        title: '操作',
        width: 120,
        fixed: 'right',
    })
    const listData = computed(() => {
        return page.props.data
    })

    const fetchListData = () => {
        router.visit('?' + Object.keys(searchQuery).map((item) => {
            return item + '=' + searchQuery[item]
        }).join('&'), {
            preserveState: true
        })
    }

    const resetSearchQuery = () => {
        searchQuery.page = 1
        fetchListData()
    }

    const setSearchQuery = (query) => {
        for (const key in query) {
            searchQuery[key] = query[key]
        }
    }

    const setSearchQueryItem = (key, value) => {
        searchQuery[key] = value
    }

    const getSearchQueryItem = (key) => {
        return searchQuery[key]
    }

    const getSearchQuery = () => {
        return searchQuery
    }

    return {
        searchQuery,
        columns,
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
    provide('indexShareStore', store)
    return store
}

/**
 * 
 * @returns useIndexShareStore
 */
export function useInjectIndexShareStore() {
    return inject('indexShareStore')
}