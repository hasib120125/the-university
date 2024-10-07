<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title width_full">
                        <div class="d_flex_btwn">
                            <div>{{ trans('admin.form.student.student') }}</div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table-component :api-url="`/api/admin/lectures/${this.$route.params.id}/active-students`"
                                     :fields="fields"
                                     ref="tableComponent"
                                     :sort-order="sortOrder" @delete="deleteStudent">
                    </table-component>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TableComponent from "../../../../components/TableComponent";

export default {
    name: 'active-student-list',
    components: {
        TableComponent
    },
    data() {
        return {
            fields: [
                {
                    name: 'name',
                    title: this.trans('admin.form.active_students.name'),
                    sortField: this.locale === 'en' ? 'name_english' : 'name_hangul',
                    searchable: true
                },
                {
                    name: 'student_no',
                    title: this.trans('admin.form.active_students.student_no'),
                    sortField: 'student_no',
                    searchable: true
                },
                {
                    name: 'curriculum.name',
                    title: this.trans('admin.form.active_students.curriculum'),
                    sortField: 'curriculum.name',
                    searchable: true
                },
                {
                    name: 'grade',
                    title: this.trans('admin.form.active_students.grade'),
                    sortField: 'grade',
                    searchable: true
                },
                {
                    name: 'email',
                    title: this.trans('admin.form.active_students.email'),
                    sortField: 'email',
                    searchable: true
                },
                {
                    name: 'mobile',
                    title: this.trans('admin.form.active_students.mobile'),
                    sortField: 'mobile',
                    searchable: true
                },
                {
                    name: 'action-slot',
                    title: this.trans('admin.label.action'),
                    searchable: false,
                    data: [
                        {
                            class: 'btn btn_sm btn_danger',
                            title:this.trans('admin.label.delete'),
                            action: 'delete'
                        }
                    ]
                }
            ],
            sortOrder: [
                {
                    sortField: this.locale === 'en' ? 'name_english' : 'name_hangul',
                    direction: 'asc'
                }
            ]
        }
    },
    methods:{
        deleteStudent(student){
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
                     axios.post(`/api/admin/lectures/${this.$route.params.id}/active-students/${student.id}/delete`)
                        .then((response) => {
                            if(response.data.success){
                                this.$refs.tableComponent.refresh();
                                this.$swal.fire(
                                    this.trans('common.message.deleted'),
                                    this.trans('common.message.delete_message'),
                                    'success'
                                )
                            }
                        })
                }
            })
        },
    },
}
</script>
