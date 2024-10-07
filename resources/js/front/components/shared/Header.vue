<template>
    <header :class="['header_area', {'fixed-top': $route.name === 'home'}, {'others_header': $route.name !== 'home'}]">
        <!-- <div class="header_top above_ipad" v-if="$route.name !== 'home'">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="header_top_inner">
                            <div class="header_top_left m_none">
                                <ul>
                                    <li v-if="settings.university_address">
                                        <a>Address No {{ settings.university_address }},</a>
                                    </li>
                                    <li v-if="settings.phone_number">
                                        <a>Call Us {{ settings.phone_number }}</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="header_top_dropdown">
                                <ul>
                                    <li>
                                        <div class="dropdown lang_dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="ddLang"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="flag-icon mr_5" :class="{'flag-icon-us': locale === 'en',  'flag-icon-kr': locale === 'ko'}"></span>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="ddLang">
                                                <a class="dropdown-item" href="javascript:void(0)" @click.prevent="setLocale('en')" v-if="locale === 'ko'"><span class="flag-icon flag-icon-us mr_5"></span></a>
                                                <a class="dropdown-item" href="javascript:void(0)" @click.prevent="setLocale('ko')" v-if="locale === 'en'"> <span class="flag-icon flag-icon-kr mr_5"></span></a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="main_header">
            <div class="container desktopHeader">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main_nav">
                            <div class="logo d_flex_center">
                                <router-link :to="{name: 'home'}">
                                    <img src="/images/main-logo.png" class="img-fluid">
                                </router-link>
                            </div>
                            <ul class="header_menu">
                                <li v-for="(menu, i) in menus" :key="'menu_'+i">
                                    <router-link :to="{ name:'sub_menu_page', params:{ menu:menu.slug, submenu: menu.sub_menus[0].slug }}"> {{ menu.name }}</router-link>
                                </li>
                                <li>
                                    <router-link to="/department-guide/professor-introduction"> {{ trans('front.header.professor_introduction') }} </router-link>
                                </li>
                                <!-- <li>
                                    <router-link :to="{name: 'news'}"> {{ trans('front.header.news') }} </router-link>
                                </li>
                                <li>
                                    <router-link :to="{name: 'gallery'}"> {{ trans('front.header.gallery') }} </router-link>
                                </li> -->
                            </ul>

                            <div class="header_cart ml_10">
                                <ul>
                                    <li v-if="user">
                                        <a v-if="user" :href="'/'+user.type"><i class='bx bxs-user'></i> {{ user.name }}</a>
                                    </li>

                                    <li v-else>
                                        <router-link :to="{name: 'login'}"><i class='bx bxs-log-in'></i>{{ trans('front.header.login') }}</router-link>
                                    </li>
                                    <li>
                                        <div class="dropdown lang_dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="ddLang"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="flag-icon mr_5" :class="{'flag-icon-us': locale === 'en',  'flag-icon-kr': locale === 'ko'}"></span>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="ddLang">
                                                <a class="dropdown-item" href="javascript:void(0)" @click.prevent="setLocale('en')" v-if="locale === 'ko'"><span class="flag-icon flag-icon-us"></span></a>
                                                <a class="dropdown-item" href="javascript:void(0)" @click.prevent="setLocale('ko')" v-if="locale === 'en'"> <span class="flag-icon flag-icon-kr"></span></a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container mobileHeader">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mobile_nav_wrap">
                            <div class="toggler">
                                <i class="la la-bars" aria-hidden="true"></i>
                            </div>
                            <router-link :to="{name: 'home'}" class="mobile_logo">
                                <img src="/images/main-logo.png" alt="" class="img-fluid">
                            </router-link>
                            <div class="header_cart">
                                <ul>
                                    <li v-if="user">
                                        <div class="dropdown user_info_mobile">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class='bx bxs-user mr_0'></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                <div class="user_details">
                                                    <div class="img">
                                                        <i class='bx bxs-user mr_0'></i>
                                                    </div>
                                                    <div class="text">
                                                        <h2>{{ user.name }}</h2>
                                                        <p>{{ user.email }}</p>
                                                    </div>
                                                </div>
                                                <ul>
                                                    <li>
                                                        <a v-if="user" :href="'/'+user.type"><i class='bx bx-user'></i> {{ trans('front.header.dashboard') }}</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>

                                    <li v-else>
                                        <router-link :to="{name: 'login'}"><i class='bx bxs-log-in'></i>{{ trans('front.header.login') }}</router-link>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    data(){
        return {
            menus: [],
            settings: '',
        }
    },
    computed: {
        ...mapGetters({
            user: 'getUser',
            locale: 'getLocale'
        }),
    },
    created() {
        axios.get('/api/menus').then((response) => { this.menus = response.data.data });
        axios.get('/api/settings').then((response) => { this.settings = response.data.data });
    },
    methods: {
        setLocale(locale) {
            axios.post('/api/set-locale', {lang: locale}).then(() => location.reload());
        }
    },

}
</script>
