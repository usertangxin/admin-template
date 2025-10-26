<template>
    <a-input v-model="value" readonly placeholder="{{ $t('map.select') }}">
        <template #suffix>
            <a-button class="-mr-3" type="primary" status="normal" @click="modalVisible = true">{{ $t('map.selectButton') }}</a-button>
        </template>
    </a-input>
    <a-modal v-model:visible="modalVisible" @open="handleOpen" @close="handleClose" :width="1000">
        <template #title>{{ $t('map.modalTitle') }}</template>
        <div>
            <a-alert>{{ $t('map.addressTip') }}</a-alert>
            <a-row class=" mt-3" :gutter="16">
                <a-col :span="12">
                    <a-input-search v-model="value" :loading="searchLoading" @search="handleSearch" :placeholder="$t('map.searchPlaceholder')"
                        allow-search :filter-option="false" multiple search-button></a-input-search>
                </a-col>
                <a-col :span="6">
                    <a-input v-model="latLng.lng" readonly>
                        <template #prefix>
                            {{ $t('map.longitude') }}
                        </template>
                    </a-input>
                </a-col>
                <a-col :span="6">
                    <a-input v-model="latLng.lat" readonly>
                        <template #prefix>
                            {{ $t('map.latitude') }}
                        </template>
                    </a-input>
                </a-col>
            </a-row>
        </div>
        <div class="w-full h-128 mt-5 flex justify-center items-center">
            <template v-if="config.key && showMap">
                <tlbs-map class="w-full h-full" ref="map" :api-key="config.key" :center="latLng"
                    :minZoom="options.minZoom" :maxZoom="options.maxZoom" @click="handleMapClick">
                    <tlbs-multi-marker :styles="styles" :options="options" :geometries="geometries" />
                </tlbs-map>
            </template>
            <a-spin v-else :size="32" />
        </div>
    </a-modal>
</template>

<script setup>
import { computed, isVNode, onMounted, ref, watch, watchEffect } from 'vue';
import { jsonp } from 'vue-jsonp'
import { Message } from "@arco-design/web-vue";
import { t } from '/Modules/Admin/resources/assets/js/i18n'

const value = defineModel()
const modalVisible = ref(false)
const searchLoading = ref(false)
const config = ref({});
const showMap = ref(false)
const latLng = defineModel('latLng', {
    default: {
        lat: '25.03813238725407',
        lng: '102.71969192233837',
    }
})
const pcd = defineModel('pcd', {
    default: {
        province: '',
        city: '',
        district: '',
    }
})

const styles = {
    marker: {
        width: 20,
        height: 30,
        anchor: { x: 10, y: 30 },
    },
}
const options = {
    minZoom: 3,
    maxZoom: 20,
}

onMounted(() => {
    request.get('/web/map/tencent-config').then(res => {
        config.value = res.data
    })
})

const handleSearch = async (value) => {
    console.log(value)
    if (!value) {
        Message.error(t('map.inputAddressError'))
        return
    }
    searchLoading.value = true
    await new Promise((resolve) => {
        jsonp('https://apis.map.qq.com/ws/geocoder/v1/', {
            key: config.value.key,
            address: encodeURIComponent(value),
            output: 'jsonp'
        }).then(res => {
            const result = res.result
            latLng.value = {
                lat: result.location.lat,
                lng: result.location.lng
            }
            pcd.value.province = result.address_components.province
            pcd.value.city = result.address_components.city
            pcd.value.district = result.address_components.district
            resolve()
        }).finally(() => {
            searchLoading.value = false
        })
    })
    searchLoading.value = false
}

const handleMapClick = (e) => {
    latLng.value = {
        lat: e.latLng.lat,
        lng: e.latLng.lng,
    }
    const lat = Number(e.latLng.lat).toFixed(6)
    const lng = Number(e.latLng.lng).toFixed(6)
    jsonp('https://apis.map.qq.com/ws/geocoder/v1/', {
        key: config.value.key,
        location: `${lat},${lng}`,
        output: 'jsonp'
    }).then(res => {
        const result = res.result
        value.value = result.address + result.formatted_addresses.recommend
        pcd.value.province = result.address_component.province
        pcd.value.city = result.address_component.city
        pcd.value.district = result.address_component.district
    })
}

const handleOpen = () => {
    if (!latLng.value || !latLng.value.lng || !latLng.value.lat) {
        latLng.value = {
            lat: '25.03813238725407',
            lng: '102.71969192233837',
        }
    }
    showMap.value = true
}

const handleClose = () => {
    showMap.value = false
}

// const geometries = [
//     { styleId: 'marker', position: { lat: 40.040476630400114, lng: 116.27375409811975 } },
// ]

const geometries = computed(() => {
    if (!latLng.value.lat || !latLng.value.lng) {
        return [];
    }
    return [
        {
            styleId: 'marker', position: { lat: latLng.value.lat, lng: latLng.value.lng }
        }
    ];
})

</script>