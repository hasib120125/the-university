<template>
    <div id="page_content">
        <div class="pt_20 pb_20">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h4>{{ trans('front.student_registration.personal_info') }}</h4>
                    </div>
                    <div class="col-md-4">
                        <div class="form_row">
                            <label for="name_hangul">{{ trans('student.form.profile.name_hungul') }}</label>
                            <input id="name_hangul" type="text" class="form_global" v-model="form.name_hangul">
                            <v-errors :errors="errorFor('name_hangul')"></v-errors>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_row">
                            <label for="name_chinese">{{ trans('student.form.profile.name_chines') }}</label>
                            <input id="name_chinese" type="text" class="form_global" v-model="form.name_chinese">
                            <v-errors :errors="errorFor('name_chinese')"></v-errors>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_row">
                            <label for="name_english">{{ trans('student.form.profile.name_english') }}</label>
                            <input id="name_english" type="text" class="form_global" v-model="form.name_english">
                            <v-errors :errors="errorFor('name_english')"></v-errors>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_row">
                            <label for="citizenship_no">{{ trans('student.form.profile.citizenship_no') }}</label>
                            <input id="citizenship_no" type="text" class="form_global" v-model="form.citizenship_no">
                            <v-errors :errors="errorFor('citizenship_no')"></v-errors>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_row">
                            <label for="age">{{ trans('front.student_registration.age') }}</label>
                            <input id="age" type="number" class="form_global" v-model="form.age">
                            <v-errors :errors="errorFor('age')"></v-errors>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_row">
                            <label for="gender">{{ trans('front.student_registration.gender') }}</label>
                            <div class="form_radio">
                                <input type="radio" v-model="form.gender" value="male" id="male"> <label for="male">{{ trans('front.student_registration.male') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" v-model="form.gender" value="female" id="female"> <label for="female">{{ trans('front.student_registration.female') }}</label>
                            </div>
                            <v-errors :errors="errorFor('gender')"></v-errors>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_row">
                            <label for="mobile">{{ trans('front.student_registration.cellphone') }}</label>
                            <input id="mobile" type="text" class="form_global" v-model="form.mobile">
                            <v-errors :errors="errorFor('mobile')"></v-errors>
                        </div>
                    </div>
                    <!-- <div class="col-md-4">
                        <div class="form_row">
                            <label for="phone">{{ trans('student.form.profile.phone') }}</label>
                            <input id="phone" type="text" class="form_global" v-model="form.phone">
                            <v-errors :errors="errorFor('phone')"></v-errors>
                        </div>
                    </div> -->
                    <div class="col-md-4">
                        <div class="form_row">
                            <label for="email">{{ trans('student.form.profile.email') }}</label>
                            <input id="email" type="text" class="form_global" v-model="form.email">
                            <v-errors :errors="errorFor('email')"></v-errors>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_row">
                            <label for="dob">{{ trans('student.form.profile.dob') }}</label>
                            <datepicker :typeable="true"  id="dob" input-class="form_global form_date_picker" :value="form.dob" @input="form.dob = dateFormat($event, 'YYYY-MM-DD') "></datepicker>
                            <v-errors :errors="errorFor('dob')"></v-errors>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_row">
                            <label for="address">{{ trans('student.form.profile.address') }}</label>
                            <input type="text" id="address" class="form_global" v-model="form.address">
                            <v-errors :errors="errorFor('address')"></v-errors>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_row">
                            <label for="photo">{{ trans('student.form.profile.photo') }}</label>
                            <div class="file_input">
                                <input id="photo" type="file" class="form_global" @change="attachmentUpload($event, 'photo')" accept="image/*">
                            </div>
                            <v-errors :errors="errorFor('photo')"></v-errors>
                        </div>
                    </div>
                    <div class="col-md-12 mt_20">
                        <h4>{{ trans('front.student_registration.ac_bc_workplace') }}</h4>
                    </div>
                    <div class="col-md-3">
                        <div class="form_row">
                            <label for="last_education_start">{{ trans('student.form.profile.last_education_start') }}</label>
                            <datepicker :typeable="true"  id="last_education_start" input-class="form_global form_date_picker" :value="form.last_education_start" @input="form.last_education_start = dateFormat($event, 'YYYY-MM-DD') "></datepicker>
                            <v-errors :errors="errorFor('last_education_start')"></v-errors>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form_row">
                            <label for="last_education_end">{{ trans('student.form.profile.last_education_end') }}</label>
                            <datepicker :typeable="true"  id="last_education_end" input-class="form_global form_date_picker" :value="form.last_education_end" @input="form.last_education_end = dateFormat($event, 'YYYY-MM-DD') "></datepicker>
                            <v-errors :errors="errorFor('last_education_end')"></v-errors>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form_row">
                            <label for="last_school_name">{{ trans('student.form.profile.last_school_name') }}</label>
                            <input id="last_school_name" class="form_global" v-model="form.last_school_name">
                            <v-errors :errors="errorFor('last_school_name')"></v-errors>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form_row">
                            <label for="last_education_department">{{ trans('student.form.profile.last_education_department') }}</label>
                            <input id="last_education_department" class="form_global" v-model="form.last_education_department">
                            <v-errors :errors="errorFor('last_education_department')"></v-errors>
                        </div>
                    </div>
                    <!-- <div class="col-md-3">
                        <div class="form_row">
                            <label for="last_education_special">{{ trans('student.form.profile.last_education_special') }}</label>
                            <input id="last_education_special" class="form_global" v-model="form.last_education_special">
                            <v-errors :errors="errorFor('last_education_special')"></v-errors>
                        </div>
                    </div> -->
                    <div class="col-md-3">
                        <div class="form_row">
                            <label for="job_company">{{ trans('student.form.profile.job_company') }}</label>
                            <input id="job_company" class="form_global" v-model="form.job_company">
                            <v-errors :errors="errorFor('job_company')"></v-errors>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form_row">
                            <label for="job_position">{{ trans('student.form.profile.job_position') }}</label>
                            <input id="job_position" class="form_global" v-model="form.job_position">
                            <v-errors :errors="errorFor('job_position')"></v-errors>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form_row">
                            <label for="job_address">{{ trans('student.form.profile.job_address') }}</label>
                            <input id="job_address" class="form_global" v-model="form.job_address">
                            <v-errors :errors="errorFor('job_address')"></v-errors>
                        </div>
                    </div>

                    <div class="col-md-12 mt_20">
                        <h4>{{ trans('front.student_registration.support') }}</h4>
                    </div>
                    <div class="col-md-6">
                        <div class="form_row">
                            <label for="admit_status">{{ trans('front.student_registration.admission_type') }}</label>
                            <div class="form_radio">
                                <input type="radio" v-model="form.admit_status" value="1" id="admit_status_1"> <label for="admit_status_1">{{ trans('student.form.profile.transfer') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" v-model="form.admit_status" value="0" id="admit_status_0"> <label for="admit_status_0">{{ trans('student.form.profile.regular_admission') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" v-model="form.admit_status" value="2" id="admit_status_2"> <label for="admit_status_2">{{ trans('student.form.profile.pastor_course') }}</label>
                            </div>
                            <v-errors :errors="errorFor('admit_status')"></v-errors>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form_row">
                            <label for="job_address">{{ trans('student.form.profile.department') }}</label>
                            <select class="form_global" id="department" v-model="form.department_id">
                                <option value="">{{ trans('front.student_registration.select_department') }}</option>
                                <option v-for="(department, i) in departments" :key="'department_'+i" :value="department.id">
                                    {{ department.name }}</option>
                            </select>
                            <v-errors :errors="errorFor('department_id')"></v-errors>
                        </div>
                    </div>

                    <div class="col-md-12 mt_20">
                        <h4>{{ trans('front.student_registration.life_of_faith') }}</h4>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>{{ trans('front.student_registration.church_name') }}</th>
                                    <th>{{ trans('front.student_registration.church_location') }}</th>
                                    <th>{{ trans('front.student_registration.office') }}</th>
                                    <th>{{ trans('front.student_registration.denomination') }}</th>
                                    <th>{{ trans('front.student_registration.year_of_faith') }}</th>
                                    <th width="5%"></th>
                                </tr>
                                <tr v-for="(faith, index) in faiths" :key="index">
                                    <td>
                                        <input class="form_global" v-model="faiths[index].name">
                                        <v-errors :errors="errorFor('faiths.'+ index + '.name')"></v-errors>
                                    </td>
                                    <td>
                                        <input class="form_global" v-model="faiths[index].location">
                                        <v-errors :errors="errorFor('faiths.'+ index + '.location')"></v-errors>
                                    </td>
                                    <td>
                                        <select class="form_global" v-model="faiths[index].office">
                                            <option value="">{{ trans('front.student_registration.choose') }}</option>
                                            <option value="간사">{{ trans('front.student_registration.steward') }}</option>
                                            <option value="권사">{{ trans('front.student_registration.kwonsa') }}</option>
                                            <option value="목사">{{ trans('front.student_registration.pastor') }}</option>
                                            <option value="사모">{{ trans('front.student_registration.mother_in_law') }}</option>
                                            <option value="사부">{{ trans('front.student_registration.master') }}</option>
                                            <option value="선교사">{{ trans('front.student_registration.missionary') }}</option>
                                            <option value="안수집사">{{ trans('front.student_registration.ordained_deacon') }}</option>
                                            <option value="집사">{{ trans('front.student_registration.butler') }}</option>
                                            <option value="장로">{{ trans('front.student_registration.elder') }}</option>
                                            <option value="전도사">{{ trans('front.student_registration.missionary') }}</option>
                                            <option value="평신도">{{ trans('front.student_registration.layman') }}</option>
                                            <option value="기타">{{ trans('front.student_registration.etc') }}</option>
                                        </select>
                                        <v-errors :errors="errorFor('faiths.'+ index + '.office')"></v-errors>
                                    </td>
                                    <td>
                                        <select class="form_global" v-model="faiths[index].denomination">
                                            <option value="">{{ trans('front.student_registration.choose') }}</option>
                                            <option value="감리교">{{ trans('front.student_registration.methodism') }}</option>
                                            <option value="성결교">{{ trans('front.student_registration.holiness_church') }}</option>
                                            <option value="순복음">{{ trans('front.student_registration.full_gospel') }}</option>
                                            <option value="장로교">{{ trans('front.student_registration.presbyterian') }}</option>
                                            <option value="침례교">{{ trans('front.student_registration.baptist') }}</option>
                                            <option value="초교파">{{ trans('front.student_registration.interdenominational') }}</option>
                                            <option value="기타">{{ trans('front.student_registration.etc') }}</option>
                                        </select>
                                        <v-errors :errors="errorFor('faiths.'+ index + '.denomination')"></v-errors>
                                    </td>
                                    <td>
                                        <input class="form_global" v-model="faiths[index].year_of_faith">
                                        <v-errors :errors="errorFor('faiths.'+ index + '.year_of_faith')"></v-errors>
                                    </td>
                                    <td>
                                        <span @click="addFaith" v-if=" index+1 === faiths.length "><i class="lni lni-plus"></i></span>
                                        <span v-if="index > 0" @click="removeFaith(index)" class="ml_5"><i class="lni lni-minus"></i></span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-12 mt_20">
                        <h4>{{ trans('front.student_registration.motivation_support') }}</h4>
                    </div>
                    <div class="col-md-6">
                        <div class="form_row">
                            <label for="job_address">{{ trans('student.form.profile.motive') }}</label>
                            <select class="form_global" id="motive" v-model="form.motive">
                                <option value="">{{ trans('student.form.profile.select_motive') }}</option>
                                <option value="ICS학우소개">{{ trans('student.form.profile.introduction_ofICSacademicians') }}</option>
                                <option value="교수진">{{ trans('student.form.profile.faculty') }}</option>
                                <option value="극동방송">{{ trans('student.form.profile.far_east_broadcasting') }}</option>
                                <option value="담임목사 추천">{{ trans('student.form.profile.senior_pastor_recommendation') }}</option>
                                <option value="인터넷 검색">{{ trans('student.form.profile.internet_search') }}</option>
                                <option value="지인추천">{{ trans('student.form.profile.recommendation_of_acquaintances') }}</option>
                                <option value="카이캄">{{ trans('student.form.profile.kaikan') }}</option>
                                <option value="홍보용 전단지">{{ trans('student.form.profile.promotional_flyer') }}</option>
                                <option value="기타">{{ trans('student.form.profile.etc') }}</option>
                            </select>
                            <v-errors :errors="errorFor('motive')"></v-errors>
                        </div>
                    </div>
                    <div class="col-md-12 mt_20">
                        <h4>{{ trans('front.student_registration.application_documents') }}</h4>
                    </div>
                    <div class="col-md-4">
                        <div class="form_row">
                            <label for="confention_faith_file">{{ trans('front.student_registration.confession_faith') }}</label>
                            <div class="file_input">
                                <input id="confention_faith_file" type="file" class="form_global" @change="attachmentUpload($event, 'confention_faith_file')" accept=".xlsx,.xls,.doc, .docx,.ppt, .pptx,.txt,.pdf">
                            </div>
                            <v-errors :errors="errorFor('confention_faith_file')"></v-errors>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_row">
                            <label for="study_plan">{{ trans('front.student_registration.study_plan') }}</label>
                            <div class="file_input">
                                <input id="study_plan" type="file" class="form_global" @change="attachmentUpload($event, 'study_plan')" accept=".xlsx,.xls,.doc, .docx,.ppt, .pptx,.txt,.pdf">
                            </div>
                            <v-errors :errors="errorFor('study_plan')"></v-errors>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form_row">
                            <label for="theological_dissertation_file">{{ trans('front.student_registration.theological_dissertation') }}</label>
                            <div class="file_input">
                                <input id="theological_dissertation_file" type="file" class="form_global" @change="attachmentUpload($event, 'theological_dissertation_file')" accept=".xlsx,.xls,.doc, .docx,.ppt, .pptx,.txt,.pdf">
                            </div>
                            <v-errors :errors="errorFor('theological_dissertation_file')"></v-errors>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button class="common_btn" @click="register">{{ trans('admin.label.save') }}</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>
<script>

import validationErrors from "../../mixins/validationErrors";
import Datepicker from 'vuejs-datepicker';

export default {
    name: 'studebt-registration',
    mixins: [validationErrors],
    components: {Datepicker},
    data(){
        return {
            form: {
                name_hangul: null,
                name_chinese: null,
                name_english: null,
                citizenship_no: null,
                gender: '',
                mobile: null,
                phone: null,
                email: null,
                photo: null,
                age: null,
                address: null,
                address: null,
                last_education_start: null,
                last_education_end: null,
                last_school_name: null,
                last_education_department: null,
                last_education_special: null,
                job_company: null,
                job_position: null,
                job_address: null,
                admit_status: null,
                department_id: '',
                motive: '',
                dob: null,
                password: '123456',
                confention_faith_file: null,
                study_plan: null,
                theological_dissertation_file: null,
            },
            faiths:[
                {
                    name: '',
                    location: '',
                    office: '',
                    denomination: '',
                    year_of_faith: '',
                }
            ],
            departments: [],
        }
    },
    watch:{
        $route(){
            thisloadData()
        }
    },
    created(){
        axios.get('/api/registrationOpen')
            .then((response)=>{
                // if(!response.data.open){
                //     this.$swal.fire(
                //         '등록 시간 만료',
                //         '등록 오픈을 기다려주세요',
                //         '오류'
                //     )
                //     this.$router.push({name: 'home'});
                // }
            })

        this.loadData()
    },
    methods:{
        dateFormat(e, format){
            if(e){
                return this.moment(e).format(format)
            }
            return null
        },
        loadData(){
            axios.get('/api/departments')
                .then((response) => {
                    this.departments = response.data.data
                })
        },
        addFaith() {
            this.faiths.push({
                name: '',
                location: '',
                office: '',
                denomination: '',
                year_of_faith: '',
            });
        },
        removeFaith(index) {
            this.faiths.splice(index, 1);
        },
        attachmentUpload(e, callFrom) {
            this.$set(this.form, callFrom, e.target.files[0])
        },
        register(){
            this.loading = true;
            this.errors = null;

            let formData = new FormData()

            Object.keys(this.form).forEach(key => {
                formData.append(key, this.form[key] ? this.form[key] : '');
            })

            formData.append('faiths', JSON.stringify(this.faiths))
            axios.post('/api/register', formData)
                .then((response) => {

                    this.$swal.fire(
                        '등록 성공',
                        '관리자 승인을 기다려주세요',
                        '성공'
                    )

                    this.$router.push({name: 'home'});
                })
                .catch((err) => {
                        if(err.response.status === 410){
                            this.$swal.fire(
                            '등록 시간 만료',
                            '등록 오픈을 기다려주세요',
                            '오류'
                        )
                        this.$router.push({name: 'home'});
                    }
                    this.errors = err.response.data.errors
                })
                .finally(() => this.loading = false);

        }
    }
}
</script>
