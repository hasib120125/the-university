<template>
    <div>
        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ trans('common.index.reg_open') }}</div>
                    </div>
                    <div class="card-body">
                        <table-component api-url="/api/admin/registration-open"
                                         :fields="fields"
                                         ref="tableComponent"
                                         :sort-order="sortOrder">
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
                    name: 'semester',
                    title: this.trans('admin.form.semester.semester'),
                    sortable: false,
                    searchable: false,
                    formatter (value) {
                        return value.year + ' - ' + value.season_name
                    }
                },
                {
                    name: 'start_date',
                    title: this.trans('common.index.start_date'),
                },
                {
                    name: 'end_date',
                    title: this.trans('common.index.end_date'),
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
                            route: 'registration_open_edit',
                            params: {id: 'id'}
                        },
                    ]
                }
            ],
            sortOrder: [

            ]
        }
    },
    methods: {

    }
}
</script>
