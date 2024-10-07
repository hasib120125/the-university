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
                        <select class="form_global mr_10" v-model="search.curriculum_id">
                            <option value="">--{{ trans('professor.form.grade_input.department') }}--</option>
                            <option v-for="(curriculum, i) in curriculums" :key="'curriculum_'+i" :value="curriculum.id">
                                    {{ curriculum.name }}</option>
                        </select>
                        <select class="form_global mr_10" v-model="search.grade">
                            <option value="">--{{ trans('professor.form.grade_input.grade') }}--</option>
                            <option value="1">{{ trans('common.index.grade1') }}</option>
                            <option value="2">{{ trans('common.index.grade2') }}</option>
                            <option value="2">{{ trans('common.index.year2') }}</option>
                            <option value="2">{{ trans('common.index.grade4') }}</option>
                        </select>
                        <select class="form_global mr_10" v-model="search.type">
                            <option value="1">{{ trans('professor.form.grade_input.name') }}</option>
                            <option value="2">{{ trans('common.index.id') }}</option>
                        </select>
                        <input type="text" class="form_global mr_10" v-model="search.q" >
                        <button class="btn btn_md btn_success" @click.prevent="getActiveStudent">{{ trans('professor.form.grade_input.search') }}</button>
                    </div>
                    <table class="table table_bordered table_fixed" :class="{'table_center': activeStudents.length > 0}">
                        <thead>
                            <tr>
                                <th width="60px">{{ trans('common.index.sl') }}</th>
                                <th>{{ trans('professor.form.grade_input.student_id') }}</th>
                                <th>{{ trans('professor.form.grade_input.name') }}</th>
                                <th>{{ trans('professor.form.grade_input.department') }}</th>
                                <th>{{ trans('professor.form.grade_input.middle') }}</th>
                                <th>{{ trans('professor.form.grade_input.end_of_term') }}</th>
                                <th>{{ trans('professor.form.grade_input.etc') }}</th>
                                <th>{{ trans('professor.form.grade_input.attendance') }}</th>
                                <th>{{ trans('professor.form.grade_input.attendance_rate') }}</th>
                                <th>{{ trans('professor.form.grade_input.grade') }}</th>
                                <th>{{ trans('professor.form.grade_input.grades') }}</th>
                            </tr>
                        </thead>
                        <tbody v-if="activeStudents.length > 0">
                            <tr v-for="(student, index) in activeStudents" :key="'grade_student'+index">
                                <td>{{ index+1 }}</td>
                                <td>{{ student.student_no }}</td>
                                <td>{{ student.name }}</td>
                                <td>{{ student.curriculum ? student.curriculum.name : '-' }}</td>
                                <td>
                                    <input type="number" min="0" class="form_global" v-model="activeStudents[index].gradeInput.middle">
                                    <v-errors :errors="errorFor(`activeStudents.${index}.gradeInput.middle`)"></v-errors>
                                </td>
                                <td>
                                    <input type="number" min="0" class="form_global" v-model="activeStudents[index].gradeInput.ending">
                                    <v-errors :errors="errorFor(`activeStudents.${index}.gradeInput.ending`)"></v-errors>
                                </td>
                                <td>
                                    <input type="number" min="0" class="form_global" v-model="activeStudents[index].gradeInput.etc">
                                    <v-errors :errors="errorFor(`activeStudents.${index}.gradeInput.etc`)"></v-errors>
                                </td>
                                <td>
                                    <input type="number" min="0" class="form_global" v-model="activeStudents[index].gradeInput.attendance">
                                    <v-errors :errors="errorFor(`activeStudents.${index}.gradeInput.attendance`)"></v-errors>
                                </td>
                                <td>
                                    <div class="d_flex_inline">
                                        <input type="number" min="0" class="form_global" v-model="activeStudents[index].gradeInput.attendance_rate">
                                        <span class="ml_5">%</span>
                                    </div>
                                    <v-errors :errors="errorFor('activeStudents[index].gradeInput.attendance_rate')"></v-errors>
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr>
                                <td colspan="11">{{ trans('common.index.no_students') }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="d_flex_end" v-if="activeStudents.length > 0">
                        <button class="btn btn_md btn_success" @click.prevent="submitForm">{{ trans('professor.label.save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import validationErrors from "../../../../mixins/validationErrors";

export default {
    name:'lecture-student-grade-list',
    mixins: [validationErrors],
    data() {
        return {
            activeStudents:[],
            search: {
                curriculum_id: '',
                grade: '',
                type: 1,//1 for name, 2 for id
                q: '',
            },
            curriculums: [],
            loading: false,
        }
    },
    created() {
        axios.get('/api/professor/curriculums')
            .then((response) => {
                this.curriculums = response.data.data;
            })

        this.getActiveStudent()
    },
    methods:{
        getActiveStudent(){
            axios.get(`/api/professor/lectures/${this.$route.params.id}/grades`,{
                    params: this.search
                })
                .then((response) => {
                    this.activeStudents = response.data.data
                })
        },
        submitForm(){
            this.loading = true;
            this.errors = null;

            let formData = {};
            formData.activeStudents = this.activeStudents

            axios.post('/api/professor/lectures/' + this.$route.params.id + '/grades', formData)
                .then((response) => {
                    this.$swal.fire(
                        this.trans('common.message.updated'),
                        this.trans('common.message.update_message'),
                        'success'
                    )
                })
                .catch((err) => this.errors = err.response.data.errors)
                .finally(() => this.loading = false);
        }
    },
}
</script>
