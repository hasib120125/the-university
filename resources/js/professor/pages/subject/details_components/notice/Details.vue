<template>
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
                                <router-link class="btn btn_sm btn_secondary mr_5" :to="{name: 'subject_notices',  params: {semester_id: $route.params.semester_id}}"> {{ this.trans('common.index.back') }} </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="mt_10 mb_10" v-html="notice.description"></div>
                    <div class="mt_10">
                        <a class="color_info" :href="notice.attachment1" target="_blank" :download="notice.id + '_attachment_1'" v-if="notice.attachment1"> {{ trans('professor.form.notices.attachment_1') }}</a>
                        <br>
                        <a class="color_info" :href="notice.attachment2" target="_blank" :download="notice.id + '_attachment_2'" v-if="notice.attachment2"> {{ trans('professor.form.notices.attachment_2') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            notice: null,
        }
    },
    created() {
        axios.get(`/api/professor/subjects/${this.$route.params.id}/notices/${this.$route.params.notice_id}`)
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
