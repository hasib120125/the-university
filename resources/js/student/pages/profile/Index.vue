<template>
    <div class="profile custom_p_40">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card_header">
                            <div class="card_title">{{ trans('student.form.profile.profile') }}</div>
                        </div>
                        <div
                         class="card_body" v-if="user">
                            <div class="table_responsive">
                                <table class="table table_bordered ">
                                    <colgroup>
                                        <col width="25%">
                                        <col width="25%">
                                        <col width="25%">
                                        <col width="25%">
                                    </colgroup>
                                    <tbody>
                                        <tr>
                                            <th>{{ trans('student.form.profile.name_english') }}</th>
                                            <td><span>{{ user.name_english }}</span></td>
                                            <td rowspan="3" colspan="2">
                                                <div class="text-center">
                                                    <img class="img_circle_with_100px" :src="user.photo" alt="">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>{{ trans('student.form.profile.name_chines') }}</th>
                                            <td> <span>{{ user.name_chinese }}</span></td>
                                        </tr>
                                        <tr>
                                            <th>{{ trans('student.form.profile.name_hungul') }}</th>
                                            <td> <span>{{ user.name_hangul }}</span></td>
                                        </tr>

                                        <tr>
                                            <th>{{ trans('student.form.profile.student_no') }}</th>
                                            <td><span>{{ user.student_no }}</span></td>
                                            <th>{{ trans('student.form.profile.department_major') }}</th>
                                            <td><span v-if="user.department">{{ user.department.name }}</span></td>
                                        </tr>
                                        <tr>
                                            <th>{{ trans('student.form.profile.email') }}</th>
                                            <td><span>{{ user.email }}</span></td>
                                            <th>{{ trans('student.form.profile.phone') }}</th>
                                            <td>
                                                <input v-if="edit" type="text" class="form_global" v-model="user.mobile">
                                                <span v-else>{{ user.mobile }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>{{ trans('student.form.profile.dob') }}</th>
                                            <td><span>{{ user.dob_formatted }}</span></td>
                                            <th>{{ trans('student.form.profile.grade') }}</th>
                                            <td><span>{{ user.grade }} {{ trans('student.form.profile.grade') }}</span></td>
                                        </tr>
                                        <tr>
                                            <th>{{ trans('student.form.profile.address') }}</th>
                                            <td>
                                                <input v-if="edit" type="text" class="form_global" v-model="user.address">
                                                <span v-else>{{ user.address }}</span>
                                            </td>
                                            <th>{{ trans('student.form.profile.citizenship_no') }}</th>
                                            <td><span>{{ user.citizenship_no }}</span></td>
                                        </tr>
                                        <tr>
                                            <th>{{ trans('student.form.profile.final_academic_background') }}</th>
                                            <td><span>{{ user.last_school_name }}</span></td>
                                            <th>{{ trans('student.form.profile.department') }}</th>
                                            <td><span>{{ user.last_education_department }}</span></td>
                                        </tr>
                                        <tr>
                                            <th>{{ trans('student.form.profile.motive') }}</th>
                                            <td><span>{{ user.motive }}</span></td>
                                            <th>{{ trans('student.form.profile.job_company') }}</th>
                                            <td><span>{{ user.job_company }}</span></td>
                                        </tr>
                                        <tr>
                                            <th>{{ trans('student.form.profile.job_position') }}</th>
                                            <td><span>{{ user.job_position }}</span></td>
                                            <th>{{ trans('student.form.profile.job_address') }}</th>
                                            <td><span>{{ user.job_address }}</span></td>
                                        </tr>

                                        <tr>
                                            <th>{{ trans('student.form.profile.state') }}</th>
                                            <td>
                                                <span>{{ user.status_text }}</span>
                                            </td>
                                            <th>{{ trans('student.form.profile.church_name') }}</th>
                                            <td>
                                                <span>{{ user.church_name }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>{{ trans('student.form.profile.admission_date') }}</th>
                                            <td><span>{{ user.admission_date }}</span></td>
                                            <th>{{ trans('student.form.profile.graduation_date') }}</th>
                                            <td><span>{{ user.graduation_date }}</span></td>
                                        </tr>
                                        <tr>
                                            <th>{{ trans('student.form.profile.password') }}</th>
                                            <td>
                                                <input v-if="edit" type="text" class="form_global" v-model="user.password">
                                                <span v-else></span>
                                            </td>
                                            <th>{{ trans('admin.form.student.bible_test') }}</th>
                                            <td>
                                                <template v-if="user.bible_exam == 1">
                                                    {{ trans('admin.form.student.pass') }} 
                                                    <span v-if="user.point_value">( {{ user.point_value }}{{ trans('admin.form.student.point') }} )</span>
                                                </template>
                                                <template v-if="user.bible_exam == 0">
                                                    {{ trans('admin.form.student.non_pass') }} 
                                                    <span v-if="user.point_value">( {{ user.point_value }}{{ trans('admin.form.student.point') }} )</span>
                                                </template>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="d_flex_end">
                                <button class="btn btn_blue" v-if="edit" @click="submitForm"><i class="fas fa-save mr_5"></i> {{ trans('student.label.save') }}</button>
                                <button class="btn btn_info" v-else @click="edit = true"><i class="fas fa-edit mr_5"></i>{{ trans('student.label.edit') }} </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'student-profile',
    data() {
        return {
            user:{
                student_no: '',
                name_hangul: null,
                name_chinese: null,
                name_english: null,
                photo: null,
                email: null,
                password: '',
                address: null,
                curriculum_id: '',
                grade: null,
                citizenship_no: null,
                dob: null,
                mobile: null,
                last_education_start: null,
                last_education_end: null,
                last_school_name: null,
                graduate_plan: null,
                last_education_department: null,
                last_education_special: null,
                motive: '',
                job_company: null,
                job_position: null,
                job_address: null,
                remark: null,
                degree_number: null,
                withdrawal_date: null,
                admission_date: null,
                graduation_date: null
            },
            edit: false,
        }
    },
    created() {
        this.loading = true
        this.getData()
        this.loading = false
    },
    methods: {
        getData(){
            axios.get('/api/student/profile').then((response) => {  
                this.user = response.data.data 
                this.user.password = null
            })
        },
        submitForm(){
            this.loading = true;
            this.errors = null;
            axios.post('/api/student/profile/update', this.user)
                .then((response) => {
                    this.edit = false
                    this.$swal.fire(
                        this.trans('common.message.updated'),
                        this.trans('common.message.profile_update_message'),
                        'success'
                    )
                    this.getData()
                })
                .catch((err) => {
                    this.errors = err.response.data.errors
                    this.loading = false
                })
                .finally(() => this.loading = false);
        }
    }
}
</script>
