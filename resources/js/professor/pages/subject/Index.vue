<template>
    <div>
        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ trans('professor.form.subject.subject') }}</div>
                    </div>
                    <div class="card-body">
                        <table-component api-url="/api/professor/subjects"
                                         :fields="fields"
                                         ref="tableComponent"
                                         :sort-order="sortOrder" >
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
                    name: 'name',
                    title: this.trans('professor.form.subject.name'),
                    sortField: 'name',
                    searchable: true
                },
                {
                    name: 'code',
                    title: this.trans('professor.form.subject.code'),
                    sortField: 'code',
                    searchable: true
                },
                {
                    name: 'credit',
                    title: this.trans('professor.form.subject.credit'),
                    sortField: 'credit',
                    searchable: true
                },
                {
                    name: 'allDepartmentsName',
                    title: this.trans('professor.form.subject.department'),
                },
                {
                    name: 'action-slot',
                    title: this.trans('professor.label.action'),
                    searchable: false,
                    data: [
                        {
                            class: 'btn btn_sm btn_success mr_5',
                            title: this.trans('professor.label.view'),
                            route: 'subject_overview',
                            params: {id: 'id'}
                        }
                    ]
                }
            ],
            sortOrder: [
                {
                    field: 'name',
                    direction: 'asc'
                }
            ]
        }
    },
    methods: {
        
    }
}
</script>
