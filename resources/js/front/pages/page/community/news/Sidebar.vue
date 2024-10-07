<template>
    <div class="order-md-2 col-md-3 ">
        <div class="blog_sidebar">
            <div class="sidebar_inner" v-if="news.length > 0">
                <h2>{{ trans('common.index.recent_posts') }}</h2>
                <template v-for="(singleNews, i) in news">
                    <div class="recent-post" :key="'single_news_'+i" v-if="i <= 10">
                        <p>{{ dateFormat(singleNews.created_at_raw, 'MMMM Do YYYY') }}</p>
                        <router-link :to="'/community/news/'+singleNews.slug">
                            <h3>{{ singleNews.title }}</h3>
                            <img :src="singleNews.thumbs" alt="">
                        </router-link>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>
<script>

import moment from 'moment';

export default {
    props: {
        news: Array,
    },
    data(){
        return {
            
        }
    },
    created() {
        
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
