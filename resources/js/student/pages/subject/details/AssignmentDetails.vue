<template>
    <div class="inner">
        <div class="inner_wrap" v-if="assignment">
            <div class="table_responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <th>{{ trans('student.form.assignment_board.title_of_assignment') }}</th>
                            <td colspan="3">{{ assignment.assignment_title }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('student.form.assignment_board.submission_period') }}</th>
                            <td>{{ assignment.start_period }} ~ {{ assignment.end_period }}</td>
                            <th>{{ trans('student.form.assignment_board.current_time') }}</th>
                            <td><span class="color_danger">{{ today }}</span></td>
                        </tr>
                        <tr>
                            <th>{{ trans('student.form.assignment_board.task_type') }}</th>
                            <td>{{ task_type[assignment.task_type-1] }}</td>
                            <th>{{ trans('student.form.assignment_board.submission_status') }}</th>
                            <td>{{ studentAssignmentSubmit ? submissionStatus(studentAssignmentSubmit.status) : '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-10">
                    <h3 class="mb_15">{{ assignment.assignment_title }}</h3>
                </div>
                <div class="col-md-2">
                    <div class="d_flex_end">
                        <router-link class="btn btn_sm btn_secondary mr_5" :to="{name: 'subject_assignments'}"> {{ this.trans('common.index.back') }} </router-link>
                    </div>
                </div>
            </div>
            <div class="mt_10 mb_10" v-html="assignment.description"></div>
            <div class="mt_10">
                <div v-if="assignment.attachment1">
                    <a class="color_info"
                        :href="assignment.attachment1"
                        :download="assignment.attachment1_original_filename"><i class="fas fa-download"></i> {{ assignment.attachment1_original_filename }}</a>
                </div>
                <br>
                <div v-if="assignment.attachment2">
                    <a class="color_info"
                        :href="assignment.attachment2"
                        :download="assignment.attachment2_original_filename"><i class="fas fa-download"></i> {{ assignment.attachment2_original_filename }}</a>
                </div>
            </div>
            <div class="mt_15" v-if="checkAssignmentSubmitAble(assignment)">
                <h3 class="mb_15">{{ trans('common.index.submit_assignment') }}</h3>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form_row_inline ">
                            <label>{{ trans('common.index.submit_assignment') }}</label>
                            <div class="file_input">
                                <input type="file" id="file" ref="file" class="form_global" placeholder="Photo" @change="attachment1Upload($event)">
                                <v-errors :errors="errorFor('attachment1')"></v-errors>
                                <input type="file" id="file" ref="file" class="form_global mt_5" placeholder="Photo" @change="attachment2Upload($event)">
                            <v-errors :errors="errorFor('attachment2')"></v-errors>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <router-link class="btn btn_secondary mr_5" :to="{name: 'subject_assignments'}">{{ trans('admin.label.cancel') }}</router-link>
                    <button class="btn btn_md btn_blue" @click.prevent="submitForm">{{ trans('admin.label.save') }}</button>
                </div>
            </div>
            <div class="mt_15" v-if="studentAssignmentSubmit">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="mb_15">{{ trans('new.index.submission_list') }}</h3>
                        <div class="table_responsive">
                            <table class="table table_center">
                                <thead>
                                    <tr>
                                        <th>{{ trans('new.index.file') }}</th>
                                        <th>{{ trans('student.label.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(attachment, i) in studentAssignmentSubmit.attachments" :key="'att'+i">
                                        <td>
                                            <a class="color_info" :href="attachment.file"  :download="attachment.file_name" v-if="attachment.file"> <i class="fas fa-download"></i> {{ attachment.file_name }}</a>
                                        </td>
                                        <td><span @click="deleteItem(attachment.id)">{{ trans('new.index.delete') }}</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment'
import validationErrors from "../../../mixins/validationErrors";

export default {
    mixins: [validationErrors],
    data() {
        return {
            assignment: null,
            task_type: [
                this.trans('admin.form.assignment.general_tasks'),
                this.trans('admin.form.assignment.assignment_type_test'),
                this.trans('admin.form.assignment.etc')
            ],
            form:{
                attachment1: '',
                attachment2: '',
            },
            studentAssignmentSubmit: null,
        }
    },
    activated(){
        this.loadData()
    },
    computed:{
        today(){
            return moment().format('l h:mm:ss a')
        }
    },
    methods: {
        loadData(){
            axios.get(`/api/student/subjects/${this.$route.params.id}/assignments/${this.$route.params.assignment_id}`)
                    .then((response) => { 
                        this.assignment = response.data.assignment 
                        this.studentAssignmentSubmit = response.data.studentAssignmentSubmit 
                    })
        },
        submissionStatus(status){
            if(status == 0){
                return `${this.trans('student.label.pending')}`
            }
            if(status == 1){
                return `${this.trans('student.label.approved')}`
            }
            if(status == 2){
                return `${this.trans('student.label.rejected')}`
            }
                
        },
        checkAssignmentSubmitAble(assignment){
            let today = new Date(moment().format('YYYY-M-D'))
            let start_period = new Date(assignment.start_period)
            let end_period = new Date(assignment.end_period)

            let dateNotOver = today.getTime() >= start_period.getTime() && today.getTime() <= end_period.getTime()
            let dateOverSubmitAble = assignment.end_open // 1 for submitable
            
            if(!dateNotOver && dateOverSubmitAble == 2) return true
            if(!dateNotOver)  return 

            return true
        },
        submitForm(){
            this.errors = null;

            let formData = new FormData();

            Object.keys(this.form).forEach(key => {
                formData.append(key, this.form[key]);
            });

            axios.post(`/api/student/subjects/${this.$route.params.assignment_id}/assignments`, formData)
                .then((response) => {
                    let responseData = response.data
                    if(responseData.success){
                        this.$swal.fire(
                            this.trans('student.label.submitted')+'!',
                            responseData.message,
                            'success'
                        )
                        this.$router.push({name: 'subject_assignments'});
                    }else{
                        this.$swal.fire(
                            this.trans('student.label.error')+'!',
                            responseData.message,
                            'error'
                        )
                    }
                })
                .catch((err) => this.errors = err.response.data.errors)
                .finally(() => this.loading = false);
        },
        attachment1Upload(e) {
            this.form.attachment1 = e.target.files[0];
        },
        attachment2Upload(e) {
            this.form.attachment2 = e.target.files[0];
        },
        deleteItem(id) {
            this.$swal({
                title: this.trans('student.label.delete_confirmation'),
                text: this.trans('student.label.warning'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: this.trans('student.label.yes_delete'),
                cancelButtonText: this.trans('student.label.no_cancel'),
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/api/student/delete-assignment-attacment/'+id).then(() => {
                        this.loadData()
                        this.$swal.fire(
                            this.trans('common.message.deleted'),
                            this.trans('common.message.delete_message'),
                            'success'
                        )
                    });
                }
            });
        }
    },
}
</script>
<style scoped>
.color_info{
    color: blue;
}
</style>
