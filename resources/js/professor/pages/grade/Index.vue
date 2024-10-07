<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title width_full">
                        <div class="d_flex_btwn">
                            <div> {{ trans('professor.form.grade_input.grade_input') }}</div>
                        </div>
                    </div>
                </div>
                <div :class="['card-body', {'loading_overlay': loading}]">
                    <div class="d_flex_inline mb_15">
                        <select class="form_global mr_10" v-model="search.department_id">
                            <option value="">--{{ trans('professor.form.grade_input.department') }}--</option>
                            <option v-for="(department, i) in departments" :key="'department_'+i" :value="department.id">
                                    {{ department.name }}</option>
                        </select>
                        <select class="form_global mr_10" v-model="search.subject_id">
                            <option value="">--{{ trans('professor.form.subject.subject') }}--</option>
                            <option v-for="(subject, i) in subjects" :key="'subject_'+i" :value="subject.id">
                                    {{ subject.name }}</option>
                        </select>
                        <select class="form_global mr_10" v-model="search.type">
                            <option value="1">{{ trans('professor.form.grade_input.name') }}</option>
                            <option value="2">{{ trans('professor.form.grade_input.id') }}</option>
                        </select>
                        <input type="text" class="form_global mr_10" v-model="search.q" >
                        <button class="btn btn_md btn_success" @click.prevent="getActiveStudent">{{ trans('professor.form.grade_input.search') }}</button>
                    </div>
                    <table class="table table_bordered table_fixed table_center" :class="{'table_center': studentGrades.length > 0}">
                        <thead>
                            <tr>
                                <th width="40px">{{ trans('common.index.sl') }}</th>
                                <th>{{ trans('professor.form.semester.semester') }}</th>
                                <th width="80px">{{ trans('common.index.id') }}</th>
                                <th>{{ trans('professor.form.grade_input.name') }}</th>
                                <th>{{ trans('professor.form.grade_input.department') }}</th>
                                <th>{{ trans('professor.form.subject.subject') }}</th>
                                <th width="115px">{{ trans('professor.form.grade_input.middle') }}</th>
                                <th width="115px">{{ trans('professor.form.grade_input.end_of_term') }}</th>
                                <th width="115px">{{ trans('professor.form.grade_input.etc') }}</th>
                                <th width="115px">{{ trans('professor.form.grade_input.attendance') }}</th>
                                <th width="140px">{{ trans('professor.form.grade_input.attendance_rate') }}</th>
                                <th width="60px">{{ trans('professor.form.grade_input.grade') }}</th>
                                <th width="65px">{{ trans('professor.form.grade_input.grades') }}</th>
                            </tr>
                        </thead>
                        <tbody v-if="studentGrades.length > 0">
                            <tr v-for="(grade, gradeIndex) in studentGrades" :key="'grade_student'+gradeIndex">
                                <template v-if="grade.subject_plan">
                                    <td>{{ gradeIndex+1 }}</td>
                                    <td>{{ grade.semester.year }}- {{ grade.semester.season_name }}</td>
                                    <td>{{ grade.student.student_no }}</td>
                                    <td>{{ grade.student.name }}</td>
                                    <td>{{ grade.student.department ? grade.student.department.name : '-' }}</td>
                                    <td>{{ grade.subject.name }}</td>
                                    <td>
                                        <div class="d_flex_btwn">
                                            <div class="d_flex_start">
                                                <input type="number" min="0" class="form_global width_60p" v-model="studentGrades[gradeIndex].middle">
                                                <span class="ml_15 white_space_nowrap fw_bold font_12p"> / {{ grade.subject_plan.middle_mark }}</span>
                                            </div>
                                            <v-errors :errors="errorFor(`studentGrades.${gradeIndex}.middle`)"></v-errors>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d_flex_btwn">
                                            <div class="d_flex_start">
                                                <input type="number" min="0" class="form_global width_60p" v-model="studentGrades[gradeIndex].ending">
                                                <span class="ml_15 white_space_nowrap fw_bold font_12p"> / {{ grade.subject_plan.ending_mark }}</span>
                                            </div>
                                            <v-errors :errors="errorFor(`studentGrades.${gradeIndex}.ending`)"></v-errors>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d_flex_btwn">
                                            <div class="d_flex_start">
                                                <input type="number" min="0" class="form_global width_60p" v-model="studentGrades[gradeIndex].etc">
                                                <span class="ml_15 white_space_nowrap fw_bold font_12p"> / {{ grade.subject_plan.etc_mark }}</span>
                                            </div>
                                            <v-errors :errors="errorFor(`studentGrades.${gradeIndex}.etc`)"></v-errors>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw_bold font_12p"> {{ studentGrades[gradeIndex].attendance }}</span>
                                        <span class="fw_bold font_12p"> / {{ grade.subject_plan.attendance_mark }}</span>
                                    </td>
                                    <td>
                                        <span class=""> {{ studentGrades[gradeIndex].attendance_rate }} %</span>
                                    </td>
                                    <td>{{ studentGrades[gradeIndex].grade }}</td>
                                    <td>{{ studentGrades[gradeIndex].grades }}</td>
                                </template>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td colspan="13">{{ trans('common.index.no_relevant_data') }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="d_flex_end" v-if="studentGrades.length > 0">
                        <button class="btn btn_md btn_success" @click.prevent="submitForm">{{ trans('professor.label.save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import validationErrors from "../../mixins/validationErrors";

export default {
    name:'student-grade-input',
    mixins: [validationErrors],
    data() {
        return {
            loading: false,
            studentGrades:[],
            search: {
                department_id: '',
                subject_id: '',
                grade: '',
                type: 1,//1 for name, 2 for id
                q: '',
            },
            departments: [],
            subjects: [],
        }
    },
    created() {
        axios.get('/api/professor/departments')
            .then((response) => {
                this.departments = response.data.data;
            })

        axios.get('/api/professor/subjects')
            .then((response) => {
                this.subjects = response.data.data;
            })
    },
    methods:{
        getActiveStudent(){
            axios.get(`/api/professor/grades`,{
                    params: this.search
                })
                .then((response) => {
                    this.studentGrades = response.data.data
                })
        },
        submitForm(){
            this.loading = true;
            this.errors = null;

            let formData = {};
            formData.studentGrades = this.studentGrades

            axios.post('/api/professor/grades', formData)
                .then((response) => {
                    this.$swal.fire(
                        this.trans('common.message.updated'),
                        this.trans('common.message.update_message'),
                        'success'
                    )
                    this.getActiveStudent()
                })
                .catch((err) => this.errors = err.response.data.errors)
                .finally(() => this.loading = false);
        }
    },
}
</script>
<style scoped>
    .white_space_nowrap {
        white-space: nowrap;
    }
</style>
