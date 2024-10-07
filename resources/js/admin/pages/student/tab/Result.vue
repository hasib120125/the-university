<template>
    <div>
        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-body" v-if="semesterWiseGrades">
                        <template v-for="(semesterWiseGrade, semesterWiseGradeIndex) in semesterWiseGrades">
                            <div class="table-responsive" :key="semesterWiseGradeIndex">
                                <table class="table table_bordered table_fixed table_center">
                                    <thead>
                                        <tr>
                                            <th width="15%">{{ trans('admin.form.semester.semester') }}</th>
                                            <th width="20%">{{ trans('admin.form.subject.subject') }}</th>
                                            <th width="8%">{{ trans('admin.form.grade_input.middle') }}</th>
                                            <th width="13%">{{ trans('admin.form.grade_input.end_of_term') }}</th>
                                            <th width="8%">{{ trans('admin.form.grade_input.etc') }}</th>
                                            <th width="8%">{{ trans('admin.form.grade_input.attendance') }}</th>
                                            <th width="12%">{{ trans('admin.form.grade_input.total_score') }}</th>
                                            <th width="8%">{{ trans('admin.form.grade_input.grade') }}</th>
                                            <th width="8%">{{ trans('admin.form.grade_input.grades') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(result, resultIndex) in semesterWiseGrade" :key="'grade_student'+resultIndex">
                                            <td>{{ result.semester_year }} - {{ result.season_name }}</td>
                                            <td>{{ result.subject_name }}</td>
                                            <td>
                                                <div class="d_flex_inline">
                                                    <span class="fw_bold font_12p"> {{ result.middle }}</span>
                                                    <span class="fw_bold font_12p" v-if="result.subject_plan"> / {{ result.subject_plan.middle_mark }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d_flex_inline">
                                                    <span class="fw_bold font_12p"> {{ result.ending }}</span>
                                                    <span class="fw_bold font_12p" v-if="result.subject_plan"> / {{ result.subject_plan.ending_mark }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d_flex_inline">
                                                    <span class="fw_bold font_12p"> {{ result.etc }}</span>
                                                    <span class="fw_bold font_12p" v-if="result.subject_plan"> / {{ result.subject_plan.etc_mark }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d_flex_inline">
                                                    <span class="fw_bold font_12p"> {{ result.grade ? result.attendance : 0}}</span>
                                                    <span class="fw_bold font_12p" v-if="result.subject_plan"> / {{ result.subject_plan.attendance_mark }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d_flex_inline">
                                                    <span class="fw_bold font_12p"> {{ result.score }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span v-if="result.subject_id == 9">
                                                    <span v-if="result.pass">P</span>
                                                    <span v-else>NP</span>
                                                </span>
                                                <span v-else>{{ result.grade }}</span>
                                            </td>
                                            <td><span v-if="result.subject_id != 9">{{ result.grades }}</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </template>
                    </div>
                    <div class="card-body" v-else>
                        <div class="table-responsive">
                            <table class="table table_bordered table_fixed table_center">
                                <thead>
                                    <tr>
                                        <th>{{ trans('admin.form.semester.semester') }}</th>
                                        <th>{{ trans('admin.form.subject.subject') }}</th>
                                        <th>{{ trans('admin.form.grade_input.middle') }}</th>
                                        <th>{{ trans('admin.form.grade_input.end_of_term') }}</th>
                                        <th>{{ trans('admin.form.grade_input.etc') }}</th>
                                        <th>{{ trans('admin.form.grade_input.attendance') }}</th>
                                        <th>{{ trans('admin.form.grade_input.attendance_rate') }}</th>
                                        <th>{{ trans('admin.form.grade_input.grade') }}</th>
                                        <th>{{ trans('admin.form.grade_input.grades') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="9">{{ trans('common.index.no_data') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    components: {

    },
    data() {
        return {
            semesterWiseGrades: null,
        }
    },
    created(){
        this.getData()
    },
    methods: {
        getData(){
            axios.get('/api/admin/student-result/'+ this.$route.params.id)
                    .then((response) => {
                        this.semesterWiseGrades = response.data.data
                    })
        },
    }
}
</script>

