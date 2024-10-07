<template>
    <div id="page_content">
        <section class="blog_area">
            <div class="container">
                <div class="row">
                    <Sidebar :news="news" />
                    <div class="col-md-9">
                        <div class="blog_left blog_single">
                            <div class="blog_left_inner">
                                <div class="top_img">
                                    <img :src="currentNews.cover" alt="" class="width_full">
                                    <div class="calender">
                                        <h2>{{ dateFormat(currentNews.created_at_raw, 'DD') }}</h2>
                                        <p>{{ dateFormat(currentNews.created_at_raw, 'MMM YYYY') }}</p>
                                    </div>
                                </div>
                                <h3>{{ currentNews.title  }}</h3>
                                <ul class="author">
                                    <li> {{ dateFormat(currentNews.created_at_raw, 'MMMM Do YYYY, h:mm:ss a') }} </li>
                                </ul>
                                <div class="blog_single_inner">
                                    <p><b> {{ currentNews.summary }} </b></p>
                                </div>
                                <div class="blog_single_inner" v-html="currentNews.content"></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</template>
<script>

import moment from 'moment';
import Sidebar from './Sidebar.vue'

export default {
     components : {
        Sidebar
    },
    data(){
        return {
            loading: false,
            currentNews: {},
            news: []
        }
    },
    watch: {
        $route() {
            this.loadData();
        }
    },
    created() {
        this.loadData();
    },
    methods: {
        loadData() {
            this.loading = true;
            $("#preloader").fadeIn("fast");

            axios.get('/api/news/'+ this.$route.params.slug, {params: {content: true}} ).then((response) => {
                this.currentNews = response.data.data;
                $("#preloader").fadeOut("fast");
            }).finally(() => this.loading = false);

            axios.get('/api/news').then((response) => {
                this.news = response.data.data
            })
        },
        dateFormat(value = null, format = null){
            if (value && format) {
                let date = new Date(value)
                return moment(date).format(format)
            }
        }
    },
}
</script>
