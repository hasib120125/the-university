<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ trans('professor.form.subject.subject_overview') }}</div>
                </div>
                <div class="card-body" v-if="subject">
                    <table class="table table_bordered table_center table_fixed">
                        <tr>
                            <th>{{ trans('professor.form.subject.name') }}</th>
                            <td>{{ subject.name }}</td>
                            <th>{{ trans('professor.form.subject.code') }}</th>
                            <td>{{ subject.code }}</td>
                            <th>{{ trans('professor.form.subject.credit') }}</th>
                            <td>{{ subject.credit }}</td>
                            <th>{{ trans('professor.form.subject.department') }}</th>
                            <td>{{ subject.allDepartmentsName }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TableComponent from "./../../../components/TableComponent";

export default {
    components: {
        TableComponent
    },
    data() {
        return {
            subject: null,
            fields: [
                {
                    name: 'year',
                    title: this.trans('professor.form.semester.year'),
                    sortField: 'year',
                    searchable: true
                },
                {
                    name: 'season_name',
                    title: this.trans('professor.form.semester.season'),
                    searchable: false
                },
                {
                    name: 'action-slot',
                    title: this.trans('professor.label.action'),
                    searchable: false,
                    data: [
                        {
                            class: 'btn btn_sm btn_info mr_5',
                            title: this.trans('professor.label.view_subject_plan'),
                            route: 'subject_plan',
                            params: {semester_id: 'id'}
                        }
                    ]
                }
            ],
            sortOrder: [
                {
                    field: 'year',
                    direction: 'desc'
                }
            ]
        }
    },
    created() {
        axios.get('/api/professor/subjects/' + this.$route.params.id)
            .then((response) => { this.subject = response.data.data })
    },
}
</script>
