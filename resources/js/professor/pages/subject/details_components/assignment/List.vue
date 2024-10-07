<template>
    <div>
        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-header">
                        <div class="col_10">
                            <div class="card-title">{{ this.trans('professor.form.assignment.details.title') }}</div>
                        </div>
                        <div class="col_2">
                            <div class="d_flex_end">
                                <router-link class="btn btn_sm btn_secondary mr_5" :to="{name: 'subject_assignments'}"> {{ this.trans('common.index.back') }} </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table-component :api-url="`/api/professor/subjects/assignments/${$route.params.assignment_id}/students`"
                                         :fields="fields"
                                         ref="tableComponent"
                                         :sort-order="sortOrder" @reject="reject" @approve="approve">
                        </table-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TableComponent from "./../../../../components/TableComponent";

export default {
    name:'asignment-submitted-list',
    components: {
        TableComponent
    },
    data() {
        return {
            fields: [
                {
                    name: 'student.name',
                    title: this.trans('professor.form.student.name'),
                    sortField: this.locale === 'en' ? 'name_english' : 'name_hangul',
                    searchable: true
                },
                {
                    name: 'student.student_no',
                    title: this.trans('professor.form.student.student_no'),
                    sortField: 'student_no',
                    searchable: true
                },
                {
                    name: 'student.email',
                    title: this.trans('professor.form.student.email'),
                    sortField: 'email',
                    searchable: true
                },
                {
                    name: 'attachments',
                    title: this.trans('common.index.attachments'),
                    formatter: this.attachmentFormat
                },
                {
                    name: 'status',
                    title: this.trans('professor.label.status'),
                    formatter: this.submissionStatus
                },
                {
                    name: 'action-slot',
                    title: this.trans('professor.label.action'),
                    searchable: false,
                    data: [
                        {
                            class: 'btn btn_sm btn_success mr_5',
                            title: this.trans('professor.label.approve'),
                            action: 'approve',
                            condition: ['professor_action_button_show', false]
                        },
                        {
                            class: 'btn btn_sm btn_danger',
                            title: this.trans('professor.label.reject'),
                            action: 'reject',
                            condition: ['professor_action_button_show', false]
                        }
                    ]
                }
            ],
            sortOrder: []
        }
    },
    watch:{
        '$route.params.semester_id': function (id) {
            this.$router.push({name: 'subject_assignments', params: {semester_id: this.$route.params.semester_id}});
        }
    },
    methods: {
        attachmentFormat(attachments){
            let link = ''
            attachments.forEach(attachment => {
                link +=  `<a class="color_info" href="${attachment.file}" download="${attachment.file_name}"><i class="fas fa-download"></i>${attachment.file_name}</a> <br/>`
            })
            return link
        },
        submissionStatus(value){
            let status = ''
            switch (value) {
                case 0:
                    status = this.trans('student.label.pending')
                    break;
                case 1:
                    status = this.trans('student.label.approved')
                    break;
                case 2:
                    status = this.trans('student.label.rejected')
                    break;
            
                default:
                    break;
            }
            return status
        },
        approve(submittedAssignment) {
            this.$swal({
                title: this.trans('professor.label.approve_confirmation'),
                text: this.trans('professor.label.warning'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: this.trans('professor.label.yes_approve'),
                cancelButtonText: this.trans('professor.label.no_cancel'),
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post(`/api/professor/subjects/assignments/${this.$route.params.assignment_id}/students/${submittedAssignment.student.id}/approveOrReject`,{status: 1}).then(() => {
                        this.$refs.tableComponent.refresh();
                        this.$swal.fire(
                            this.trans('common.message.approved'),
                            this.trans('common.message.approve_message'),
                            'success'
                        )
                    });
                }
            });
        },
        reject(submittedAssignment) {
            this.$swal({
                title: this.trans('professor.label.reject_confirmation'),
                text: this.trans('professor.label.warning'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: this.trans('professor.label.yes_reject'),
                cancelButtonText: this.trans('professor.label.no_cancel'),
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post(`/api/professor/subjects/assignments/${this.$route.params.assignment_id}/students/${submittedAssignment.student.id}/approveOrReject`,{status: 2}).then(() => {
                        this.$refs.tableComponent.refresh();
                        this.$swal.fire(
                            this.trans('common.message.rejected'),
                            this.trans('common.message.reject_message'),
                            'success'
                        )
                    });
                }
            });
        }
    }
}
</script>
