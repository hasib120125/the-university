<template>
    <div id="homePage">
        <section class="banner_area banner_area_v2">
            <div id="homeplayer"></div>
            <div class="layer"></div>
            <!-- <div class="text">
                <h2 v-if="setting">{{ setting.university_name }}</h2>
                <button class="btn common_btn width_auto">{{ trans('front.home.read_more') }}</button>
            </div> -->
            <!-- <div class="banner_slider">
                <div class="banner_slider_inner">
                    <div id="homeplayer"></div>
                </div>
                <div class="banner_slider_inner">
                    <div id="homeplayer"></div>
                </div>
            </div> -->
        </section>

        <section class="home_news_v2">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main_title_v2">
                            <h2>{{ trans('front.home.latest_news') }}</h2>
                        </div>
                    </div>
                </div>
                <div class="row margin_7">
                    <div class="col-md-3 padding_7" v-for="(singleNews, index) in news" :key="'news_'+index">
                        <router-link :to="'/community/news/' + singleNews.slug">
                            <div class="home_news_inner_wrap">
                                <div class="home_news_inner">
                                    <img :src="singleNews.cover" alt="" class="img-fluid">
                                </div>
                                <div class="text">
                                    <h2>{{ singleNews.title }}</h2>
                                    <p>{{ singleNews.summary }}</p>
                                </div>
                            </div>
                        </router-link>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="d_flex_center">
                            <router-link :to="'/community/news'" class="btn common_btn width_auto ">{{ trans('front.home.read_more') }}</router-link>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="home_department">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main_title_v2">
                            <h2>{{ trans('front.home.departments.title') }}</h2>
                        </div>
                    </div>
                </div>
                <div class="row margin_0">
                    <div class="col-md-4 padding_0">
                        <div class="inner">
                            <!-- <img src="/images/featured_1.png" alt="" class="img-fluid width_full"> -->
                            <router-link to="/department-guide/ministry-of-ministry">
                                 <div class="text">
                                        <h2>{{ trans('front.home.departments.0.title') }}</h2>
                                        <p>{{ trans('front.home.departments.0.desc') }}</p>
                                 </div>
                            </router-link>
                        </div>
                    </div>
                    <div class="col-md-4 padding_0">
                        <div class="inner">
                            <!-- <img src="/images/featured_1.png" alt="" class="img-fluid width_full"> -->
                            <router-link to="/department-guide/department-of-missiology">
                                 <div class="text">
                                        <h2>{{ trans('front.home.departments.1.title') }}</h2>
                                        <p>{{ trans('front.home.departments.1.desc') }}</p>
                                 </div>
                            </router-link>
                        </div>
                    </div>
                    <div class="col-md-4 padding_0">
                        <div class="inner">
                            <!-- <img src="/images/featured_1.png" alt="" class="img-fluid width_full"> -->
                            <router-link to="/department-guide/department-of-pastoral-music">
                                 <div class="text">
                                        <h2>{{ trans('front.home.departments.2.title') }}</h2>
                                        <p>{{ trans('front.home.departments.2.desc') }}</p>
                                 </div>
                            </router-link>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section class="home_video_v2">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main_title_v2">
                            <h2>{{ trans('front.home.sample_lecture.title') }}</h2>
                            <!-- <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cum, eaque!</p> -->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="home_video_main_slide">
                            <div class="single_video">
                                <div id="single_video"></div>
                            </div>
                        </div>
                        <div class="home_video_thumbnail_wrap">
                            <div class="single_video_thumbnail">
                                <div class="inner" v-for="(sampleLecture, index) in sampleLectures" :key="'sample-video' + index" @click="initSampleLectureVideo(index)">
                                    <img :src="sampleLecture.thumbs" alt="" class="img-fluid width_full">
                                    <i class="fas fa-play"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="row">
                    <div class="col-12">
                        <div class="d_flex_center">
                            <button class="btn common_btn width_auto ">Read More</button>
                        </div>
                    </div>
                </div> -->
            </div>
        </section>

        <section class="upcoming_event">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main_title_v2">
                            <h2>{{ trans('front.home.upcoming_event') }}</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="upcoming_event_wrap">
                            <div class="upcoming_event_slide">
                                <div class="inner" v-for="(seminar, index) in seminars" :key="'seminar' + index">
                                    <router-link :to="'community/offline-seminar/' + index">
                                    <div class="img">
                                        <img :src="seminar.preview_image" alt="" class="img-fluid width_full">
                                    </div>
                                        <div class="text">
                                            <h2>{{ index+1 }}</h2>
                                            <p>{{ seminar.title }}</p>
                                        </div>
                                    </router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="d_flex_center">
                            <router-link :to="'/community/offline-seminar'" class="btn common_btn width_auto ">{{ trans('front.home.read_more') }}</router-link>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="home_social_area_v2">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main_title_v2">
                            <h2>{{ trans('front.home.gallery') }}</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="home_social_wrap">
                            <div class="left" v-if="galleries.length">
                                <div class="content">
                                    <router-link :to="'/community/gallery/'+ galleries[0].id">
                                        <div class="img">
                                            <img :src="galleries[0].images[0].thumbs" alt="">
                                        </div>
                                    </router-link>
                                </div>
                            </div>
                            <div class="right" v-if="galleries.length > 1">
                                <div class="content" v-for="(gallery, index) in galleries" :key="'gallery_'+index" v-if="index">
                                    <router-link :to="'/community/gallery/'+ gallery.id">
                                        <div class="img">
                                            <img :src="gallery.images[0].thumbs" alt="">
                                        </div>
                                    </router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-dialog custom_modal_dialog" :style="{top: popup.top+'%', left: popup.left+'%'}" v-for="(popup, index) in popups" :key="'popup_'+index">
                    <div class="modal-content">
                        <div class="modal-body popup-body">
                            <div v-html="popup.content" class="welcome_modal_wrap"></div>
                            <div class="close_btn d_flex_btwn pl_5 pr_5">
                                <div class="form_checkbox mb_0">
                                    <input type="checkbox" class="" :id="'pop_up_'+index" :value="popup.id" v-model="dontShow">
                                    <label :for="'pop_up_'+index">{{ trans('front.home.popup_dont_show') }}</label>
                                </div>
                                <button type="button" class="close" @click="closePopUp(index)">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    name: "Home",
    data(){
        return {
            news: [],
            statistics: null,
            setting: null,
            galleries: [],
            sampleLectures: [],
            seminars: [],
            popups: [],
            dontShow: (JSON.parse(localStorage.getItem('popup')) ? JSON.parse(localStorage.getItem('popup')).ids : []) || [],
            popup: JSON.parse(localStorage.getItem('popup')) || null,
        }
    },
    created() {
        this.getSettings();
        this.getNews();
        this.getsSeminars();
        //this.getStatistics();
        this.getGalleries();
    },
    mounted() {
        this.showPopUp();
        this.getSampleLectures();
    },
    methods: {
        getsSeminars() {
            axios.get("/api/home-offline-seminars")
                .then((response) => {
                    this.seminars = response.data.data;
                     setTimeout(() => {
                        this.loadUpcomingSlide();
                    }, 500);
                })
        },
        getGalleries() {
            axios.get('/api/recent-galleries').then((response) => this.galleries = response.data.data)
        },
        getSampleLectures() {
            axios.get('/api/sample-lectures').then((response) => {
                this.sampleLectures = response.data.data
                if(this.sampleLectures.length > 0){
                    this.initSampleLectureVideo(0, false)
                }
                setTimeout(() => {
                    this.loadSampleLectureSlide();
                }, 500);
            })
        },
        getSettings() {
            axios.get('/api/settings').then((response) => {
                this.setting = response.data.data;
                this.initPlayer();
            })
        },
        getNews(){
            axios.get('/api/news').then((response) => {
                this.news = response.data.data;
            });
        },
        getStatistics() {
            axios.get('/api/statistics').then((response) => this.statistics = response.data)
        },
        initPlayer() {
            if (this.setting.home_video) {
                let self = this;
                jwplayer("homeplayer").setup({
                    file: self.setting.home_video,
                    controls: false,
                    autostart: true,
                    stretching: "exactfit",
                    repeat: true,
                    responsive: true
                });
            }
        },
        initSampleLectureVideo(index, autoplay=true){
            jwplayer("single_video").setup({
                file: this.sampleLectures[index].video,
                image: this.sampleLectures[index].thumbs,
                controls: true,
                autostart: autoplay,
                stretching: "exactfit",
                repeat: false,
                margin : 5,
                responsive: true
            });
        },
        closePopUp(index) {
            this.popups.splice(index, 1)
            localStorage.setItem('popup', JSON.stringify({date: new Date().getDate(), ids: this.dontShow}));
        },
        showPopUp() {
            axios.get('/api/popups').then((response) => {
                this.popups = response.data.data.filter(item => {
                    return !this.popup || (!this.popup.ids.includes(item.id) || this.popup.date != new Date().getDate());
                });

                setTimeout(() => {
                    if (this.popups.length) {
                        $('.modal').modal({backdrop: false, keyboard: false})
                        // $('.modal').modal('show');
                    }
                }, 200);
            })
        },
        loadSampleLectureSlide() {
            $('.single_video_thumbnail').slick({
                slidesToShow: 5,
                slidesToScroll: 1,
                arrows: false,
                dots: false,
                focusOnSelect: false,
                infinite: false,
                responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 1008,
                    settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                    }
                }
            ]
            });
        },
        loadUpcomingSlide() {
            $('.upcoming_event_slide').slick({
                slidesToShow: 5,
                slidesToScroll: 1,
                arrows: false,
                dots: false,
                focusOnSelect: false,
                infinite: false,
                // centerMode: true,
                // centerPadding: '40px',
                responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 1008,
                    settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                    }
                }
                ]
            });
        }
    }
}
</script>

<style>
    .custom_modal_dialog{
        position: fixed;
        z-index: 1022;
    }

    .custom_modal_dialog .popup-body {
        width: 100%;
        padding: 0;
    }
    .custom_modal_dialog p{
        margin-bottom: 0;
    }
    .custom_modal_dialog .popup-body img {
        max-height: 100%;
        max-width: 100%;
        object-fit: scale-down;
    }
    .custom_modal_dialog .close ,
    .custom_modal_dialog .close:focus {
        font-size: 35px;
        outline: 0;
        box-shadow: none;
    }
    .form_checkbox [type="checkbox"]:checked+label:before,
    .form_checkbox [type="checkbox"]:not(:checked)+label:before {
        top: 0px;
        border: 1px solid #000;
    }

    .form_checkbox [type="checkbox"]:not(:checked)+label:after,
    .form_checkbox [type="checkbox"]:checked+label:after {
        top: 0px;
    }
</style>
