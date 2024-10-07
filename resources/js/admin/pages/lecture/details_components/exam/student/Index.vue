<template>
    <div>
        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-header">
                        <div class="col_10">
                            <div class="card-title">{{ trans('admin.form.exam.student.student_list') }}</div>
                        </div>
                        <div class="col_2">
                            <div class="d_flex_end">
                                <router-link class="btn btn_sm btn_secondary mr_5" :to="{name: 'lecture_exams'}"> {{ trans('common.index.back') }} </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table-component :api-url="`/api/admin/lectures/exams/${$route.params.exam_id}/students`"
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
import TableComponent from "./../../../../../components/TableComponent";

export default {
    components: {
        TableComponent
    },
    data() {
        return {
            fields: [
                {
                    name: 'name',
                    title: this.trans('admin.form.student.name'),
                    sortField: this.locale === 'en' ? 'name_english' : 'name_hangul',
                    searchable: true
                },
                {
                    name: 'student_no',
                    title: this.trans('admin.form.student.student_no'),
                    sortField: 'student_no',
                    searchable: true
                },
                {
                    name: 'email',
                    title: this.trans('admin.form.student.email'),
                    sortField: 'email',
                    searchable: true,
                    sortable: true,
                },
                {
                    name: 'answered_questions',
                    title: this.trans('common.index.score'),
                    searchable: false,
                    sortable: false,
                    formatter (value) {
                        if(value.length == 0){
                            return '0 point'
                        }
                        let sum = value.reduce((acc, cur, i)=>acc + cur['score'],0)
                        return `${sum} points`
                    }
                },
                {
                    name: 'action-slot',
                    title: this.trans('admin.label.action'),
                    searchable: false,
                    data: [
                        {
                            class: 'btn btn_sm btn_success mr_5',
                            title: this.trans('admin.form.exam.student.exam_evaluate'),
                            route: 'lecture_exam_evaluate',
                            params: {student_id:'id'}
                        }
                    ]
                }
            ],
            sortOrder: []
        }
    },
    methods: {
        
    }
}
</script>
