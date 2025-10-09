import dictGroupSelect from "./components/dict-group-select.vue"

const useComm = {
  install(app, options) {
    app.component('dict-group-select', dictGroupSelect)
  }
}

export default useComm
