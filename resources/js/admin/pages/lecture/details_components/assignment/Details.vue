<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-body" v-if="assignment">
                    <table class="table table_bordered table_fixed">
                        <tbody>
                            <tr>
                                <th>{{ trans('admin.form.assignment.title') }}</th>
                                <td colspan="3">{{ assignment.assignment_title }}</td>
                            </tr>
                            <tr>
                                <th>{{ trans('common.index.period') }}</th>
                                <td>{{ assignment.start_period }} ~ {{ assignment.end_period }}</td>
                                <th>{{ trans('common.index.current_time') }}</th>
                                <td><span class="color_danger">{{ today }}</span></td>
                            </tr>
                            <tr>
                                <th>{{ trans('admin.form.assignment.task_type') }}</th>
                                <td colspan="3">{{ task_type[assignment.task_type-1] }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col_10">
                            <h3 class="mb_15">{{ assignment.assignment_title }}</h3>
                        </div>
                        <div class="col_2">
                            <div class="d_flex_end">
                                <router-link class="btn btn_sm btn_secondary mr_5" :to="{name: 'lecture_assignments'}"> {{ this.trans('common.index.back') }} </router-link>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt_10 mb_10" v-html="assignment.description"></div>
                    <div class="mt_10">
                        <a class="color_info" :href="assignment.attachment1" target="_blank" :download="'assignment'+assignment.id + '_attachment_1'" v-if="assignment.attachment1"> Attachment1</a>
                        <br>
                        <a class="color_info" :href="assignment.attachment2" target="_blank" :download="'assignment'+assignment.id + '_attachment_2'" v-if="assignment.attachment2"> Attachment2</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment'
export default {
    data() {
        return {
            task_type: ['General tasks','Assignment type test','Etc'],
            assignment: null,
        }
    },
    created() {
        axios.get(`/api/admin/lectures/${this.$route.params.id}/assignments/${this.$route.params.assignment_id}`)
            .then((response) => { this.assignment = response.data.data })
    },
    computed:{
        today(){
            return moment().format('l h:mm:ss a')
        }
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
