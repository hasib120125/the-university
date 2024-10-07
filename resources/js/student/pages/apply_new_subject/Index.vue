<template>
    <div class="lecture_apply custom_p_40">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card_header">
                            <div class="card_title width_full">
                                <div class="d_flex_btwn" v-if="student">
                                    <div>{{ trans('new.index.available_credit') }} - {{ student.available_credit }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="card_body">
                            <div class="row">
                                <div class="col-md-12 mb_15">
                                    <div class="card">
                                        <div class="card_body">
                                            <table-component :api-url="'/api/student/all-subjects'"
                                                            :fields="fields"
                                                            ref="tableComponent"
                                                            :sort-order="sortOrder"
                                                            @applySubject="applySubject">
                                            </table-component>
                                        </div>
                                    </div>
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
import TableComponent from "../../components/TableComponent.vue";

export default {
    name: 'apply-new-lecture',
    components: { TableComponent },
    data() {
        return {
            fields: [
                {
                    name: 'name',
                    title: this.trans('new.index.name'),
                    sortField: 'name',
                    sortable: true,
                    searchable: true
                },
                {
                    name: 'code',
                    title: this.trans('new.index.code'),
                    sortField: 'code',
                    sortable: true,
                    searchable: true
                },
                {
                    name: 'credit',
                    title: this.trans('new.index.credit'),
                    sortField: 'credit',
                    sortable: true,
                    searchable: true
                },
                {
                    name: 'action-slot',
                    title: this.trans('student.label.action'),
                    searchable: false,
                    data: [
                        {
                            class: 'btn btn_sm btn_blue mr_5',
                            title:  this.trans('new.index.apply'),
                            action: 'applySubject',
                        }
                    ]
                }
            ],
            sortOrder: [
                {
                    field: 'name',
                    direction: 'asc'
                }
            ],
            student: null,
        }
    },
    created() {
        this.getStudentData()
    },
    methods:{
        getStudentData(){
            axios.get('/api/student/profile')
                .then((response) => {
                    this.student = response.data.data;
                })
        },
        applySubject(subject) {
            this.errors = null;

            if(subject.credit > this.student.available_credit){
                this.$swal.fire(
                    this.trans('common.message.error'),
                    this.trans('common.message.low_credit_error'),
                    'error'
                )
                return
            }

            this.$swal({
                title: this.trans('new.index.apply_subject_message'),
                text: this.trans('new.index.apply_subject_message_sub'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: this.trans('new.index.apply_alert'),
                cancelButtonText: this.trans('new.index.cancel'),
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/api/student/subject/apply', {subject_id: subject.id}).then((response) => {
                        if(response.data.error === 'subject_full'){
                            this.$swal.fire(
                                this.trans('common.message.error'),
                                response.data.message,
                                'error'
                            )
                        }
                        else if(response.data.error === 'low_credit'){
                            this.$swal.fire(
                                this.trans('common.message.error'),
                                this.trans('common.message.low_credit_error'),
                                'error'
                            )
                        }
                        else if(response.data.error === 'exist_list'){
                            this.$swal.fire(
                                this.trans('student.label.failed'),
                                this.trans('student.label.subject_submit_failed_message'),
                                'error'
                            )
                        }else{
                            this.$swal.fire(
                                this.trans('new.index.submitted'),
                                this.trans('new.index.sucessfull_apply'),
                                'success'
                            )

                            this.getStudentData()
                            this.$refs.tableComponent.refresh()
                        }
                    })
                }
            });
        }
    },
}
</script>
