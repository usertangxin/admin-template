import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()

const dict_list = computed(() => page.props.dict_list)
const dict_group_list = computed(() => page.props.dict_group_list)
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

const dict_value_group_by_code = computed(() => {
    const map = {}
    dict_list.value.forEach(item => {
        if (!map[item.code]) {
            map[item.code] = []
        }
        map[item.code].push(item)
    })
    return map
})

export {
    dict_list,
    dict_group_list,
    dict_group_map,
    dict_map,
    dict_value_group_by_code,
}
