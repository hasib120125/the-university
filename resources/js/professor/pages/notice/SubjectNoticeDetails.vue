<template>
    <div class="container-fluid custom_p_40">
        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-body" v-if="notice">
                        <div class="row">
                            <div class="col_10">
                                <h3 class="mb_15">{{ notice.title }}</h3>
                            </div>
                            <div class="col_2">
                                <div class="d_flex_end">
                                    <router-link class="btn btn_sm btn_secondary mr_5" :to="{name: 'home'}"> {{ this.trans('common.index.back') }} </router-link>
                                </div>
                            </div>
                        </div>
                        <div class="ml_10 mb_10" v-html="notice.description"></div>
                        <div class="ml_10">
                            <a class="color_info" :href="notice.attachment1"  :download="notice.attachment1_original_filename" v-if="notice.attachment1"><i class="fas fa-download"></i> {{ notice.attachment1_original_filename }}</a>
                            <br>
                            <a class="color_info" :href="notice.attachment2"  :download="notice.attachment2_original_filename" v-if="notice.attachment2"><i class="fas fa-download"></i> {{ notice.attachment2_original_filename }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: 'Subject-notice',
    data() {
        return {
            notice: null,
        }
    },
    created() {
        axios.get(`/api/professor/subject-notices/${this.$route.params.notice_id}`)
            .then((response) => { this.notice = response.data.data })
    },
    methods: {

    },
}
</script>
<style scoped>
.color_info{
    color: blue;
}
</style>
