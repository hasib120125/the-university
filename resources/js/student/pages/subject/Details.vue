<template>
    <section class="video_area">
        <div class="video_area_wrap">
            <div class="main_video">
                <div class="main_video_content">
                    <div class="course_collapse"> <span class="icon"><i class="fas fa-arrow-left"></i></span> <span class="text" v-if="subject">{{ subject.name }} - {{ trans('new.index.lecture_content') }}</span></div>
                    <div class="main_video_content_inner" ref="videoContent">
                        <div id="player" v-if="currentContent"></div>
                    </div>
                </div>
                <div class="video_overview">

                        <button class="tab_btn left_btn" @click="tabMove('left')"><i class="lni lni-chevron-left"></i></button>
                        <button class="tab_btn right_btn" @click="tabMove('right')"><i class="lni lni-chevron-right"></i></button>
                    <div class="tab_btn_wrap">
                    </div>

                    <ul class="nav nav-tabs show_above_ipad" id="tablist1" role="tablist1">
                        <li class="nav-item" role="presentation">
                            <router-link class="nav-link" exact active-class="active" :to="{name: 'subject_overview'}">{{ trans('new.index.overview') }}</router-link>
                        </li>
                        <li class="nav-item" role="presentation">
                            <router-link class="nav-link" exact active-class="active" :to="{name: 'subject_notices'}">{{ trans('new.index.subject_details.notices') }}</router-link>
                        </li>
                        <li class="nav-item" role="presentation">
                            <router-link class="nav-link" exact active-class="active" :to="{name: 'subject_plan'}">{{ trans('new.index.plan') }}</router-link>
                        </li>
                        <li class="nav-item" role="presentation">
                            <router-link class="nav-link" exact active-class="active" :to="{name: 'subject_materials'}">{{ trans('new.index.materials') }}</router-link>
                        </li>
                        <li class="nav-item" role="presentation">
                            <router-link class="nav-link" exact active-class="active" :to="{name: 'subject_assignments'}">{{ trans('new.index.assignment') }}</router-link>
                        </li>
                        <li class="nav-item" role="presentation">
                            <router-link class="nav-link" exact active-class="active" :to="{name: 'subject_exams'}">{{ trans('new.index.take_test') }}</router-link>
                        </li>
                        <li class="nav-item" role="presentation">
                            <router-link class="nav-link" exact active-class="active" :to="{name: 'subject_exam_list'}">{{ trans('new.index.exam_list') }}</router-link>
                        </li>
                        <!-- <li class="nav-item" role="presentation">
                            <router-link class="nav-link" exact active-class="active" :to="{name: 'qa_list'}">{{ trans('common.index.qa') }}</router-link>
                        </li> -->
                        <li class="nav-item" role="presentation">
                            <router-link class="nav-link" exact active-class="active" :to="{name: 'subject_notes'}">{{ trans('new.index.notes') }}</router-link>
                        </li>
                    </ul>

                    <ul class="nav nav-tabs hide_avobe_ipad" id="myTabMobile" role="myTabMobile">
                        <li class="nav-item below_ipad" role="presentation">
                            <a :class="['nav-link', {'active': showMobileContent}]" @click.prevent="showMobileLectureContent" v-if="subject">{{ subject.name }} - {{ trans('new.index.lecture_content') }}</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <router-link class="nav-link" exact active-class="active" :to="{name: 'subject_notices'}">{{ trans('new.index.subject_details.notices') }}</router-link>
                        </li>
                        <li class="nav-item" role="presentation">
                            <router-link class="nav-link" exact active-class="active" :to="{name: 'subject_materials'}">{{ trans('new.index.materials') }}</router-link>
                        </li>
                        <li class="nav-item" role="presentation">
                            <router-link class="nav-link" exact active-class="active" :to="{name: 'subject_assignments'}">{{ trans('new.index.assignment') }}</router-link>
                        </li>
                        <li class="nav-item" role="presentation">
                            <router-link class="nav-link" exact active-class="active" :to="{name: 'subject_exams'}">{{ trans('new.index.take_test') }}</router-link>
                        </li>
                        <li class="nav-item" role="presentation">
                            <router-link class="nav-link" exact active-class="active" :to="{name: 'subject_exam_list'}">{{ trans('new.index.exam_list') }}</router-link>
                        </li>

                        <li class="nav-item" role="presentation">
                            <router-link class="nav-link" exact active-class="active" :to="{name: 'subject_overview'}">{{ trans('new.index.overview') }}</router-link>
                        </li>
                        <li class="nav-item" role="presentation">
                            <router-link class="nav-link" exact active-class="active" :to="{name: 'subject_plan'}">{{ trans('new.index.plan') }}</router-link>
                        </li>
                        <!-- <li class="nav-item" role="presentation">
                            <router-link class="nav-link" exact active-class="active" :to="{name: 'qa_list'}">{{ trans('common.index.qa') }}</router-link>
                        </li> -->
                        <li class="nav-item" role="presentation">
                            <router-link class="nav-link" exact active-class="active" :to="{name: 'subject_notes'}">{{ trans('new.index.notes') }}</router-link>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent1">
                        <div class="tab-pane fade show active">
                            <transition name="fade" mode="out-in">
                                <div class="inner course_content" v-if="showMobileContent">
                                    <div class="thumbnail_content">
                                        <div class="accordion">
                                            <div class="card">
                                                <div class="collapse show">
                                                    <div class="card-body">
                                                        <ul>
                                                            <li v-for="(content, index) in contents" :key="'content_'+index" :class="{'active': currentContent && content.id === currentContent.id}">
                                                                <a>
                                                                    <span class="number">{{ index+1 }}</span>
                                                                    <div class="img">
                                                                        <img :src="content.thumbs" alt="">
                                                                        <div class="progress" v-if="content.progress">
                                                                            <div class="bar" :style="{ width: content.progress.progress_percentage + '%', background: content.progress.current_content_type === 'a' ? '#ff8b1d' : '#36496a' }">
                                                                                <p class="percent"></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="text">
                                                                        <h2 class="heading">{{ content.name }}</h2>
                                                                        <p v-html="content.description"></p>
                                                                    </div>

                                                                    <span class="time">
                                                                        <i class="fas fa-play-circle"></i> {{ content.duration }} <br>
                                                                        <i class="fas fa-play-circle color_warning"></i> {{ content.audio_duration }}
                                                                    </span>

                                                                    <div class="custom_btn">
                                                                        <span class="btn btn_sm btn_info" v-if="content.smil" @click.prevent="initJwPlayer(content, 'v')">{{ trans('student.label.video') }}</span>
                                                                        <span class="btn btn_sm btn_warning mr_5" v-if="content.audio_file" @click.prevent="initJwPlayer(content, 'a')">{{ trans('student.label.audio') }}</span>
                                                                    </div>

                                                                    <div class="custom_icon">
                                                                        <span class="delay" :title="trans('new.index.late')" v-if="content.progress && content.progress.late"><img src="/images/delay-icon2.png" alt=""></span>
                                                                        <span class="completed" :title="trans('new.index.completed')" v-if="content.progress && content.progress.completed"><i class="lni lni-checkmark-circle"></i></span>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div v-else>
                                    <keep-alive>
                                        <router-view :currentPlayTime="currentPlayTime" :currentContent="currentContent" :contents="contents" :subject="subject"></router-view>
                                    </keep-alive>
                                </div>
                            </transition>
                        </div>
                    </div>
                </div>

            </div>
            <div class="video_thumbnail">
                <div class="title">
                    <h2 v-if="subject">{{ subject.name }} - {{ trans('common.index.lecture_content') }}</h2>
                    <div class="close_icon"></div>
                </div>
                <div class="thumbnail_content">
                    <div class="accordion" id="accordionExample">
                        <div class="card">
                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    <ul>
                                        <li v-for="(content, index) in contents" :key="'content_'+index" :class="{'active': currentContent && content.id === currentContent.id}">
                                            <a>
                                                <span class="number">{{ index+1 }}</span>
                                                <div class="img">
                                                    <img :src="content.thumbs" alt="">
                                                    <div class="progress" v-if="content.progress">
                                                        <div class="bar" :style="{ width: content.progress.progress_percentage + '%', background: content.progress.current_content_type === 'a' ? '#ff8b1d' : '#36496a' }">
                                                            <p class="percent"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <span class="time">
                                                    <i class="fas fa-play-circle"></i> {{ content.duration }} <br>
                                                    <i class="fas fa-play-circle color_warning"></i> {{ content.audio_duration }}
                                                </span>
                                                <div class="text">
                                                    <h2 class="heading">{{ content.name }}</h2>
                                                    <p v-html="content.description"></p>


                                                    <div class="custom_btn">
                                                        <span class="btn btn_sm btn_info" v-if="content.smil" @click.prevent="initJwPlayer(content, 'v')">{{ trans('student.label.video') }}</span>
                                                        <span class="btn btn_sm btn_warning mr_5" v-if="content.audio_file" @click.prevent="initJwPlayer(content, 'a')">{{ trans('student.label.audio') }}</span>
                                                    </div>

                                                    <div class="custom_icon">
                                                        <span :title="trans('new.index.late')" class="delay" v-if="content.progress && content.progress.late">
                                                            <!-- {{ trans('new.index.late') }} -->
                                                            <img class="ml_5" src="/images/delay-icon2.png" alt=""></span>
                                                        <span :title="trans('new.index.completed')" class="completed" v-if="content.progress && content.progress.completed">
                                                            <!-- {{ trans('new.index.completed') }} -->
                                                            <i class="ml_5 lni lni-checkmark-circle"></i></span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import TableComponent from "./../../components/TableComponent";

