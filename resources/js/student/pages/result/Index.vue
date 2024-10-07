<template>
    <div class="container-fluid custom_p_40">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body" v-if="semesterWiseGrades">
                        <template v-for="(semesterWiseGrade, semesterWiseGradeIndex) in semesterWiseGrades">
                            <template>
                                <template v-if="(semesterId(semesterWiseGrade ? semesterWiseGrade[0] : null) == settings.id  && moment() > moment(settings.grade_period)) || (semesterId(semesterWiseGrade ? semesterWiseGrade[0] : null) != settings.id)">
                                    <div class="table-responsive" :key="semesterWiseGradeIndex">
                                        <table class="table table_bordered table_center white_space_nowrap">
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
                                                    <th width="8%">{{ trans('admin.form.grade_input.pass') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(result, resultIndex) in semesterWiseGrade" :key="'grade_student'+resultIndex">
                                                    <td>{{ result.semester_year }} - {{ result.season_name }}  </td>
                                                    <td>{{ result.subject_name }}</td>
                                                    <td>
                                                        <div class="d_flex_inline" v-if="result.subject_id != '9'">
                                                            <span class="fw_bold font_12p"> {{ result.middle }}</span>
                                                            <span class="fw_bold font_12p"  v-if="result.subject_plan"> / {{ result.subject_plan.middle_mark }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d_flex_inline" v-if="result.subject_id != '9'">
                                                            <span class="fw_bold font_12p"> {{ result.ending }}</span>
                                                            <span class="fw_bold font_12p" v-if="result.subject_plan"> / {{ result.subject_plan.ending_mark }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d_flex_inline" v-if="result.subject_id != '9'">
                                                            <span class="fw_bold font_12p"> {{ result.etc }}</span>
                                                            <span class="fw_bold font_12p"  v-if="result.subject_plan"> / {{ result.subject_plan.etc_mark }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d_flex_inline">
                                                            <span class="fw_bold font_12p"> {{ result.attendance }}</span>
                                                            <span class="fw_bold font_12p" v-if="result.subject_plan"> / {{ result.subject_plan.attendance_mark }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d_flex_inline" v-if="result.subject_id != '9'">
                                                            <span class="fw_bold font_12p"> {{ result.score }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span v-if="result.subject_id != '9'">{{ result.grade }}</span>
                                                    </td>
                                                    <td>
                                                        <span v-if="result.subject_id != '9'">{{ result.grades }}</span>
                                                    </td>
                                                    <td>
                                                        <span v-if="result.pass">P</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </template>
                            </template>
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
                                        <th>{{ trans('admin.form.grade_input.pass') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="10">{{ trans('common.index.no_data') }}</td>
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
            settings: null
        }
    },
    created(){
        axios.get('/api/settings')
            .then((response) => {
                this.settings = response.data.data.current_semester_id ? response.data.data.current_semester_id : null
            })
        this.getData()
    },
    methods: {
        getData(){
            axios.get('/api/student/result')
                .then((response) => {
                    this.semesterWiseGrades = response.data.data
                })
        },
        semesterId(semester){
            if(semester){
                return semester.semester_id
            }
            return null;
        }
    }
}
</script>

