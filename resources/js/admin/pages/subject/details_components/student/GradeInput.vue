<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title width_full">
                        <div class="d_flex_btwn">
                            <div> {{ trans('admin.form.grade_input.grade_input') }}</div>
                            <button class="btn btn btn_success" @click.prevent="calculateGrades">Calculate Attendance</button>
                        </div>
                    </div>
                </div>
                <div :class="['card-body', {'loading_overlay': loading}]">
                    <table class="table table_bordered table_fixed table_center" :class="{'table_center': studentGrades.length > 0}">
                        <thead>
                            <tr>
                                <th width="40px">{{ trans('common.index.sl') }}</th>
                                <th>{{ trans('admin.form.semester.semester') }}</th>
                                <th width="80px">{{ trans('common.index.id') }}</th>
                                <th>{{ trans('admin.form.grade_input.name') }}</th>
                                <th>{{ trans('admin.form.grade_input.department') }}</th>
                                <th>{{ trans('admin.form.subject.subject') }}</th>
                                <template v-if="$route.params.id == 9">
                                    <th width="115px">{{ trans('admin.form.grade_input.attendance') }}</th>
                                    <th width="140px">{{ trans('admin.form.grade_input.attendance_rate') }}</th>
                                    <th class="align_middle" width="150px">{{ trans('admin.form.grade_input.pass') }} / {{ trans('admin.form.grade_input.non_pass') }}</th>
                                </template>
                                <template v-else>
                                    <th width="115px">{{ trans('admin.form.grade_input.middle') }}</th>
                                    <th width="115px">{{ trans('admin.form.grade_input.end_of_term') }}</th>
                                    <th width="115px">{{ trans('admin.form.grade_input.etc') }}</th>
                                    <th width="115px">{{ trans('admin.form.grade_input.attendance') }}</th>
                                    <th width="140px">{{ trans('admin.form.grade_input.attendance_rate') }}</th>
                                    <th width="60px">{{ trans('admin.form.grade_input.grade') }}</th>
                                    <th width="65px">{{ trans('admin.form.grade_input.grades') }}</th>
                                </template>
                                

                            </tr>
                        </thead>
                        <tbody v-if="checkStudentPlanAvail(studentGrades)">
                            <tr v-for="(grade, gradeIndex) in studentGrades" :key="'grade_student'+gradeIndex">
                                <template v-if="grade.subject_plan">
                                    <td>{{ gradeIndex+1 }}</td>
                                    <td>{{ semesterFullName(grade.semester) }}</td>
                                    <td>{{ grade.student.student_no }}</td>
                                    <td>{{ grade.student.name }}</td>
                                    <td>{{ grade.student.department ? grade.student.department.name : '-' }}</td>
                                    <td>{{ grade.subject.name }}</td>
                                    <template v-if="$route.params.id == 9">
                                        <td>
                                            <div class="d_flex_btwn">
                                                <div class="d_flex_start">
                                                    <input type="number" min="0" class="form_global width_60p" v-model="studentGrades[gradeIndex].attendance">
                                                    <span class="ml_15 white_space_nowrap fw_bold font_12p"> / {{ grade.subject_plan.attendance_mark }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d_flex_btwn">
                                                <div class="d_flex_start">
                                                    <input type="number" min="0" class="form_global width_60p" v-model="studentGrades[gradeIndex].attendance_rate">
                                                    <span class="ml_15 white_space_nowrap fw_bold font_12p"> %</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align_middle">
                                            <div class="form_checkbox">
                                                <input type="checkbox" :id="'pass_'+gradeIndex" :value="grade.id" :checked="grade.pass" @change="changePassStatus(grade.id)"> 
                                                <label :for="'pass_'+gradeIndex"></label>
                                            </div>
                                        </td>
                                    </template>
                                    <template v-else>
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
                                            <div class="d_flex_btwn">
                                                <div class="d_flex_start">
                                                    <input type="number" min="0" class="form_global width_60p" v-model="studentGrades[gradeIndex].attendance">
                                                    <span class="ml_15 white_space_nowrap fw_bold font_12p"> / {{ grade.subject_plan.attendance_mark }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d_flex_btwn">
                                                <div class="d_flex_start">
                                                    <input type="number" min="0" class="form_global width_60p" v-model="studentGrades[gradeIndex].attendance_rate">
                                                    <span class="ml_15 white_space_nowrap fw_bold font_12p"> %</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ studentGrades[gradeIndex].grade }}</td>
                                        <td>{{ studentGrades[gradeIndex].grades }}</td>
                                    </template>
                                </template>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td colspan="13">{{ trans('common.index.no_relevant_data') }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="d_flex_end" v-if="checkStudentPlanAvail(studentGrades)">
                        <button class="btn btn_md btn_success" @click.prevent="submitForm">{{ trans('admin.label.save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import validationErrors from "../../../../mixins/validationErrors";
import {
  explode,
} from 'korean-regexp';

export default {
    name:'student-grade-input',
    mixins: [validationErrors],
    
    data() {
        return {
            studentGrades:[],
            ko_filter: ['ㄱ','ㄴ','ㄷ','ㄹ','ㅁ','ㅂ','ㅅ','ㅇ','ㅈ','ㅊ','ㅋ','ㅌ','ㅍ','ㅎ']
        }
    },
    created() {
        this.getStudents()
    },
    methods:{
        checkStudentPlanAvail(studentGrades){
            let a = false
            studentGrades.forEach(studentGrade => {
                if(studentGrade.subject_plan) a = true
            })
            return a
        },
        semesterFullName(semester){
            if(semester){
                return semester.year + '-' + semester.season_name
            }
            return ''
        },
        getStudents(){
            axios.get(`/api/admin/subjects/${this.$route.params.id}/grade-input/${this.$route.params.semester_id}`)
                .then((response) => {
                    let responseData = response.data.data
                    this.ko_filter.forEach((text)=>{
                        responseData.forEach(grade => {
                            let searchText = (grade.student.name).toLowerCase()
                            let koText = explode(searchText)
                            if (koText.indexOf(text) == 0) {
                                this.studentGrades.push(grade)
                            }
                        })
                    })
                })
        },
        submitForm(){
            this.loading = true;
            this.errors = null;

            let formData = {};
            formData.studentGrades = this.studentGrades

            axios.post('/api/admin/grades', formData)
                .then((response) => {
                    this.$swal.fire(
                        this.trans('common.message.updated'),
                        this.trans('common.message.update_message'),
                        'success'
                    )
                    this.getStudents()
                })
                .catch((err) => this.errors = err.response.data.errors)
                .finally(() => this.loading = false);
        },
        calculateGrades(){
            this.loading = true;
            this.errors = null;

            let formData = {};
            formData.studentGrades = this.studentGrades

            axios.post('/api/admin/calculate-attendance', formData)
                .then((response) => {
                    this.studentGrades = response.data
                    this.$swal.fire(
                        this.trans('common.message.updated'),
                        this.trans('common.message.update_message'),
                        'success'
                    )

                })
                .catch((err) => this.errors = err.response.data.errors)
                .finally(() => this.loading = false);
        },
        changePassStatus(gradeId){
            let formData = {
                'grade_id' : gradeId, 
            };

            axios.post('/api/admin/change-pass-status', formData)
                .then(() => {
                    this.$swal({
                        toast: true,
                        position: 'top-right',
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true,
                        title: this.trans('common.message.update_message'),
                        icon: 'success',
                    });

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
    .align_middle{
        text-align: center !important;
    }
    .form_checkbox label{
        padding-left: 0px !important;
    }
</style>
