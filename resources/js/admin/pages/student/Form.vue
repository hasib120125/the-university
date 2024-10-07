<template>
    <div class="row">
        <div :class="['col_12', {'loading_overlay': loading}]">
            <div class="card">
                <div class="card-header d_flex_btwn width_full">
                    <div class="card-title">{{ pageName }}</div>
                    <!-- <button class="btn btn_sm btn_secondary" v-if="form.active && form.active != '0' " @click="openModal">{{ trans('common.index.result') }}</button> -->
                </div>
                <div :class="['card-body']">
                    <div class="row">
                        <div class="col_4">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.student.name_hangul') }}</label>
                                <input type="text" class="form_global"  v-model="form.name_hangul">
                                <v-errors :errors="errorFor('name_hangul')"></v-errors>
                            </div>
                        </div>
                        <div class="col_4">
                            <div class="form-group">
                                <label>{{ trans('admin.form.student.name_chinese') }}</label>
                                <input type="text" class="form_global"  v-model="form.name_chinese">
                                <v-errors :errors="errorFor('name_chinese')"></v-errors>
                            </div>
                        </div>
                        <div class="col_4">
                            <div class="form-group">
                                <label>{{ trans('admin.form.student.name_english') }}</label>
                                <input type="text" class="form_global"  v-model="form.name_english">
                                <v-errors :errors="errorFor('name_english')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.department.department') }}</label>
                                <select class="form_global" id="department" v-model="form.department_id">
                                    <option value="">{{ trans('admin.form.subject.select_department') }}</option>
                                    <option v-for="(department, i) in departments" :key="'department_'+i" :value="department.id">
                                        {{ department.name }}</option>
                                </select>
                                <v-errors :errors="errorFor('department_id')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.semester.semester') }}</label>
                                <select class="form_global" id="department" v-model="form.semester_id">
                                    <option value="">{{ trans('admin.form.curriculum_fees.select_semester') }}</option>
                                    <option v-for="(semester, i) in semesters" :key="'department_'+i" :value="semester.id">
                                        {{ semester.year }} - {{ semester.season_name }}
                                    </option>
                                </select>
                                <v-errors :errors="errorFor('semester_id')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.student.citizenship_no') }}</label>
                                <input type="text" class="form_global"  v-model="form.citizenship_no">
                                <v-errors :errors="errorFor('citizenship_no')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6" v-if="form.student_no">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.student.student_no') }}</label>
                                <input type="text" class="form_global"  v-model="form.student_no">
                                <v-errors :errors="errorFor('student_no')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.student.date_of_birth') }}</label>
                                <datepicker :typeable="true"  input-class="form_global form_date_picker" :value="form.dob" @input="form.dob = dateFormat($event, 'YYYY-MM-DD') "></datepicker>
                                <v-errors :errors="errorFor('dob')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.student.email') }}</label>
                                <input type="email" class="form_global"  v-model="form.email">
                                <v-errors :errors="errorFor('email')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.student.password') }}</label>
                                <input type="password" class="form_global"  v-model="form.password">
                                <v-errors :errors="errorFor('password')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.student.graduate_plan') }}</label>
                                <input type="text" class="form_global"  v-model="form.graduate_plan">
                                <v-errors :errors="errorFor('graduate_plan')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.student.photo') }} {{ form.temp_photo ? '('+ form.temp_photo + ')' : '' }}</label>
                                <div class="file_input">
                                    <span>Browse</span>
                                    <input type="file" class="form_global" @change="attachmentUpload($event, 'photo')" accept="image/png, image/gif, image/jpeg"  :placeholder="trans('admin.form.student.photo')">
                                </div>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.student.address') }}</label>
                                <input type="text" class="form_global"  v-model="form.address">
                                <v-errors :errors="errorFor('address')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.student.mobile') }}</label>
                                <input type="text" class="form_global"  v-model="form.mobile">
                                <v-errors :errors="errorFor('mobile')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.student.last_education_start') }}</label>
                                <datepicker :typeable="true"  input-class="form_global form_date_picker" :value="form.last_education_start" @input="form.last_education_start = dateFormat($event, 'YYYY-MM-DD') "></datepicker>
                                <v-errors :errors="errorFor('last_education_start')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.student.last_education_end') }}</label>
                                <datepicker :typeable="true"  input-class="form_global form_date_picker" :value="form.last_education_end" @input="form.last_education_end = dateFormat($event, 'YYYY-MM-DD') "></datepicker>
                                <v-errors :errors="errorFor('last_education_end')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.student.last_school_name') }}</label>
                                <input type="text" class="form_global"  v-model="form.last_school_name">
                                <v-errors :errors="errorFor('last_school_name')"></v-errors>
                            </div>
                        </div>


                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.student.last_education_department') }}</label>
                                <input type="text" class="form_global"  v-model="form.last_education_department">
                                <v-errors :errors="errorFor('last_education_department')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.student.motive') }}</label>
                                <select class="form_global" id="motive" v-model="form.motive">
                                    <option value="">{{ trans('admin.form.student.select_motive') }}</option>
                                    <option value="ICS학우소개">Introduction of ICS Academicians</option>
                                    <option value="교수진">Faculty</option>
                                    <option value="극동방송">Far East Broadcasting</option>
                                    <option value="담임목사 추천">Senior Pastor Recommendation</option>
                                    <option value="인터넷 검색">Internet search</option>
                                    <option value="지인추천">Recommendation of acquaintances</option>
                                    <option value="카이캄">Kaikam</option>
                                    <option value="홍보용 전단지">Promotional flyer</option>
                                    <option value="기타">Etc</option>
                                </select>
                                <v-errors :errors="errorFor('motive')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.student.grade') }}</label>
                                <input type="text" class="form_global" v-model="form.grade">
                                <v-errors :errors="errorFor('grade')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.student.job_company') }}</label>
                                <input type="text" class="form_global"  v-model="form.job_company">
                                <v-errors :errors="errorFor('job_company')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.student.job_position') }}</label>
                                <input type="text" class="form_global"  v-model="form.job_position">
                                <v-errors :errors="errorFor('job_position')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.student.job_address') }}</label>
                                <input type="text" class="form_global"  v-model="form.job_address">
                                <v-errors :errors="errorFor('job_address')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.student.degree_number') }}</label>
                                <input type="text" class="form_global"  v-model="form.degree_number">
                                <v-errors :errors="errorFor('degree_number')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.student.withdrawal_date') }}</label>
                                <datepicker :typeable="true"  input-class="form_global form_date_picker" :value="form.withdrawal_date" @input="form.withdrawal_date = dateFormat($event, 'YYYY-MM-DD') "></datepicker>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.student.admission_date') }}</label>
                                <datepicker :typeable="true"  input-class="form_global form_date_picker" :value="form.admission_date" @input="form.admission_date = dateFormat($event, 'YYYY-MM-DD') "></datepicker>
                                <v-errors :errors="errorFor('admission_date')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.student.graduation_date') }}</label>
                                <datepicker :typeable="true"  input-class="form_global form_date_picker" :value="form.graduation_date" @input="form.graduation_date = dateFormat($event, 'YYYY-MM-DD') "></datepicker>
                                <v-errors :errors="errorFor('graduation_date')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.student.remarks') }}</label>
                                <textarea rows="4" cols="50" class="form_global" v-model="form.remark"></textarea>
                                <v-errors :errors="errorFor('remark')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.student.church_name') }}</label>
                                <input type="text" class="form_global" v-model="form.church_name">
                                <v-errors :errors="errorFor('church_name')"></v-errors>
                            </div>
                        </div>

                        <div class="col_12">
                            <div class="form-group mb_5">
                                <label class="pb_0">{{ trans('admin.form.student.state') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" id="Attending" v-model="form.status" value="1">
                                <label for="Attending">{{ trans('admin.form.student.attending') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" id="stop" v-model="form.status" value="2">
                                <label for="stop">{{ trans('admin.form.student.leave_of_absence') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" id="army" v-model="form.status" value="3">
                                <label for="army">{{ trans('admin.form.student.military_leave') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" id="finish" v-model="form.status" value="4">
                                <label for="finish">{{ trans('admin.form.student.completion') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" id="gradu" v-model="form.status" value="5">
                                <label for="gradu">{{ trans('admin.form.student.graduated') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" id="gradu_tobe" v-model="form.status" value="6">
                                <label for="gradu_tobe">{{ trans('admin.form.student.graduation_plan') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" id="overall" v-model="form.status" value="7">
                                <label for="overall">{{ trans('admin.form.student.weeding') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" id="dropout" v-model="form.status" value="8">
                                <label for="dropout">{{ trans('admin.form.student.drop_out') }}</label>
                            </div>
                            <v-errors :errors="errorFor('status')"></v-errors>
                        </div>
                        <div class="col_6 mt_5" v-if="['2','3'].includes(form.status)">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.student.leave_start') }}</label>
                                <datepicker :typeable="true"  input-class="form_global form_date_picker" :value="form.leave_start_date" @input="form.leave_start_date = dateFormat($event, 'YYYY-MM-DD') "></datepicker>
                            </div>
                            <v-errors :errors="errorFor('leave_start_date')"></v-errors>
                        </div>
                        <div class="col_6 mt_5" v-if="['2','3'].includes(form.status)">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.student.leave_end') }}</label>
                                <datepicker :typeable="true"  input-class="form_global form_date_picker" :value="form.leave_end_date" @input="form.leave_end_date = dateFormat($event, 'YYYY-MM-DD') "></datepicker>
                            </div>
                            <v-errors :errors="errorFor('leave_end_date')"></v-errors>
                        </div>
                        <br>
                        <div class="col_4">
                            <div class="form-group mb_5 mt_15">
                                <label class="pb_0">{{ trans('admin.form.student.bible_test') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" id="pass" v-model="form.bible_exam" value="1">
                                <label for="pass">{{ trans('admin.form.student.pass') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" id="Waiting" v-model="form.bible_exam" value="0">
                                <label for="Waiting" class="point_label">{{ trans('admin.form.student.non_pass') }}</label>
                                <input type="text" class="form_global" v-model="form.point_value"><span class="point_position">{{ trans('admin.form.student.point') }}</span>
                            </div>
                            <v-errors :errors="errorFor('bible_exam')"></v-errors>
                        </div>
                        <div class="col_4">
                            <div class="form-group mb_5 mt_15 "><label class="pb_0">{{ trans('admin.form.student.admission_type') }}</label> </div>
                            <div class="form_radio">
                                <input type="radio" id="bible_exam_off" v-model="form.admit_status" value="1">
                                <label for="bible_exam_off">{{ trans('admin.form.student.transfer') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" id="Regular" v-model="form.admit_status" value="0">
                                <label for="Regular">{{ trans('admin.form.student.regular_admission') }}</label>
                            </div>
                            <v-errors :errors="errorFor('admit_status')"></v-errors>
                        </div>
                        <div class="col_4">
                            <div class="form-group mb_5 mt_15 "><label class="pb_0">{{ trans('common.index.status') }}</label> </div>
                            <div class="form_radio">
                                <input type="radio" id="status_1" name="radio" v-model="form.active" value="1">
                                <label for="status_1">{{ trans('common.index.active') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" id="status_0" name="radio" v-model="form.active" value="0">
                                <label for="status_0">{{ trans('common.index.in_active') }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-header d_flex_btwn width_full mt_10">
                    <div class="card-title">{{ trans('common.index.attachments') }}</div>
                </div>
                <div :class="['card-body']">
                    <div class="row">
                        <div class="col_5">
                            <div class="form-group ">
                                <label>{{ trans('common.index.attachments') }}</label>
                                <div class="d_flex_inline">
                                    <vue-dropzone ref="fileDropzone" class="form_global mr_5" v-on:vdropzone-removed-file="cancelFile" v-on:vdropzone-success="uploadFileSuccess" id="dropzone" :options="dropzoneVideoOptions"></vue-dropzone>
                                </div>
                                <v-errors :errors="errorFor('file')"></v-errors>
                            </div>
                        </div>
                        <div class="col_7" v-if="attachments.length > 0">
                            <div class="table_responsive">
                                <table class="table table_bordered table_center table_fixed">
                                    <thead>
                                        <tr>
                                            <th width="90%">{{ trans('common.index.file') }}</th>
                                            <th>{{ trans('admin.label.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(attachment, index) in attachments" :key="'attachment' + index">
                                            <td>
                                                <a class="color_info" :href="attachment.attachment" target="_blank" :download="attachment.orginal_name"> <i class="fas fa-download"></i> {{ attachment.orginal_name }}</a>
                                            </td>
                                            <td>
                                                <button class="btn btn_sm btn_danger" title="this.trans('admin.label.delete')" @click="deleteItem(attachment)"><i class="far fa-trash-alt"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="d_flex_end">
                        <router-link class="btn btn_secondary mr_5" :to="{name: cancelRouteName}">{{ trans('admin.label.cancel') }}</router-link>
                        <button class="btn btn_md btn_success" @click.prevent="submitForm">{{ trans('admin.label.save') }}</button>
                    </div>

                </div>
            </div>
        </div>
        <ResultModal 
            v-if="showModal"
            :showModal="showModal"
            :studentId="studentId"
            @closeModal="closeModal"
        />
    </div>
</template>

<script>
import validationErrors from "../../mixins/validationErrors";
import Datepicker from 'vuejs-datepicker';
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

export default {
    name: 'student-form',
    mixins: [validationErrors],
    components: {
        Datepicker,
        vueDropzone: vue2Dropzone,
        ResultModal: () => import(/* webpackChunkName: "js/student/resultModal" */ './ResultModal.vue'),
    },
    data(){
        return {
            form: {
                student_no: null,
                name_hangul: null,
                name_chinese: null,
                name_english: null,
                photo: null,
                email: null,
                password: null,
                address: null,
                department_id: '',
                semester_id: '',
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
                status: null,
                degree_number: null,
                withdrawal_date: null,
                admission_date: null,
                graduation_date: null,
                grade: null,
                admit_status: null,
                bible_exam: null,
                point_value: '',
                active: 1,
                leave_start_date: null,
                leave_end_date: null,
                attachmentFiles: [],
                originaAttachments: [],
            },
            dropzoneVideoOptions: {
                url: '/api/admin/upload/temp',
                addRemoveLinks: true,
                maxFilesize: 5120,
                thumbnailHeight: 120,
                timeout: 9999990000,
                headers: {
                    "Authorization": `Bearer `+ JSON.parse(localStorage.getItem('user')).token,
                    "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                }
            },
            pageName: this.trans('admin.form.student.add_new_student'),
            departments: [],
            semesters: [],
            attachments: [],
            cancelRouteName: 'students',
            studentId: null,
            showModal: false,
        }
    },
    // beforeRouteEnter(to, from, next) {
    //     next(vm => {
    //         vm.cancelRouteName = from.name
    //     })
    // },
    created() {
        axios.get('/api/admin/departments')
            .then((response) => {
                this.departments = response.data.data;
            })
        axios.get('/api/admin/semesters')
            .then((response) => {
                this.semesters = response.data.data;
            })
        if (this.$route.name === 'students_edit') {
            this.loadCurrentStudentData()
            this.getAttachment()
        }
    },
    methods: {
        dateFormat(e, format){
            if(e){
                return this.moment(e).format(format)
            }
            return null
        },
        getAttachment(){
            axios.get(`/api/admin/student-attachment/${this.$route.params.id}`)
                .then((response) => {
                    this.attachments = response.data.data;
                })
        },
        loadCurrentStudentData(){
            this.loading = true;
            this.pageName = this.trans('admin.form.student.edit_student');
            axios.get('/api/admin/students/'+ this.$route.params.id)
                .then((response) => {
                    this.form = response.data.data;
                    this.form.photo = '';
                    this.form.password = '';
                    this.form.active = response.data.data.active+'';
                    this.form.bible_exam = response.data.data.bible_exam;
                    this.form.admit_status = response.data.data.admit_status;
                    this.form.status = response.data.data.status;
                    this.form.attachmentFiles = [];

                    this.studentId = this.$route.params.id
                }).finally(() => this.loading = false);
        },
        uploadFileSuccess(file, response) {
            this.form.originaAttachments.push(file.name);
            this.form.attachmentFiles.push(response);
        },
        cancelFile(file, error, xhr){
            let index = this.form.originaAttachments.findIndex(item => item === file.name);

            let deleteFile = this.form.attachmentFiles[index];

            if(this.$refs.fileDropzone.dropzone.disabled !== true){
                axios.post('/api/admin/delete/temp', {deleteFile}).then((response) => {
                    this.$swal.fire(
                        this.trans('common.message.deleted'),
                        this.trans('common.message.delete_message'),
                        'success'
                    )
                });

                this.form.originaAttachments.splice(index, 1);
                this.form.attachmentFiles.splice(index, 1);
            }
        },
        openModal(){
            this.showModal = true
        },
        closeModal(){
            this.showModal = false
        },
        submitForm(){
            this.loading = true;
            this.errors = null;

            if(!['2','3'].includes(this.form.status)){
                this.form.leave_start_date = null
                this.form.leave_end_date = null
            }

            let formData = new FormData()

            Object.keys(this.form).forEach(key => {
                formData.append(key, this.form[key] ? this.form[key] : '');
            })

            if (this.$route.name === 'students_edit') {
                formData.append('_method','PATCH')
                axios.post('/api/admin/students/'+ this.$route.params.id, formData)
                    .then((response) => {
                        if(this.cancelRouteName){
                            this.$router.push({name: this.cancelRouteName});
                        }else{
                            this.$router.push({name: 'students'});
                        }
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            }else{
                axios.post('/api/admin/students', formData)
                    .then((response) => {
                        this.$router.push({name: this.cancelRouteName});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            }
        },
        attachmentUpload(e, callFrom) {
            this.$set(this.form, callFrom, e.target.files[0])
        },
        deleteItem(item) {
            this.$swal({
                title: this.trans('admin.label.delete_confirmation'),
                text: this.trans('admin.label.warning'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: this.trans('admin.label.yes_delete'),
                cancelButtonText: this.trans('admin.label.no_cancel'),
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/api/admin/student-attachment/'+item.id).then(() => {
                        this.getAttachment()
                        this.$swal.fire(
                            this.trans('common.message.deleted'),
                            this.trans('common.message.delete_message'),
                            'success'
                        )
                    });
                }
            });
        }
    },
}
</script>

<style>
    .form_date_picker {
        background-color: white !important;
        cursor: pointer !important;
        opacity: 1 !important;
    }
    .vdp-datepicker__calendar .cell.selected {
        color: #fff;
    }
    .point_label::before{
        top: 10px !important;
    }
    .point_label::after{
        top: 10px !important;
    }
    .point_position{
        margin: 8px 0 0 8px;
    }
</style>


