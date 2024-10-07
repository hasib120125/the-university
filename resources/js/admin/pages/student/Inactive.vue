<template>
    <div>
        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-body">
                        <router-link :to="{ name: 'students_add' }" class="btn btn_info">{{ trans('admin.form.student.add_new_student') }}</router-link>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ trans('common.index.pending') }} - {{ trans('admin.form.student.student') }}</div>
                    </div>
                    <div class="card-body">
                        <table-component api-url="/api/admin/in-active-students"
                                         :fields="fields"
                                         ref="tableComponent"
                                         :sort-order="sortOrder"
                                         @delete="deleteItem"
                                         @activate="activate"
                                         >
                        </table-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TableComponent from "./../../components/TableComponent";
export default {
    components: {
        TableComponent
    },
    data() {
        return {
            fields: [
                {
                    name: 'student_no',
                    title: this.trans('admin.form.student.student_no'),
                    sortField: 'student_no',
                    searchable: true
                },
                {
                    name: this.locale === 'en' ? 'name_english' : 'name_hangul',
                    title: this.trans('admin.form.active_students.name'),
                    sortField: this.locale === 'en' ? 'name_english' : 'name_hangul',
                    searchable: true
                },
                {
                    name: 'department.name',
                    title: this.trans('admin.form.department.department'),
                    sortField: 'department.name',
                    searchable: true
                },
                {
                    name: 'semester',
                    title: this.trans('admin.form.semester.semester'),
                    sortable: false,
                    searchable: false,
                    formatter (value) {
                        if(value){
                            return value.year + ' - ' + value.season_name
                        }
                        return ''
                    }
                },
                {
                    name: 'status_text',
                    title: this.trans('admin.form.student.state'),
                    sortField: 'status_text'
                },
                {
                    name: 'email',
                    title: this.trans('admin.form.student.email'),
                    sortField: 'email',
                    searchable: true
                },
                {
                    name: 'mobile',
                    title: this.trans('admin.form.student.contact'),
                    sortField: 'mobile',
                    searchable: true
                },


                {
                    name: 'action-slot',
                    title: this.trans('admin.label.action'),
                    searchable: false,
                    data: [
                        {
                            class: 'btn btn_sm btn_success mr_5',
                            title: '<i class="fas fa-check"></i>',
                            tooltip: this.trans('admin.label.active'),
                            action: 'activate'
                        },
                        {
                            class: 'btn btn_sm btn_info mr_5',
                            title: '<i class="far fa-edit"></i>',
                            tooltip: this.trans('admin.label.edit'),
                            route: 'students_edit',
                            params: {id: 'id'}
                        },
                        {
                            class: 'btn btn_sm btn_success mr_5',
                            title: '<i class="fas fa-eye"></i>',
                            tooltip: this.trans('admin.label.details'),
                            route: 'student_details',
                            params: {id: 'id'}
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
            sortOrder: [
                {
                    direction: 'desc', 
                    field: 'created_at', 
                    sortField: 'created_at', 
                }
            ]
        }
    },
    methods: {
        activate(student){
            this.$swal({
                title: this.trans('admin.label.active_confirmation'),
                text: this.trans('admin.label.warning'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: this.trans('admin.label.yes_activate'),
                cancelButtonText: this.trans('admin.label.no_cancel'),
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.patch('/api/admin/activate-students/'+ student.id).then(() => {
                        this.$refs.tableComponent.refresh();
                        this.$swal.fire(
                            this.trans('common.message.activated'),
                            this.trans('common.message.student_activate_message'),
                            'success'
                        )
                    });
                }
            });

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
                    axios.delete('/api/admin/students/'+item.id).then(() => {
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

