import Vue from 'vue'

/**
 * 列表页面行为共享类
 * 用于在列表页面行为操作之间共享数据和行为
 */
export class IndexBehaviorShare {
    constructor() {
        this.eventBus = new Vue()
        this.tableBehaviorExport = {}
        this.searchFormBehaviorExport = {}
    }

    /**
     * 监听表格刷新事件
     * @param {Function} callback 
     */
    onTableRefresh(callback) {
        this.eventBus.$on('tableRefresh', callback)
    }

    /**
     * 触发表格刷新事件
     */
    triggerTableRefresh() {
        this.eventBus.$emit('tableRefresh')
    }

    /**
     * 注册表格共享行为
     * @param  {...any} properties 
     */
    registerTableBehavior(...properties) {
        this.tableBehaviorExport = {
            ...this.tableBehaviorExport,
            ...properties
        }
    }

    /**
     * 获取表格共享行为
     * @returns 
     */
    getTableBehavior() {
        return this.tableBehaviorExport
    }


    /**
     * 监听搜索表单提交事件
     * @param {Function} callback 
     */
    onSearchFormSubmit(callback) {
        this.eventBus.$on('searchFormSubmit', callback)
    }

    /**
     * 触发搜索表单提交事件
     */
    triggerSearchFormSubmit() {
        this.eventBus.$emit('searchFormSubmit')
    }

    /**
     * 监听搜索表单重置事件
     * @param {Function} callback 
     */
    onSearchFormReset(callback) {
        this.eventBus.$on('searchFormReset', callback)
    }

    /**
     * 触发搜索表单重置事件
     */
    triggerSearchFormReset() {
        this.eventBus.$emit('searchFormReset')
    }

    /**
     * 获取搜索表单共享数据
     * @returns 
     */
    getSearchFormData() {
        return this.searchFormBehaviorExport.getSearchFormData()
    }

    /**
     * 注册搜索表单共享行为
     * @param  {...any} properties 
     */
    registerSearchFormBehavior(...properties) {
        this.searchFormBehaviorExport = {
            ...this.searchFormBehaviorExport,
            ...properties
        }
    }

}