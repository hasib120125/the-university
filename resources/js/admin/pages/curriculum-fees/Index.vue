<template>
    <div>
        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-body">
                        <router-link :to="{ name: 'curriculum_fees_add' }" class="btn btn_info">{{ trans('admin.form.curriculum_fees.add_curriculum_fees') }}</router-link>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ trans('admin.form.curriculum_fees.curriculum_fees') }}</div>
                    </div>
                    <div class="card-body">
                        <table-component api-url="/api/admin/curriculum-fees"
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
import TableComponent from "./../../components/TableComponent";
export default {
    components: {
        TableComponent
    },
    data() {
        return {
            fields: [
                {
                    name: 'semester.year',
                    title: this.trans('admin.form.curriculum_fees.semester'),
                    sortField: 'semester.year',
                    searchable: true
                },
                {
                    name: 'curriculum.name',
                    title: this.trans('admin.form.curriculum_fees.curriculum'),
                    sortField: 'curriculum.name',
                    searchable: true
                },
                {
                    name: 'grade',
                    title: this.trans('admin.form.curriculum_fees.grade'),
                    sortField: 'grade',
                    searchable: false
                },
                {
                    name: 'subject_fee',
                    title: this.trans('admin.form.curriculum_fees.subject_fees'),
                    sortField: 'subject_fee',
                    searchable: false,
                    formatter(value){
                        return `₩${value}`
                    }
                },
                {
                    name: 'orientation_fee',
                    title: this.trans('admin.form.curriculum_fees.orientation_fees'),
                    sortField: 'orientation_fee',
                    searchable: false,
                    formatter(value){
                        return `₩${value}`
                    }
                },
                {
                    name: 'others_fee',
                    title: this.trans('admin.form.curriculum_fees.others_fees'),
                    sortField: 'others_fee',
                    searchable: false,
                    formatter(value){
                        return `₩${value}`
                    }
                },

                {
                    name: 'action-slot',
                    title: this.trans('admin.label.action'),
                    searchable: false,
                    data: [
                        {
                            class: 'btn btn_sm btn_info mr_5',
                            title: '<i class="far fa-edit"></i>',
                            tooltip: this.trans('admin.label.edit'),
                            route: 'curriculum_fees_edit',
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
                    axios.delete('/api/admin/curriculum-fees/'+item.id).then(() => {
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

