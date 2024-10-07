<template>
    <div>
        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-body">
                        <router-link :to="{ name: 'lecture_management_add' }" class="btn btn_info">{{ trans('admin.form.lecture_management.add_new_lecture_material') }}</router-link>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ trans('admin.form.lecture_management.lecture_management') }}</div>
                    </div>
                    <div class="card-body">
                        <table-component :api-url="`/api/admin/lectures/${$route.params.id}/managements`"
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
                    name: 'lecture_number',
                    title: this.trans('admin.form.lecture_management.lecture_no'),
                    sortField: 'lecture_number',
                    searchable: false
                },
                {
                    name: 'lecture_name',
                    title: this.trans('admin.form.lecture_management.lecture_title'),
                    sortField: 'lecture_name',
                    searchable: true
                },
                {
                    name: this.locale === 'en' ? 'lecture.professor.name_english' : 'lecture.professor.name_hangul',
                    title: this.trans('admin.form.lecture_management.professor_in_charge'),
                    sortField: this.locale === 'en' ? 'lecture.professor.name_english' : 'lecture.professor.name_hangul',
                    searchable: true
                },
                {
                    name: 'start_period',
                    title: this.trans('admin.form.lecture_management.start_period'),
                    sortField: 'start_period',
                    searchable: true
                },
                {
                    name: 'end_period',
                    title: this.trans('admin.form.lecture_management.end_period'),
                    sortField: 'end_period',
                    searchable: true
                },
                {
                    name: 'convert_status',
                    title: this.trans('admin.form.lecture_management.convert_status'),
                    sortField: 'convert_status',
                    searchable: true
                },
                {
                    name: 'action-slot',
                    title: this.trans('admin.label.action'),
                    searchable: false,
                    data: [
                        {
                            class: 'btn btn_sm btn_success mr_5',
                            title: '<i class="fas fa-eye"></i>',
                            tooltip: this.trans('admin.label.view'),
                            route: 'lecture_management_view',
                            params: {management_id: 'id'}
                        },
                        {
                            class: 'btn btn_sm btn_info mr_5',
                            title: '<i class="far fa-edit"></i>',
                            tooltip: this.trans('admin.label.edit'),
                            route: 'lecture_management_update',
                            params: {management_id: 'id'}
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
                    axios.delete(`/api/admin/lectures/${item.lecture_id}/managements/${item.id}`).then(() => {
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
