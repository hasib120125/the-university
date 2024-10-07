<template>
    <div>
        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-body">
                        <router-link :to="{ name: 'tuition_fees_add' }" class="btn btn_info">{{ trans('admin.form.student_tuition_fees.add_tuition_fees') }}</router-link>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ trans('admin.form.student_tuition_fees.student_tuition_fees') }}</div>
                    </div>
                    <div class="card-body">
                        <table-component api-url="/api/admin/student-tuition-fees"
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
                    name: this.locale === 'en' ? 'student.name_english' : 'student.name_hangul',
                    title: this.trans('admin.form.student_tuition_fees.student'),
                    sortField: this.locale === 'en' ? 'student.name_english' : 'student.name_hangul',
                    searchable: true
                },
                {
                    name: 'tuition_fee',
                    title: this.trans('admin.form.student_tuition_fees.tuition'),
                    sortField: 'tuition_fee',
                    searchable: false,
                    formatter(value){
                        return `₩${value}`
                    }
                },
                {
                    name: 'enterance_fee',
                    title: this.trans('admin.form.student_tuition_fees.enterance'),
                    sortField: 'enterance_fee',
                    searchable: false,
                    formatter(value){
                        return `₩${value}`
                    }
                },
                {
                    name: 'seminar_fee',
                    title: this.trans('admin.form.student_tuition_fees.seminar_fees'),
                    sortField: 'seminar_fee',
                    searchable: false,
                    formatter(value){
                        return `₩${value}`
                    }
                },
                {
                    name: 'student_union_fee',
                    title: this.trans('admin.form.student_tuition_fees.student_union'),
                    sortField: 'student_union_fee',
                    searchable: false,
                    formatter(value){
                        return `₩${value}`
                    }
                },
                {
                    name: 'orientation_fee',
                    title: this.trans('admin.form.student_tuition_fees.orientation'),
                    sortField: 'orientation_fee',
                    searchable: false,
                    formatter(value){
                        return `₩${value}`
                    }
                },
                {
                    name: 'deduction',
                    title: this.trans('admin.form.student_tuition_fees.deduction'),
                    sortField: 'deduction',
                    searchable: false,
                    formatter(value){
                        return `₩${value}`
                    }
                },
                {
                    name: 'scholarship',
                    title: this.trans('admin.form.student_tuition_fees.scholarship'),
                    sortField: 'scholarship',
                    searchable: true,
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
                            route: 'tuition_fees_edit',
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
                    axios.delete('/api/admin/student-tuition-fees/'+item.id).then(() => {
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

