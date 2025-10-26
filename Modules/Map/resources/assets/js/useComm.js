import mapAmap from "./components/map-amap.vue"
import mapTencent from "./components/map-tencent.vue"

const useComm = {
  install(app, options) {
    app.component('map-amap', mapAmap)
    app.component('map-tencent', mapTencent)
  }
}

export default useComm
