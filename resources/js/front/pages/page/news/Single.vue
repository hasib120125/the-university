<template>
    <div id="page_content">
        <section class="blog_area">
            <div class="container">
                <div class="row">
                    <div class="order-md-2 col-md-3 ">
                        <div class="blog_sidebar">
                            <div class="sidebar_inner">
                                <h2>{{ trans('common.index.recent_posts') }}</h2>
                                <template v-for="(singleNews, i) in news">
                                    <div class="recent-post" :key="'single_news_'+i" v-if="i <= 10">
                                        <h2>{{ dateFormat(singleNews.created_at, 'M') }}</h2>
                                        <p>{{ dateFormat(singleNews.created_at, 'MMM YYYY') }}</p>
                                        <router-link :to="{ name:'single_news', params:{ slug:singleNews.slug }}">
                                            <h3><a href="#">{{ singleNews.title }}</a></h3>
                                            <img :src="singleNews.thumbs" alt="">
                                        </router-link>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="blog_left blog_single">
                            <div class="blog_left_inner">
                                <div class="top_img">
                                    <img :src="currentNews.cover" alt="" class="width_full">
                                    <div class="calender">
                                        <h2>{{ dateFormat(currentNews.created_at, 'DD') }}</h2>
                                        <p>{{ dateFormat(currentNews.created_at, 'MMMM YYYY') }}</p>
                                    </div>
                                </div>
                                <h3>{{ currentNews.title  }}</h3>
                                <ul class="author">
                                    <li> {{ dateFormat(currentNews.created_at, 'MMMM Do YYYY, h:mm:ss a') }} </li>
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

export default {
    data(){
        return {
            loading: false,
            currentNews: {},
            news: {}
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
