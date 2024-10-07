<template>
    <header class="header_area">
        <div class="header_inner">
            <ul></ul>
            <ul>
                <li>
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
                <!-- <li><i class='bx bx-search' ></i></li>
                <li>
                    <div class="dropdown">
                        <button class="btn">
                            <i class='bx bx-bell' ></i>
                        </button>
                    </div>
                </li> -->

                <li>
                    <div class="dropdown">
                        <button class="btn">
                            <span><b v-if="user">{{ user.name }}</b><br>{{ trans('professor.form.lecture.professor') }}</span>
                            <img src="/images/logo.png" alt="">
                        </button>
                        <div class="dropdown_menu">
                            <ul>
                                <li><a href="javascript:void(0)" @click.prevent="logout"><i class="ti-lock"></i> Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
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
    },
    methods: {
        logout() {
            axios.post('/api/professor/logout').then((response) => {
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