export default {
    components: {
        TableComponent
    },
    data() {
        return {
            subject: null,
            playerInit: false,
            currentContent: null,
            activeLecture: [],
            contents: [],
            showMobileContent: false,
            currentPlayTime: 0,
            playInterval: null,
            progressSaveInterval: 3,
            seeking: true,
            maxPlayPosition: 0,
        }
    },
    watch: {
        $route(to) {
            if (!to.query.content)
                this.showMobileContent = false;
        }
    },
    created() {
        axios.get('/api/student/subjects/' + this.$route.params.id)
            .then((response) => {
                this.subject = response.data.data
                this.contents = response.data.data.lectures
            });

        $(window).on("beforeunload", function() {
            Echo.leaveChannel('presence-counter');
        });
    },
    updated(){
        if(this.$refs.videoContent)
        {
            localStorage.setItem('videoContentHeight', this.$refs.videoContent.clientHeight)
        }
    },
    destroyed() {
        Echo.leaveChannel('presence-counter');
    },
    mounted() {
        let w = $(window).width();

        if (w > 1023)
            this.showHideNavigation();
        else
            this.showMobileLectureContent()

        $('.close_icon').click(function() {
            $('.main_video').css({
                width : '100%'
            })
            $('.course_collapse').show();
            $('.video_thumbnail').css({
                display : 'none'
            })
        });

        $('.course_collapse').click(function() {
            $('.main_video').css({
                width : '75%'
            })
            $('.course_collapse').hide();
            $('.video_thumbnail').css({
                display : 'block'
            })
        });

        window.onresize = this.showHideNavigation();
    },
    beforeRouteLeave(to, from, next) {
        clearInterval(this.playInterval);
        next();
    },
    methods: {
        tabMove(direction = 'right') {
            let scrollLeft = $('#myTabMobile').scrollLeft();
            if(direction == 'right') {
                scrollLeft += 100;
            } else if(direction == 'left') {
                scrollLeft -= 100;
            }
            $('#myTabMobile').animate({scrollLeft: scrollLeft}, 100);
        },
        initJwPlayer(content, type) {
            let self = this;
            this.currentContent = content;
            this.currentContent.type = type;

            setTimeout(() => {
                Echo.join('counter');

                let playlist = this.contents.map((item) => {
                    return {
                        title: item.lecture_name,
                        image: type === 'v' ? item.thumbs : item.audio_thumbs,
                        sources: [{
                            file: type === 'v' ? item.smil : item.audio_file,
                            label: item.id
                        }],
                        tracks: [{
                            "kind": "captions",
                            "file": item.subtitle_file_formatted,
                            "label": item.subtitle_label
                        }]
                    }
                });

                let file = type === 'v' ? this.currentContent.smil : this.currentContent.audio_file;
                let playIndex = playlist.findIndex((i) => i.sources[0].file === file);

                jwplayer("player").setup({
                    playlist: playlist,
                    playlistIndex: playIndex,
                    floating: {
                        dismissible: true
                    }
                }).on('time', function (data) {
                    self.currentPlayTime = Math.floor(data.currentTime);

                    if (!self.seeking) {
                        self.maxPlayPosition = Math.max(data.position, self.maxPlayPosition);
                    }
                }).on('playlistItem', function () {
                    let index = Math.floor(jwplayer("player").getPlaylistIndex());
                    let playlist = jwplayer("player").getPlaylist();

                    self.currentContent = self.contents.find(item => item.id === playlist[index].allSources[0].label);
                    self.currentContent.type = type;
                    if(type === 'v'){
                        self.maxPlayPosition = self.currentContent.progress ? self.currentContent.progress.video_total_time : 0;
                    }else{
                        self.maxPlayPosition = self.currentContent.progress ? self.currentContent.progress.audio_total_time : 0;
                    }
                    // self.maxPlayPosition = self.currentContent.progress ? self.currentContent.progress.max_seek_time : 0;

                    jwplayer().seek(self.currentContent.progress ? self.currentContent.progress.current_time : 0);
                }).on('pause', function(e) {
                    clearInterval(self.playInterval);
                }).on('idle', function(e) {
                    clearInterval(self.playInterval);
                }).on('play', function(e) {
                    clearInterval(self.playInterval);
                    self.setPlayInterval();
                }).on('seek', function (event) {
                    clearInterval(self.playInterval);
                    self.seeking = true;
                }).on('seeked', function (event) {
                    let pos = jwplayer().getPosition();

                    self.seeking = true;
                });

                this.playerInit = true;
            }, 200);
        },
        setPlayInterval() {
            this.playInterval = setInterval(() => {
                this.saveCurrentState();
            }, this.progressSaveInterval * 1000);
        },
        showHideNavigation() {
            $('.course_collapse').hide();
        },
        showMobileLectureContent() {
            this.showMobileContent = true;
            this.$router.push({query: {content: '1'}}).catch(() => {});
        },
        saveCurrentState() {
            let type = this.currentContent.type;
            let playlist = jwplayer("player").getPlaylist();
            let playlistIndex = jwplayer("player").getPlaylistIndex();
            let position = Math.floor(jwplayer("player").getPosition());

            let id = playlist[playlistIndex].allSources[0].label;

            let form = {
                id: id,
                position: position,
                type: type
            }

            axios.post('/api/student/save-progress', form).then((response) => {
                if (type === 'v') {
                    this.currentContent.progress = response.data.data;
                } else {
                    this.currentContent.progress = response.data.data;
                }
            });
        },
    }
}
</script>

<style scoped>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .3s;
    }
    .fade-enter, .fade-leave-to {
        opacity: 0;
    }
</style>
