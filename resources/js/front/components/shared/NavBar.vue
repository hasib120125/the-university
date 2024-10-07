<template>
    <div id="navigation">
        <div class="mobile_overlay"></div>

        <div class="menu-list clearfix mobile_menu">
            <div class="m_close_menu close_icon"></div>
            <div class="dropdown lang_dropdown mobile_lang_btn">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="flag-icon mr_5" :class="{'flag-icon-us': locale === 'en',  'flag-icon-kr': locale === 'ko'}"></span>   {{ locale === 'en' ? 'English' : '한국어' }}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a href="javascript:void(0)" @click.prevent="setLocale('en')" v-if="locale === 'ko'"><span class="flag-icon flag-icon-us mr_5"></span>  English</a>
                    <a href="javascript:void(0)" @click.prevent="setLocale('ko')" v-if="locale === 'en'" ><span class="flag-icon flag-icon-kr mr_5"></span> 한국어 </a>
                </div>
            </div>
            <ul id="menu-content">
                <div class="common_left_sidebar">
                    <div id="accordion1">
                        <div class="card" v-for="(menu, i) in menus" :key="'menu_'+i">
                            <div class="card-header" :id="menu.slug">
                                <button class="btn btn-link collapsed" data-toggle="collapse" :data-target="'#collapse_'+menu.slug" aria-expanded="false" aria-controls="collapseOne1">
                                    {{ menu.name }}
                                </button>
                            </div>

                            <div :id="'collapse_'+menu.slug" class="collapse" :aria-labelledby="menu.slug" data-parent="#accordion1">
                                <div class="card-body">
                                    <ul>
                                        <li v-for="(sub, index) in menu.sub_menus" :key="'sub_'+index">
                                            <router-link class="mobile-menu-item" :to="sub.route"> {{ sub.name }} </router-link>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </ul>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    data(){
        return {
            menus: [],
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
    },
    methods:{
        setLocale(locale) {
            axios.post('/api/set-locale', {lang: locale}).then(() => location.reload());
        }
    }
}
</script>

