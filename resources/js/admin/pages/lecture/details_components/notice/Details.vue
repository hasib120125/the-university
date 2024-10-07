<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-body" v-if="lecture">
                    <div class="row">
                        <div class="col_10">
                            <h3 class="mb_15">{{ lecture.title }}</h3>
                        </div>
                        <div class="col_2">
                            <div class="d_flex_end">
                                <router-link class="btn btn_sm btn_secondary mr_5" :to="{name: 'lecture_notices'}"> {{ this.trans('common.index.back') }} </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="mt_10 mb_10" v-html="lecture.description"></div>
                    <div class="mt_10">
                        <a class="color_info" :href="lecture.attachment1" target="_blank" :download="lecture.id + '_attachment_1'" v-if="lecture.attachment1"> {{ trans('admin.form.notices.attachment_1') }}</a>
                        <br>
                        <a class="color_info" :href="lecture.attachment2" target="_blank" :download="lecture.id + '_attachment_2'" v-if="lecture.attachment2"> {{ trans('admin.form.notices.attachment_2') }}</a>
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
            lecture: null,
        }
    },
    created() {
        axios.get(`/api/admin/lectures/${this.$route.params.id}/notices/${this.$route.params.notice_id}`)
            .then((response) => { this.lecture = response.data.data })
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
