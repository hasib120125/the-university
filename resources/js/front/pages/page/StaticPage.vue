<template>
    <div id="page_content">
        <section class="common_banner common_margin">
            <h1 v-if="page">{{ page.title }}</h1>
        </section>

        <section class="introduction_area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div v-if="page" v-html="page.content"></div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</template>

<script>
export default {
    data() {
        return {
            page: null,
        }
    },
    watch: {
        $route() {
            this.loadPage();
        }
    },
    created() {
        this.loadPage();
    },
    methods: {
        loadPage() {
            axios.get('/api/static-page/'+this.$route.params.slug)
                .then((response) => this.page = response.data.data)
                .catch(() => this.$router.push({name: 'main_menu_page', params: {menu: this.$route.params.slug}}))
        }
    }
}
</script>
