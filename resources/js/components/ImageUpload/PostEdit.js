export default {
    props: ['edit'],
    data() {
        return {
            editing: false
        }
    },
    created() {
        this.edit ? this.loadForm() : null;
    },
    methods: {
        loadForm() {
            this.form = this.edit
            this.hasImage = true
            this.editing = true
        }
    }
}
