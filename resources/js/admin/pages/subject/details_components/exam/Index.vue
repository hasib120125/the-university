<template>
    <div>
        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-body">
                        <router-link :to="{ name: 'subject_exam_add' }" class="btn btn_info">{{ trans('admin.form.exam.add_new_exam') }}</router-link>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ trans('admin.form.exam.exams') }}</div>
                    </div>
                    <div class="card-body">
                        <table-component :api-url="`/api/admin/subjects/${$route.params.id}/exams?semester_id=${$route.params.semester_id}`"
                                         :fields="fields"
                                         ref="tableComponent"
                                         :sort-order="sortOrder" 
                                         @delete="deleteItem"
                                         @clone="cloneExam"
                                         >
                        </table-component>
                    </div>
                </div>
            </div>
        </div>
        <ExamCloneModal ref="examModal" v-if="examId" :examId="examId" @valueChanged="valueChanged"/>
    </div>
</template>

<script>
import TableComponent from "./../../../../components/TableComponent"
import ExamCloneModal from "./ExamCloneModal.vue"

export default {
    components: {
        TableComponent, ExamCloneModal
    },
    data() {
        return {
            fields: [
                {
                    name: 'title',
                    title: this.trans('admin.form.exam.title'),
                    sortField: 'title',
                    searchable: true
                },
                {
                    name: 'start_period',
                    title: this.trans('admin.form.exam.start_period'),
                    sortField: 'start_period',
                    searchable: true
                },
                {
                    name: 'end_period',
                    title: this.trans('admin.form.exam.end_period'),
                    sortField: 'end_period',
                    searchable: true
                },
                {
                    name: 'action-slot',
                    title: this.trans('admin.label.action'),
                    searchable: false,
                    data: [
                        {
                            class: 'btn btn_sm btn_success mr_5',
                            title: this.trans('common.index.students'),
                            route: 'subject_exam_students',
                            params: {exam_id: 'id'}
                        },
                        {
                            class: 'btn btn_sm btn_info mr_5',
                            title: '<i class="far fa-edit"></i>',
                            tooltip: this.trans('admin.label.edit'),
                            route: 'subject_exam_update',
                            params: {exam_id: 'id'}
                        },
                        {
                            class: 'btn btn_sm btn_success mr_5',
                            title: '<i class="fas fa-clone"></i>',
                            tooltip: this.trans('admin.label.clone'),
                            action: 'clone'
                        },
                        {
                            class: 'btn btn_sm btn_danger',
                            title: '<i class="far fa-trash-alt"></i>',
                            tooltip: this.trans('admin.label.delete'),
                            action: 'delete'
                        }
                    ]
                }
            ],
            sortOrder: [],
            examId: null
        }
    },
    methods: {
        valueChanged(changed){
            if(changed){
                this.$refs.tableComponent.refresh();
            }
        },
        cloneExam(exam){
            this.examId = exam.id
            setTimeout(() => {
                this.$refs.examModal.show()
            }, 50)
        },
        deleteItem(item) {
            this.$swal({
                title: this.trans('admin.label.delete_confirmation'),
                text: this.trans('admin.label.warning'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: this.trans('admin.label.yes_delete'),
                cancelButtonText: this.trans('admin.label.no_cancel'),
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/api/admin/subjects/${item.subject_id}/exams/${item.id}`).then(() => {
                        this.$refs.tableComponent.refresh();
                        this.$swal.fire(
                            this.trans('common.message.deleted'),
                            this.trans('common.message.delete_message'),
                            'success'
                        )
                    });
                }
            });
        }
    }
}
</script>
