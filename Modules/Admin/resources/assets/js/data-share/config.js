import { computed, ref, watch } from 'vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()

const System_Config_Hash = computed(() => page?.props?.system_config_hash)

const System_Config_Group_Hash = computed(() => page?.props?.system_config_group_hash)

const config_list = ref(JSON.parse(window.localStorage.getItem('config_list') ?? '[]'))
const config_group_list = ref(JSON.parse(window.localStorage.getItem('config_group_list') ?? '[]'))

watch([System_Config_Hash, System_Config_Group_Hash], () => {
    if (
        System_Config_Hash.value != window.localStorage.getItem('system_config_hash')
        || System_Config_Group_Hash.value != window.localStorage.getItem('system_config_group_hash')
    ) {

        axios.get('/web/admin/SystemConfig/index').then(res => {
            if (res.code === 0) {
                config_list.value = res.data.config_list
                config_group_list.value = res.data.config_group_list
                window.localStorage.setItem('config_list', JSON.stringify(config_list.value))
                window.localStorage.setItem('config_group_list', JSON.stringify(config_group_list.value))
                window.localStorage.setItem('system_config_hash', System_Config_Hash.value)
                window.localStorage.setItem('system_config_group_hash', System_Config_Group_Hash.value)
            }
        })
    }
})

const config_group_map = computed(() => {
    const map = {}
    config_group_list.value.forEach(item => {
        map[item.code] = item
    })
    return map
})

const config_map = computed(() => {
    const map = {}
    config_list.value.forEach(item => {
        map[item.key] = item
    })
    return map
})

const config_group_by_code = computed(() => {
    const map = {}
    config_list.value.forEach(item => {
        if (!map[item.code]) {
            map[item.code] = []
        }
        map[item.code].push(item)
    })
    return map
})

export {
    config_list,
    config_group_list,
    config_group_map,
    config_map,
    config_group_by_code,
}
