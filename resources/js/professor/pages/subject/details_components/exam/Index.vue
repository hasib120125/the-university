<template>
    <div>
        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-body">
                        <router-link :to="{ name: 'subject_exam_add' }" class="btn btn_info">{{ trans('professor.form.exam.add_new_exam') }}</router-link>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ trans('professor.form.exam.exams') }}</div>
                    </div>
                    <div class="card-body">
                        <table-component :api-url="`/api/professor/subjects/${$route.params.id}/exams?semester_id=${$route.params.semester_id}`"
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
                    name: 'title',
                    title: this.trans('professor.form.exam.title'),
                    sortField: 'title',
                    searchable: true
                },
                {
                    name: 'start_period',
                    title: this.trans('professor.form.exam.start_period'),
                    sortField: 'start_period',
                    searchable: true
                },
                {
                    name: 'end_period',
                    title: this.trans('professor.form.exam.end_period'),
                    sortField: 'end_period',
                    searchable: true
                },
                {
                    name: 'action-slot',
                    title: this.trans('professor.label.action'),
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
                            title: this.trans('professor.label.edit'),
                            route: 'subject_exam_update',
                            params: {exam_id: 'id'}
                        },
                        {
                            class: 'btn btn_sm btn_danger',
                            title: this.trans('professor.label.delete'),
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
                title: this.trans('professor.label.delete_confirmation'),
                text: this.trans('professor.label.warning'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: this.trans('professor.label.yes_delete'),
                cancelButtonText: this.trans('professor.label.no_cancel'),
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/api/professor/lectures/${item.subject_id}/exams/${item.id}`).then(() => {
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
