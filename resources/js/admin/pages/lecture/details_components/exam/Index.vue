<template>
    <div>
        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-body">
                        <router-link :to="{ name: 'lecture_exam_add' }" class="btn btn_info">{{ trans('admin.form.exam.add_new_exam') }}</router-link>
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
                        <table-component :api-url="`/api/admin/lectures/${$route.params.id}/exams`"
                                         :fields="fields"
                                         ref="tableComponent"
                                         :sort-order="sortOrder" @delete="deleteItem">
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
    components: {
        TableComponent
    },
    data() {
        return {
            fields: [
                {
                    name: 'test_title',
                    title: this.trans('admin.form.exam.exams'),
                    sortField: 'test_title',
                    searchable: true
                },
                {
                    name: 'number_of_question',
                    title: this.trans('admin.form.exam.number_of_questions'),
                    sortField: 'number_of_question',
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
                            route: 'lecture_exam_students',
                            params: {exam_id: 'id'}
                        },
                        {
                            class: 'btn btn_sm btn_success mr_5',
                            title: this.trans('common.index.questions'),
                            route: 'lecture_exam_questions',
                            params: {exam_id: 'id'}
                        },
                        {
                            class: 'btn btn_sm btn_info mr_5',
                            title: '<i class="far fa-edit"></i>',
                            tooltip: this.trans('admin.label.edit'),
                            route: 'lecture_exam_update',
                            params: {exam_id: 'id'}
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
            sortOrder: []
        }
    },
    methods: {
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
                    axios.delete(`/api/admin/lectures/${item.lecture_id}/exams/${item.id}`).then(() => {
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
