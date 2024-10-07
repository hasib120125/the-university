<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-body">
                    <calendar/>
                </div>
            </div>
        </div>
        <div class="col_6">
            <div class="card">
                <div class="card-header">
                    <div class="card_title">{{ trans('new.index.notices') }}</div>
                </div>
                <div class="card-body">
                    <table-component api-url="/api/professor/administration-notices"
                                     :fields="noticeFields"
                                     ref="tableComponent"
                                     :show-search="false"
                                     :sort-order="noticeSortOrder">
                    </table-component>
                </div>
            </div>
        </div>
        <div class="col_6">
            <div class="card">
                <div class="card-header">
                    <div class="card_title">{{ trans('new.index.subject_notice') }}</div>
                </div>
                <div class="card-body">
                    <table-component :api-url="`/api/professor/subject-notices`"
                                     :fields="subjectNoticeFields"
                                     ref="tableComponent"
                                     :show-search="false"
                                     :sort-order="subjectNoticeSortOrder">
                    </table-component>
                </div>
            </div>
        </div>
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

</template>

<script>
import Calendar from "./Calendar";
import TableComponent from "../components/TableComponent";

export default {
    components: {
        Calendar, TableComponent
    },
    data() {
        return {
            subjectNoticeFields: [
                {
                    name: 'subject.name',
                    title: this.trans('new.index.subject_name'),
                    sortField: 'subject.name',
                    sortable: false,
                    searchable: true
                },
                {
                    name: 'title',
                    title: this.trans('student.label.title'),
                    sortField: 'title',
                    sortable: false,
                    searchable: true
                },
                {
                    name: 'action-slot',
                    title: this.trans('student.label.action'),
                    searchable: false,
                    data: [
                        {
                            class: 'btn btn_sm btn_blue mr_5',
                            title: '<i class="fas fa-eye"></i>',
                            tooltip: this.trans('student.label.details'),
                            route: 'dash_subject_notice_view',
                            params: {notice_id: 'id'}
                        }
                    ]
                }
            ],
            subjectNoticeSortOrder: [],
            noticeSortOrder: [],
            noticeFields: [
                {
                    name: 'subject',
                    title: this.trans('new.index.subject'),
                    sortField: 'subject',
                    searchable: true
                },
                {
                    name: 'action-slot',
                    title: this.trans('student.label.action'),
                    searchable: false,
                    data: [
                        {
                            class: 'btn btn_sm btn_blue mr_5',
                            title: '<i class="fas fa-eye"></i>',
                            tooltip: this.trans('student.label.details'),
                            route: 'administration_notice_view',
                            params: {notice_id: 'id'}
                        }
                    ]
                }
            ],
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
    created() {

    },
    mounted() {

    },
    computed: {},
    methods: {}
}
</script>
