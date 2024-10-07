<template>
    <div>
        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-body">
                        <router-link :to="{ name: 'lecture_major_add' }" class="btn btn_info">{{ trans('admin.form.majors.add') }}</router-link>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ trans('admin.form.majors.lecture_major') }}</div>
                    </div>
                    <div class="card-body">
                        <table-component :api-url="`/api/admin/lectures/${$route.params.id}/majors`"
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
                    name: 'name',
                    title: this.trans('admin.form.majors.department'),
                    sortField: 'name',
                    searchable: true
                },
                {
                    name: 'name',
                    title: this.trans('admin.form.majors.course_target'),
                    sortField: 'name',
                    searchable: false,
                    formatter (value) {
                        return 'Grade'
                    }
                },
                {
                    name: 'major_category',
                    title: this.trans('admin.form.majors.major_category'),
                    sortField: 'name',
                    searchable: false,
                    formatter (value) {
                        let majorCategory = ['Common essentials', 'Major required', 'Selection']
                        return majorCategory[value - 1]
                    }
                },
                {
                    name: 'action-slot',
                    title: this.trans('admin.label.action'),
                    searchable: false,
                    data: [
                        {
                            class: 'btn btn_sm btn_info mr_5',
                            title:  this.trans('admin.label.edit'),
                            route: 'lecture_major_update',
                            params: {major_id: 'major_id'}
                        },
                        {
                            class: 'btn btn_sm btn_danger',
                            title:  this.trans('admin.label.delete'),
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
                    axios.delete(`/api/admin/lectures/${this.$route.params.id}/majors/${item.major_id}`).then(() => {
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
