<template>
    <div class="modal " :class="{ 'open_modal': showModal}"  data-modal="modal">
        <div class="modal_overlay" data-modal-close="modal" @click="closeModal"></div>
        <div class="modal_inner">
            <div class="modal_header">
                <span data-modal-close="modal" class="close_icon close_icon_sm" @click="closeModal">×</span>
                <h2  v-if="student">{{ student.name }} - {{ trans('common.index.result') }}</h2>
            </div>
            <div class="modal_wrapper ">
                <div class="modal_content modal_1080p" v-if="semesterWiseGrades">
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
                                        <th width="12%">{{ trans('admin.form.grade_input.attendance_rate') }}</th>
                                        <th width="8%">{{ trans('admin.form.grade_input.grade') }}</th>
                                        <th width="8%">{{ trans('admin.form.grade_input.grades') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(result, resultIndex) in semesterWiseGrade" :key="'grade_student'+resultIndex">
                                        <td>{{ result.semester.year }} - {{ result.semester.season_name }}  </td>
                                        <td>{{ result.subject.name }}</td>
                                        <td>
                                            <div class="d_flex_inline" v-if="result.subject_plan">
                                                <span class="fw_bold font_12p"> {{ result.middle }}</span>
                                                <span class="fw_bold font_12p"> / {{ result.subject_plan.middle_mark }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d_flex_inline" v-if="result.subject_plan">
                                                <span class="fw_bold font_12p"> {{ result.ending }}</span>
                                                <span class="fw_bold font_12p"> / {{ result.subject_plan.ending_mark }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d_flex_inline" v-if="result.subject_plan">
                                                <span class="fw_bold font_12p"> {{ result.etc }}</span>
                                                <span class="fw_bold font_12p"> / {{ result.subject_plan.etc_mark }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d_flex_inline" v-if="result.subject_plan">
                                                <span class="fw_bold font_12p"> {{ result.attendance }}</span>
                                                <span class="fw_bold font_12p"> / {{ result.subject_plan.attendance_mark }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d_flex_inline">
                                                <span class="fw_bold font_12p"> {{ result.attendance_rate }}</span>
                                                <span class="ml_5">%</span>
                                            </div>
                                        </td>
                                        <td>{{ result.grade }}</td>
                                        <td>{{ result.grades }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </template>
                </div>
                <div class="modal_content" v-else>
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
</template>

<script>

export default {
    props: {
        showModal: {
            type: Boolean,
            default: false,
        },
        studentId: {
            type: Number,
            required: true,
            default: ''
        }
    },
    data() {
        return {
            semesterWiseGrades: null,
            student: null,
        }
    },
    created(){
        axios.get('/api/admin/students/'+ this.studentId)
                    .then((response) => {
                        this.student = response.data.data
                    })

        this.getData()
    },
    methods: {
        getData(){
            axios.get('/api/admin/student-result/'+ this.studentId)
                    .then((response) => {
                        this.semesterWiseGrades = response.data.data
                    })
        },
        closeModal() {
            this.$emit('closeModal');
        },
    }
}
</script>

