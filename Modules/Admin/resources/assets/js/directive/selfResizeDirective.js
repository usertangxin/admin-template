// 在Vue中定义一个监听元素大小变化的指令
export default {
    // 指令名称，使用时为 v-self-resize
    name: 'selfResize',

    // 指令的定义
    directive: {
        // 当被绑定的元素插入到DOM中时
        mounted(el, binding) {
            // 初始化ResizeObserver
            const observer = new ResizeObserver(entries => {
                // 执行绑定的方法，并传入元素大小信息
                binding.value({
                    width: el.offsetWidth,
                    height: el.offsetHeight,
                    entries
                });
            });

            // 开始观察目标元素
            observer.observe(el);

            // 将observer存储在元素上，以便在解绑时停止观察
            el._resizeObserver = observer;
        },

        // 当指令与元素解绑时
        unmounted(el) {
            // 停止观察
            if (el._resizeObserver) {
                el._resizeObserver.unobserve(el);
                // 清除引用
                delete el._resizeObserver;
            }
        }
    }
};
  