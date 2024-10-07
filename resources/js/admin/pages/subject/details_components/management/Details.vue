<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-body" v-if="management">
                    <table class="table table_bordered table_fixed">
                        <tbody>
                            <tr>
                                <th>{{ trans('admin.form.lecture_management.lecture_no') }}</th>
                                <td colspan="3">{{ management.lecture_number }}</td>
                            </tr>
                            <tr>
                                <th>{{ trans('admin.form.lecture_management.period') }}</th>
                                <td>{{ management.start_period }} ~ {{ management.end_period }}</td>
                                <th>{{ trans('admin.form.lecture_management.video_running_time') }}</th>
                                <td>{{ management.video_running_time }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col_10">
                            <h3 class="mb_15">{{ management.lecture_name }}</h3>
                        </div>
                        <div class="col_2">
                            <div class="d_flex_end">
                                <router-link class="btn btn_sm btn_secondary mr_5" :to="{name: 'lecture_managements'}"> {{ this.trans('common.index.back') }} </router-link>
                            </div>
                        </div>
                    </div>

                    <div class="mt_10 mb_10" v-html="management.description"></div>

                    <div class="mt_10">
                        <div id="player"></div>
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
            management: null,
        }
    },
    created() {
        axios.get(`/api/admin/lectures/${this.$route.params.id}/managements/${this.$route.params.management_id}`)
            .then((response) => {
                this.management = response.data.data;
                    this.initJwPlayer();
            })
    },
    methods: {
        initJwPlayer() {
            let self = this;
            setTimeout(() => {
                jwplayer("player").setup({
                    sources: [{
                        file: self.management.smil,
                    }],
                });
            }, 200);
        }
    },
}
</script>
<style scoped>
.color_info{
    color: blue;
}
</style>
