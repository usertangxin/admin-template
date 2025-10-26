<template>
  <a-input v-model="value" readonly :placeholder="$t('map.select')">
    <template #suffix>
      <a-button class="-mr-3" type="primary" status="normal" @click="modalVisible = true">{{ $t('map.selectButton') }}</a-button>
    </template>
  </a-input>
  <a-modal v-model:visible="modalVisible" @open="handleOpen" @close="handleClose" :width="1000">
    <template #title>{{ $t('map.modalTitle') }}</template>
    <div>
      <a-alert>
        {{ $t('map.addressTip') }}
      </a-alert>
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
        <div id="container" style="height: 100%;width: 100%;"></div>
      </template>
      <a-spin v-else :size="32" />
    </div>
  </a-modal>
</template>

<script setup>
import AMapLoader from "@amap/amap-jsapi-loader";
import { onMounted, onUnmounted, ref, watch, watchEffect } from "vue";
import { Message } from "@arco-design/web-vue";
import { t } from '/Modules/Admin/resources/assets/js/i18n'

let map = null;
let geocoder = null;
let marker = null;

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


const handleSearch = async (value) => {
  // console.log(value)
  if (!value) {
    Message.error(t('map.inputAddressError'))
    return
  }
  searchLoading.value = true
  geocoder.getLocation(value, function (status, result) {
    if (status === "complete" && result.info === "OK") {
      // result中对应详细地理坐标信息
      searchLoading.value = false
      // console.log(result);
      const geocodes = result.geocodes
      if (geocodes.length < 1) {
        Message.error(t('map.addressNotFoundError'));
        return
      }
      const addressComponent = result.geocodes[0].addressComponent
      const location = result.geocodes[0].location
      latLng.value = {
        lat: location.lat,
        lng: location.lng
      }
      pcd.value.province = addressComponent.province
      pcd.value.city = addressComponent.city
      pcd.value.district = addressComponent.district
    }
  });
}

const handleOpen = () => {
  if (!latLng.value || !latLng.value.lng || !latLng.value.lat) {
    latLng.value = {
      lat: '25.03813238725407',
      lng: '102.71969192233837',
    }
  }
  showMap.value = true

  window._AMapSecurityConfig = {
    serviceHost: '/web/map/_AMapService',
  };
  AMapLoader.load({
    key: config.value.key, // 申请好的Web端开发者Key，首次调用 load 时必填
    version: "2.0", // 指定要加载的 JSAPI 的版本，缺省时默认为 1.4.15
    plugins: ["AMap.Scale"], //需要使用的的插件列表，如比例尺'AMap.Scale'，支持添加多个如：['...','...']
  })
    .then((AMap) => {
      AMap.plugin("AMap.Geocoder", function () {
        geocoder = new AMap.Geocoder({})
      })
      map = new AMap.Map("container", {
        zoom: 15, // 初始化地图级别
        center: [latLng.value.lng, latLng.value.lat],
      });

      marker = new AMap.Marker({
        icon: new AMap.Icon({
          image: '//a.amap.com/jsapi_demos/static/demo-center/icons/poi-marker-red.png',
          size: new AMap.Size(20, 28),
          imageSize: new AMap.Size(20, 28),
        }),
        offset: new AMap.Pixel(-11, -27),
        position: new AMap.LngLat(latLng.value.lng, latLng.value.lat),
      });
      map.add(marker)

      map.on('click', function (ev) {
        const lnglat = ev.lnglat;
        latLng.value = {
          lat: lnglat.lat,
          lng: lnglat.lng
        }

        geocoder.getAddress([lnglat.lng, lnglat.lat], function (status, result) {
          if (status === "complete" && result.info === "OK") {
            // result为对应的地理位置详细信息
            // console.log(result);
            value.value = result.regeocode.formattedAddress
            pcd.value.province = result.regeocode.addressComponent.province
            pcd.value.city = result.regeocode.addressComponent.city
            pcd.value.district = result.regeocode.addressComponent.district
          }
        });
      })

    })
    .catch((e) => {
      console.log(e);
    });

}

const handleClose = () => {
  showMap.value = false
}

watch(() => latLng.value, () => {
  marker && marker.setPosition(new AMap.LngLat(latLng.value.lng, latLng.value.lat))
});

onMounted(() => {
  request.get('/web/map/amap-config').then(res => {
    config.value = res.data
  })
});

onUnmounted(() => {
  map?.destroy();
});

</script>

<style>
.marker {
  position: absolute;
  top: -20px;
  right: -118px;
  color: #fff;
  padding: 4px 10px;
  box-shadow: 1px 1px 1px rgba(10, 10, 10, .2);
  white-space: nowrap;
  font-size: 12px;
  font-family: "";
  background-color: #25A5F7;
  border-radius: 3px;
}
</style>