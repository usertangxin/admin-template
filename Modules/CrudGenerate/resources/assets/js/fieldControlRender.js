import * as Vue from 'vue';
import { compile } from "@vue/compiler-dom";

export default {
    props: {
        html: {
            type: String,
            default: ''
        },
        params: {
            type: Object,
            default: () => ({})
        }
    },
    setup(props) {
        return () => {
            const { code } = compile(props.html)
            const render = new Function('Vue', code)(Vue);
            return render({
                params: props.params
            })
        }
    },
}