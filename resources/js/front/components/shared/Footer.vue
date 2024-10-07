<template>
    <footer class="footer_area">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="footer_inner">
                        <router-link :to="{name: 'home'}">
                            <img class="footer_logo img-fluid" src="/images/main-logo.png" >
                        </router-link>
                        <ul>
                            <li>{{ trans('front.footer.footer_message') }}</li>
                            <li>{{ trans('front.footer.street') }}</li>
                            <li>{{ trans('front.footer.phone_address') }}</li>
                            <li>{{ trans('front.footer.email') }}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="footer_inner">
                        <h2>{{ trans('front.footer.about_school') }}</h2>
                        <ul>
                            <li>
                                <router-link to="/school-guide/greeting-from-the-chairman">{{ trans('front.footer.about_us') }}</router-link>
                            </li>
                            <li>
                                <router-link to="/academic-information/academic-schedule">{{ trans('front.footer.timetable') }}</router-link>
                            </li>
                            <li>
                                <router-link to="/department-guide/professor-introduction">{{ trans('front.footer.our_teachers') }}</router-link>
                            </li>
                            <li>
                                <router-link :to="{name:'contact_us'}">{{ trans('front.footer.contact_us') }}</router-link>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="footer_inner">
                        <h2>{{ trans('front.footer.study_at') }}</h2>
                        <ul>
                            <li>
                                <router-link to="/academic-information/academic-system">{{ trans('front.footer.graduate') }}</router-link>
                            </li>
                            <li>
                                <router-link to="/academic-information/academic-regulation">{{ trans('front.footer.professional') }}</router-link>
                            </li>
                            <li>
                                <router-link to="/department-guide/ministry-of-ministry">{{ trans('front.footer.courses') }}</router-link>
                            </li>
                        </ul>
                    </div>
                </div>
<!--                <div class="col-md-3">-->
<!--                    <div class="footer_inner">-->
<!--                        <h2>{{ trans('front.footer.subscribe') }}</h2>-->
<!--                        <ul>-->
<!--                            <li>{{ trans('front.footer.subscribe_message') }}</li>-->
<!--                            <div class="newsletter_wrap">-->
<!--                                <div class="newsletter">-->
<!--                                    <input type="text" :placeholder="trans('front.footer.email_placeholder')">-->
<!--                                    <button class="btn"><i class="lni lni-envelope"></i></button>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </ul>-->
<!--                    </div>-->
<!--                </div>-->
            </div>

        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="footer_bottom">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="footer_social">
                                    <p>{{ trans('front.footer.follow_us') }}</p>
                                    <ul>
                                        <li v-for="(social, i) in socials" :key="'social_'+i">
                                            <router-link :to="social.url" data-toggle="tooltip" data-placement="top" :title="social.name"><i :class="social.class"></i>
                                        </router-link> </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="footer_copyright">
                                    <p>@ {{ trans('front.footer.copyright') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>


<script>
export default {
    data(){
        return {
            socials: [],
        }
    },
    created() {
        axios.get('/api/socials').then((response) => { this.socials = response.data.data });
    },
}
</script>
