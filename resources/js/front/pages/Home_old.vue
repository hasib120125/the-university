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
                <div class="row">
                    <div :class="[{'col-md-6': index === 0}, {'col-md-3': index !== 0}]" v-for="(item, index) in news" :key="'news_'+index">
                        <router-link :to="'/community/news/' + item.slug">
                            <div class="home_news_inner">
                                <img :src="item.cover" alt="" class="img-fluid">

                                <div class="text">
                                    <p><i class="lni lni-calendar"></i> {{ item.created_at }}</p>
                                    <h2>{{ item.title }}</h2>
                                </div>
                            </div>
                        </router-link>
                    </div>
                </div>
            </div>
        </section>

        <section class="home_statistics_v2" v-if="statistics">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="statistics_inner">
                            <div class="text">
                                <h2>{{ statistics.total_student }} {{ trans('front.home.students') }} <br>{{ trans('front.home.students_enrolled_course') }}</h2>
                                <router-link :to="{name: 'student_registration'}" class="btn common_btn width_auto" v-if="statistics.registration_open">{{ trans('front.home.get_started') }}</router-link>
                            </div>
                            <div class="icon_wrap">
                                <div class="inner">
                                    <img src="images/icons/05_icon.svg" alt="" class="img-fluid">
                                    <h2>{{ statistics.total_student }}</h2>
                                    <p>{{ trans('front.home.students_enrolled') }}</p>
                                </div>
                                <div class="inner">
                                    <img src="images/icons/06_icon.svg" alt="" class="img-fluid">
                                    <h2>{{ statistics.total_subjects }}</h2>
                                    <p>{{ trans('front.home.subjects') }}</p>
                                </div>
                                <div class="inner">
                                    <img src="images/icons/01_icon.svg" alt="" class="img-fluid">
                                    <h2>{{ statistics.total_departments }}</h2>
                                    <p>{{ trans('front.home.departments') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="home_social_area">
            <div class="container">
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
            </div>

            <!-- <div class="modal fade welcome_modal"
                data-keyboard="false"
                data-backdrop="false"
                tabindex="-1" aria-hidden="true"> -->
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
            <!-- </div> -->

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
            popups: [],
            dontShow: (JSON.parse(localStorage.getItem('popup')) ? JSON.parse(localStorage.getItem('popup')).ids : []) || [],
            popup: JSON.parse(localStorage.getItem('popup')) || null,
        }
    },
    created() {
        this.getSettings();
        this.getNews();
        this.getStatistics();
        this.getGalleries();
    },
    mounted() {
        this.showPopUp();
    },
    methods: {
        getGalleries() {
            axios.get('/api/recent-galleries').then((response) => this.galleries = response.data.data)
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
