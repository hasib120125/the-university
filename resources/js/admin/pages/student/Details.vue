<template>
    <div>
        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-header" v-if="student">
                        <div class="card-title d_flex_btwn width_full">
                            <span>{{ student.name }}</span>
                            <router-link class="btn btn_secondary mr_5" :to="{name: 'students'}">{{ trans('common.index.back') }}</router-link>
                        </div>
                    </div>
                    <div class="card-body">
                        <nav class="tabs">
                            <ul class="">
                                <li href="#student" class="active"> {{ trans('common.index.info') }} </li>
                                <li href="#result"> {{ trans('common.index.result') }} </li>
                                <li href="#applications"> {{ trans('admin.form.application.applications') }} </li>
                            </ul>
                        </nav>
                        <div class="tab_content_wrapper">
                            <div id="student" class="tab_content show active">
                                <div class="fadein">
                                    <Info :student="student" />
                                </div>
                            </div>
                            <div id="result" class="tab_content">
                                <div class="fadein">
                                    <Result />
                                </div>
                            </div>

                            <div id="applications" class="tab_content">
                                <div class="fadein">
                                    <Applications />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Result from './tab/Result.vue'
import Info from './tab/Info.vue'
import Applications from './tab/Applications.vue'

export default {
    components: {
        Result,
        Info,
        Applications,
    },
    data() {
        return {
            student: {},
        }
    },
    created(){
        axios.get('/api/admin/students/'+ this.$route.params.id)
                    .then((response) => {
                        this.student = response.data.data
                    })

        axios.get('/api/admin/dept-subject-details/'+ this.$route.params.id)
                    .then((response) => {

                    })
    },
    mounted(){
        $('.tabs li').click(function () {
            $(this).siblings().removeClass("active");
            $(this).addClass("active");
            $(".tab_content").removeClass("show");
            $($(this).attr("href")).addClass("show");
        });
    },
    methods: {

    }
}
</script>

