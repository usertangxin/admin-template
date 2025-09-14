import { compile } from "vue";

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
        return () => compile(props.html)({
            params: props.params
        })
    },
}