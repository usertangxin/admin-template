import {defineStore} from 'pinia'
import { computed, ref, watch } from 'vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()

const useDictStore = defineStore('dict', () => {
    const System_Dict_Hash = computed(() => page?.props?.system_dict_hash)

    const System_Dict_Group_Hash = computed(() => page?.props?.system_dict_group_hash)

    const dict_list = ref(JSON.parse(window.localStorage.getItem('dict_list') ?? '[]'))
    const dict_group_list = ref(JSON.parse(window.localStorage.getItem('dict_group_list') ?? '[]'))

    watch([System_Dict_Hash, System_Dict_Group_Hash], () => {
        if (
            System_Dict_Hash.value != window.localStorage.getItem('system_dict_hash')
            || System_Dict_Group_Hash.value != window.localStorage.getItem('system_dict_group_hash')
        ) {

            request.get('/web/admin/SystemDict/index').then(res => {
                if (res.code === 0) {
                    dict_list.value = res.data.list
                    dict_group_list.value = res.data.group_list
                    window.localStorage.setItem('dict_list', JSON.stringify(res.data.list))
                    window.localStorage.setItem('dict_group_list', JSON.stringify(res.data.group_list))
                    window.localStorage.setItem('system_dict_hash', System_Dict_Hash.value)
                    window.localStorage.setItem('system_dict_group_hash', System_Dict_Group_Hash.value)
                }
            })
        }
    })

    const dict_group_map = computed(() => {
        const map = {}
        dict_group_list.value.forEach(item => {
            map[item.code] = item
        })
        return map
    })

    const dict_map = computed(() => {
        const map = {}
        dict_list.value.forEach(item => {
            map[item.key] = item
        })
        return map
    })

    const dict_group_by_code = computed(() => {
        const map = {}
        dict_list.value.forEach(item => {
            if (!map[item.code]) {
                map[item.code] = []
            }
            map[item.code].push(item)
        })
        return map
    })

    return {
        dict_list,
        dict_group_list,
        dict_group_map,
        dict_map,
        dict_group_by_code,
    }
})

export default useDictStore
