<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ pageName }}</div>
                </div>
                <div :class="['card-body', {'loading_overlay': loading}]">
                    <div class="row">
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.subject.name') }}</label>
                                <input type="text" class="form_global" :placeholder="trans('admin.form.subject.name')" v-model="form.name">
                                <v-errors :errors="errorFor('name')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.subject.code') }}</label>
                                <input type="text" class="form_global" :placeholder="trans('admin.form.subject.code')" v-model="form.code">
                                <v-errors :errors="errorFor('code')"></v-errors>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.subject.credit') }}</label>
                                <input type="text" class="form_global" :placeholder="trans('admin.form.subject.credit')" v-model="form.credit">
                                <v-errors :errors="errorFor('credit')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.subject.professor') }}</label>
                                <select class="form_global" id="professor" v-model="form.professor_id">
                                    <option value="">{{ trans('admin.form.subject.select_professor') }}</option>
                                    <option v-for="(professor, i) in professors" :key="'professor_'+i" :value="professor.id">
                                        {{ professor.name }}
                                    </option>
                                </select>
                                <v-errors :errors="errorFor('professor_id')"></v-errors>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col_6">
                            <div class="d_flex_inline">
                                <div class="form-group mb_5 mt_15 ml_0 mr_10"><label class="pb_0">{{ trans('common.index.status') }}</label> </div>
                                <div class="form_radio">
                                    <input type="radio" id="status_1" name="radio" v-model="form.status" value="1">
                                    <label for="status_1">{{ trans('common.index.active') }}</label>
                                </div>
                                <div class="form_radio">
                                    <input type="radio" id="status_0" name="radio" v-model="form.status" value="0">
                                    <label for="status_0">{{ trans('common.index.in_active') }}</label>
                                </div>
                                <v-errors :errors="errorFor('status')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.subject.max_student_capacity') }}</label>
                                <input type="text" class="form_global" :placeholder="trans('admin.form.subject.max_student')" v-model="form.max_student">
                                <v-errors :errors="errorFor('max_student')"></v-errors>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-for="(subjectDepartment, subjectDepartmentIndex) in subjectDepartments" :key="subjectDepartmentIndex">
                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.subject.department') }}</label>
                                <select class="form_global" v-model="subjectDepartments[subjectDepartmentIndex].id">
                                    <option value="">{{ trans('admin.form.subject.select_department') }}</option>
                                    <option v-for="(department, i) in departments" :key="'department_'+i" :value="department.id">
                                        {{ department.name }}
                                    </option>
                                </select>
                                <v-errors :errors="errorFor('departments.'+ subjectDepartmentIndex + '.id')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.subject.subject_type') }}</label>
                                <select class="form_global" id="type" v-model="subjectDepartments[subjectDepartmentIndex].subject_type">
                                    <option value="">{{ trans('admin.form.subject.select_subject_type') }}</option>
                                    <option value="공통">{{ trans('admin.form.subject.core_courses') }}</option>
                                    <option value="전공">{{ trans('admin.form.subject.required_courses') }}</option>
                                    <option value="선택">{{ trans('admin.form.subject.elective_courses') }}</option>
                                </select>
                                <v-errors :errors="errorFor('departments.'+ subjectDepartmentIndex + '.subject_type')"></v-errors>
                            </div>
                        </div>
                        <div class="col_12 width_full">
                            <span @click="addSubjectDepartment" v-if=" subjectDepartmentIndex + 1 === subjectDepartments.length "><i class="lni lni-plus"></i></span>
                            <span v-if="subjectDepartmentIndex > 0" @click="removeSubjectDepartment(subjectDepartmentIndex)" class="ml_5"><i class="lni lni-minus"></i></span>
                        </div>
                    </div>

                    <div class="d_flex_end">
                        <router-link class="btn btn_secondary mr_5" :to="{name: 'subjects'}">{{ trans('admin.label.cancel') }}</router-link>
                        <button class="btn btn_md btn_success" @click.prevent="submitForm">{{ trans('admin.label.save') }}</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import validationErrors from "../../mixins/validationErrors";
import _ from 'lodash'

export default {
    mixins: [validationErrors],
    components: {

    },
    data(){
        return {
            form: {
                name: null,
                code: null,
                credit: null,
                professor_id: '',
                departments: null,
                max_student: null,
                type: '',
                status: 1,
            },
            subjectDepartments : [{
                id: '',
                subject_type: ''
            }],
            pageName: this.trans('admin.form.subject.add_new_subject'),
            professors : [],
            departments : [],
        }
    },
    created() {
        axios.get('/api/admin/professors')
            .then((response) => {
                this.professors = response.data.data;
            })
        axios.get('/api/admin/departments')
            .then((response) => {
                this.departments = response.data.data;
            })

        if (this.$route.name === 'subject_edit') {
            this.loading = true;
            this.pageName = this.trans('admin.form.subject.edit_subject');
            axios.get('/api/admin/subjects/'+ this.$route.params.id)
                .then((response) => {
                    this.form = response.data.data;
                    this.subjectDepartments = this.form.departments
                    this.form.professor_id = this.form.professor ? this.form.professor.id : '';
                }).finally(() => this.loading = false);
        }
    },
    methods: {
        addSubjectDepartment() {
            this.subjectDepartments.push({
                id: '',
                subject_type: ''
            })
        },
        removeSubjectDepartment(index) {
            this.subjectDepartments.splice(index, 1);
        },
        submitForm(){
            this.loading = true;
            this.errors = null;
			this.form.departments = JSON.stringify(this.subjectDepartments)

            if (this.$route.name === 'subject_edit') {

                axios.patch('/api/admin/subjects/'+ this.$route.params.id, this.form)
                    .then((response) => {
                        this.$router.push({name: 'subjects'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            }else{

                axios.post('/api/admin/subjects', this.form)
                    .then((response) => {
                        this.$router.push({name: 'subjects'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            }
        }
    },
}
</script>

<style scoped lang="scss">

</style>
