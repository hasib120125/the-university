<template>
    <header class="header_area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="inner_wrap">
                        <div class="toggle">
                            <i class="lni lni-menu"></i>
                        </div>
                        <div class="left">
                            <div class="logo">
                                <router-link :to="{ name: 'dashboard' }"><img src="/images/logo.png"></router-link>
                            </div>
                        </div>
                        <div class="right">
                            <ul>
                                <li class="m_none"><router-link :to="{name: 'result'}">{{ trans('new.index.result') }}</router-link></li>
                                <li class="m_none"><router-link :to="{name: 'profile'}">{{ trans('new.index.profile') }}</router-link></li>
                                <li class="m_none"><router-link :to="{name: 'subjects'}">{{ trans('new.index.menu_subject') }}</router-link></li>
                                <li class="m_none"><router-link :to="{name: 'payments'}">{{ trans('new.index.payments') }}</router-link></li>
                                <li class="m_none"><router-link :to="{name: 'applications'}">{{ trans('new.index.applications') }}</router-link></li>

                                <li class="m_none">
                                    <div class="dropdown lang_dropdown">
                                        <button class="btn">
                                            <span  class="flag-icon  mr_5" :class="{'flag-icon-us': locale === 'en',  'flag-icon-kr': locale === 'ko'}" ></span>
                                            <span>{{ locale === 'en' ? 'English' : '한국어' }}</span>
                                        </button>
                                        <div class="dropdown_menu ">
                                            <ul>
                                                <li><a href="javascript:void(0)" @click.prevent="setLocale('en')" v-if="locale === 'ko'"><span class="flag-icon flag-icon-us mr_5"></span>  English</a></li>
                                                <li><a href="javascript:void(0)" @click.prevent="setLocale('ko')" v-if="locale === 'en'" ><span class="flag-icon flag-icon-kr mr_5"></span> 한국어 </a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <!-- <li> <a href="#"> <i class="lni lni-alarm"></i> </a></li> -->
                                <li>
                                    <div class="dropdown">
                                        <button class="btn">
                                            <i class="lni lni-user"></i>
                                        </button>
                                        <div class="dropdown_menu">
                                            <div class="user_details">
                                                <div class="img">
                                                    <img :src="user.photo">
                                                </div>
                                                <div class="text">
                                                    <h2>{{ user.name }}</h2>
                                                    <p>{{ user.email }}</p>
                                                </div>
                                            </div>
                                            <ul>
                                                <li><router-link :to="{name: 'profile'}">{{ trans('new.index.profile') }}</router-link></li>
                                                <li><a href="javascript:void(0)" @click.prevent="logout">{{ trans('common.index.logout') }}</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="navigation">
            <div class="mobile_overlay"></div>
            <div class="menu-list clearfix mobile_menu">
                <div class="mobile_lang_btn">
                    <div class="dropdown lang_dropdown">
                        <button class="btn">
                            <span  class="flag-icon mr_5" :class="{'flag-icon-us': locale === 'en',  'flag-icon-kr': locale === 'ko'}" ></span>
                            {{ locale === 'en' ? 'English' : '한국어' }}
                        </button>
                        <div class="dropdown_menu ">
                            <ul>
                                <li><a href="javascript:void(0)" @click.prevent="setLocale('en')" v-if="locale === 'ko'"><span class="flag-icon flag-icon-us mr_5"></span>  English</a></li>
                                <li><a href="javascript:void(0)" @click.prevent="setLocale('ko')" v-if="locale === 'en'" ><span class="flag-icon flag-icon-kr mr_5"></span> 한국어 </a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <ul>
                    <li><router-link :to="{name: 'result'}">{{ trans('new.index.result') }}</router-link></li>
                    <li><router-link :to="{name: 'profile'}">{{ trans('new.index.profile') }}</router-link></li>
                    <!-- <li><router-link :to="{name: 'lecture_apply'}">{{ trans('new.index.lecture_apply') }}</router-link></li> -->
                    <li><router-link :to="{name: 'subjects'}">{{ trans('new.index.subject') }}</router-link></li>
                    <li><router-link :to="{name: 'payments'}">{{ trans('new.index.payments') }}</router-link></li>
                    <li><router-link :to="{name: 'applications'}">{{ trans('new.index.applications') }}</router-link></li>
                </ul>
            </div>
        </div>
    </header>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    computed: {
        ...mapGetters({
            user: 'getUser',
            locale: 'getLocale'
        }),
    },
    mounted() {
        $(document).on('click', '.dropdown button', function () {
            $(this).parent().children('.dropdown_menu').toggleClass('open');
        });

        $(document).mouseup(function (e) {
            $('.dropdown').each(function () {
                var dropdown = $(this);
                if (!dropdown.is(e.target) && dropdown.has(e.target).length === 0) {
                    dropdown.find('.dropdown_menu').removeClass('open');
                }
            });
            // if the target of the click isn't the container nor a descendant of the container
        });

        $('.toggle').click(function() {
            $('#wrap').toggleClass('open_nav');
            $('.mobile_menu').toggleClass('menu_open');
            $('.mobile_overlay').toggleClass('mobile_overlay_open');
            return false;
        });

        $('.mobile_overlay').click(function() {
            $('.mobile_menu').removeClass('menu_open');
            $('.mobile_overlay').removeClass('mobile_overlay_open');
            $('#wrap').removeClass('menu_open');
        });
    },
    methods: {
        logout() {
            axios.post('/api/student/logout').then((response) => {
                this.$store.dispatch('logout');
                window.location.href = "/"
            });
        },
        setLocale(locale) {
            axios.post('/api/set-locale', {lang: locale}).then(() => location.reload());
        }
    }
}
</script>
