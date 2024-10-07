<template>
    <div id="page_content">
        <section class="blog_area">
            <div class="container">
                <div class="row">
                    <div class="order-md-2 col-md-3 ">
                        <div class="blog_sidebar">
                            <div class="sidebar_inner" v-if="news.length > 0">
                                <h2>{{ trans('common.index.recent_posts') }}</h2>
                                <template v-for="(singleNews, i) in news">
                                    <div class="recent-post" :key="'single_news_'+i" v-if="i <= 10">
                                        <h2>{{ dateFormat(singleNews.created_at, 'M') }}</h2>
                                        <p>{{ dateFormat(singleNews.created_at, 'MMM YYYY') }}</p>
                                        <router-link :to="{ name:'single_news', params:{ slug: singleNews.slug }}">
                                            <h3><a href="#">{{ singleNews.title }}</a></h3>
                                            <img :src="singleNews.thumbs" alt="">
                                        </router-link>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">

                        <div class="blog_left" v-for="(newsItem, i) in news" :key="'news_'+i">
                            <div class="blog_left_inner">
                                <div class="top_img">
                                    <router-link :to="{ name:'single_news', params:{ slug:newsItem.slug }}">
                                        <img :src="newsItem.cover" alt="" class="width_full">
                                    </router-link>
                                    <div class="calender">
                                        <h2>{{ dateFormat(newsItem.created_at, 'DD') }}</h2>
                                        <p>{{ dateFormat(newsItem.created_at, 'MMMM YYYY') }}</p>
                                    </div>
                                </div>
                                <h3>{{ newsItem.title  }}</h3>
                                <ul class="author">
                                    <li>{{ dateFormat(newsItem.created_at, 'MMMM Do YYYY, h:mm:ss a') }} </li>
                                </ul>
                                <p>
                                    {{ newsItem['summary'] }}
                                </p>

                                <div class="bottom_link">
                                    <router-link :to="{ name:'single_news', params:{ slug: newsItem.slug }}" class="common_btn">
                                        {{ trans('common.index.learn_more') }} <i class="lni lni-arrow-right"></i>
                                    </router-link>
                                    <ul>
                                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                    </ul>
                                </div>
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
            news: []
        }
    },
    created() {
        axios.get('/api/news').then((response) => {
            this.news = response.data.data;
        });
    },
    methods: {
        dateFormat(value = null, format = null){
            if (value && format) {
                let date = new Date(value)
                return moment(date).format(format)
            }
        }
    },
}
</script>
