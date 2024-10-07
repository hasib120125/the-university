<template>
    <div class="dashboard custom_p_40">
        <div class="container-fluid">
            <div class="row mb_15">
                <div class="col-md-12">
                    <div class="dashboard_thumbnail " v-if="user">
                        <div class="img">
                            <img :src="user.photo">
                        </div>
                        <div class="text">
                            <p>ID : {{ user.student_no }}</p>
                            <h2>{{ user.name }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb_15">
                <div class="col-md-6 m_custom_margin custom_pr_5">
                    <div class="card mb_0">
                        <div class="card_header">
                            <div class="card_title">{{ trans('new.index.notices') }}</div>
                        </div>
                        <div class="card_body">
                            <table-component api-url="/api/student/administration-notices"
                                            :fields="noticeFields"
                                            ref="tableComponent"
                                             :show-search="false"
                                            :sort-order="noticeSortOrder">
                            </table-component>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb_0 m_custom_margin">
                        <div class="card_header">
                            <div class="card_title">{{ trans('new.index.subject_notice') }}</div>
                        </div>
                        <div class="card_body">
                            <table-component :api-url="`/api/student/subject-notices`"
                                            :fields="subjectNoticeFields"
                                            ref="tableComponent"
                                            :show-search="false"
                                            :sort-order="lectureNoticeSortOrder">
                            </table-component>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb_15">
                <div class="col-lg-6 m_custom_margin custom_pr_5">
                    <div class="card">
                        <div class="card-body">
                            <calendar />
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 m_none">
                    <div class="card mb_0 m_custom_margin ">
                        <div class="card_header">
                            <div class="card_title width_full">
                                <div class="d_flex_btwn">
                                    <div>{{ trans('new.index.registered_subjects') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="card_body">
                            <table-component :api-url="'/api/student/subjects/dashboard'"
                                             :fields="subjectFields"
                                             ref="tableComponent"
                                             :show-search="false"
                                             :sort-order="subjectSortOrder">
                            </table-component>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 desktop_none ">
                    <div class="card mb_0 m_custom_margin">
                        <div class="card_header">
                            <div class="card_title width_full">
                                <div class="d_flex_btwn">
                                    <div>{{ trans('new.index.registered_subjects') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="card_body">
                            <table-component :api-url="'/api/student/subjects/dashboard'"
                                             :fields="subjectMobileFields"
                                             ref="tableComponent"
                                             :show-search="false"
                                             :sort-order="subjectSortOrder">
                            </table-component>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import TableComponent from "./../components/TableComponent";
import Calendar from "./Calendar";


export default {
    name:'dashboard',
    components: {
        TableComponent,
        Calendar
    },
    data() {
        return {
            user: null,
            time: [
                this.trans('common.index.1st_period'),
                this.trans('common.index.2nd_period'),
            ],
            activeLecture:[],
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
                            title:  '<i class="fas fa-eye"></i>',
                            tooltip:  this.trans('student.label.details'),
                            route: 'subject_notice_view',
                            params: {notice_id: 'id'}
                        }
                    ]
                }
            ],
            lectureNoticeSortOrder: [],
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
            noticeSortOrder: [],
            subjectFields: [
                {
                    name: 'subject.name',
                    title: this.trans('new.index.name'),
                    sortField: 'subject.name',
                },
                {
                    name: 'subject.code',
                    title: this.trans('new.index.code'),
                    sortField: 'subject.code',
                },
                {
                    name: 'subject.credit',
                    title: this.trans('new.index.credit'),
                    sortField: 'credit',
                },
                {
                    name: 'semester',
                    title: this.trans('new.index.semester'),
                    formatter: this.semesterFullName,
                },
                {
                    name: this.locale === 'en' ? 'subject.professor.name_english' : 'subject.professor.name_hangul',
                    title: this.trans('new.index.professor'),
                    sortField: this.locale === 'en' ? 'subject.professor.name_english' : 'subject.professor.name_hangul',
                },
                {
                    name: 'action-slot',
                    title: this.trans('new.index.action'),
                    searchable: false,
                    data: [
                        {
                            class: 'btn btn_sm btn_blue mr_5',
                            title:  '<i class="fas fa-play"></i>',
                            tooltip:  this.trans('new.index.details'),
                            route: 'subject_overview',
                            params: {id: 'id'}
                        }
                    ]
                }
            ],
            subjectMobileFields: [
                {
                    name: 'subject.name',
                    title: this.trans('new.index.name'),
                    sortField: 'subject.name',
                },
                {
                    name: this.locale === 'en' ? 'subject.professor.name_english' : 'subject.professor.name_hangul',
                    title: this.trans('new.index.professor'),
                    sortField: this.locale === 'en' ? 'subject.professor.name_english' : 'subject.professor.name_hangul',
                },
                {
                    name: 'action-slot',
                    title: this.trans('new.index.action'),
                    searchable: false,
                    data: [
                        {
                            class: 'btn btn_sm btn_blue mr_5',
                            title:  '<i class="fas fa-play"></i>',
                            tooltip:  this.trans('new.index.details'),
                            route: 'subject_overview',
                            params: {id: 'id'}
                        }
                    ]
                }
            ],
            subjectSortOrder:[
                {
                    field: 'subject.name',
                    direction: 'desc'
                }
            ],
        }
    },
    created() {
        // axios.get('/api/student/profile').then((response) => { this.user = response.data.data })
        // this.getProfile()
    },
    methods: {
        semesterFullName(semester){
            if(semester){
                return semester.year + '-' + semester.season_name
            }
            return ''
        },
        // getProfile(){
        //     axios.get('/api/student/lectures')
        //         .then((response) => {
        //             this.activeLecture = response.data.data
        //         })
        // },
    }
}
</script>
