export default {
    data() {
        return {
            loading: false,
            errors: null,
        }
    },
    methods: {
        errorFor(field) {
            return this.errors != null && this.errors[field] ? this.errors[field] : null;
        }
    }
}
