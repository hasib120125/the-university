<template>
    <div>
        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-header">
                        <div class="col_10">
                            <div class="card-title">{{ this.trans('admin.form.assignment.details.title') }}</div>
                        </div>
                        <div class="col_2">
                            <div class="d_flex_end">
                                <router-link class="btn btn_sm btn_secondary mr_5" :to="{name: 'lecture_assignments'}"> {{ this.trans('common.index.back') }} </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table-component :api-url="`/api/admin/lectures/assignments/${$route.params.assignment_id}/students`"
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
                    name: 'name',
                    title: this.trans('admin.form.student.name'),
                    sortField: this.locale === 'en' ? 'name_english' : 'name_hangul',
                    searchable: true
                },
                {
                    name: 'student_no',
                    title: this.trans('admin.form.student.student_no'),
                    sortField: 'student_no',
                    searchable: true
                },
                {
                    name: 'email',
                    title: this.trans('admin.form.student.email'),
                    sortField: 'email',
                    searchable: true
                },
                {
                    name: 'attachment1',
                    title: this.trans('admin.label.attachment1'),
                    sortField: 'attachment1',
                    searchable: false,
                    formatter (value) {
                        return `<a class="color_info" href="${value}" target="_blank"> Attachment1</a>`
                    }
                },
                {
                    name: 'attachment2',
                    title: this.trans('admin.label.attachment2'),
                    sortField: 'attachment2',
                    searchable: false,
                    formatter (value) {
                        if(value)
                            return `<a class="color_info" href="${value}" target="_blank"> Attachment2</a>`
                        return value
                    }
                },
                {
                    name: 'assignment_submission_status',
                    title: this.trans('admin.label.status'),
                    sortField: 'assignment_submission_status',
                    searchable: false,
                    sortable: false,
                    formatter (value) {
                        let status = ''
                        switch (value) {
                            case 0:
                                status = 'Pending'
                                break;
                            case 1:
                                status = 'Approved'
                                break;
                            case 2:
                                status = 'Rejected'
                                break;
                        
                            default:
                                break;
                        }
                        return status
                    }
                },
                {
                    name: 'action-slot',
                    title: this.trans('admin.label.action'),
                    searchable: false,
                    data: [
                        {
                            class: 'btn btn_sm btn_success mr_5',
                            title: this.trans('admin.label.approve'),
                            action: 'approve',
                            condition: ['admin_action_button_show', false]
                        },
                        {
                            class: 'btn btn_sm btn_danger',
                            title: this.trans('admin.label.reject'),
                            action: 'reject',
                            condition: ['admin_action_button_show', false]
                        }
                    ]
                }
            ],
            sortOrder: []
        }
    },
    methods: {
        approve(student) {
            this.$swal({
                title: this.trans('admin.label.approve_confirmation'),
                text: this.trans('admin.label.warning'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: this.trans('admin.label.yes_approve'),
                cancelButtonText: this.trans('admin.label.no_cancel'),
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post(`/api/admin/lectures/assignments/${this.$route.params.assignment_id}/students/${student.id}/approveOrReject`,{status: 1}).then(() => {
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
        reject(student) {
            this.$swal({
                title: this.trans('admin.label.reject_confirmation'),
                text: this.trans('admin.label.warning'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: this.trans('admin.label.yes_reject'),
                cancelButtonText: this.trans('admin.label.no_cancel'),
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post(`/api/admin/lectures/assignments/${this.$route.params.assignment_id}/students/${student.id}/approveOrReject`,{status: 2}).then(() => {
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
