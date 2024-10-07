<template>
    <div id="page_content">
        <section class="blog_area">
            <div class="container">
                <div class="row">
                    <Sidebar :news="news" />
                    <div class="col-md-9">
                        <div class="blog_left" v-for="(newsItem, i) in news" :key="'news_'+i">
                            <div class="blog_left_inner">
                                <div class="top_img">
                                    <router-link :to="'/community/news/'+newsItem.slug">
                                        <img :src="newsItem.cover" alt="" class="width_full">
                                    </router-link>
                                    <div class="calender">
                                        <h2>{{ dateFormat(newsItem.created_at_raw, 'DD') }}</h2>
                                        <p>{{ dateFormat(newsItem.created_at_raw, 'MMM YYYY') }}</p>
                                    </div>
                                </div>
                                <h3>{{ newsItem.title  }}</h3>
                                <ul class="author">
                                    <li>{{ dateFormat(newsItem.created_at_raw, 'MMMM Do YYYY, h:mm:ss a') }} </li>
                                </ul>
                                <p>
                                    {{ newsItem['summary'] }}
                                </p>

                                <div class="bottom_link">
                                    <router-link :to="'/community/news/'+newsItem.slug" class="common_btn">
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
import Sidebar from './Sidebar.vue'

export default {
    components : {
        Sidebar
    },
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
