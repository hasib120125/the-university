<template>
    <div>
        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ trans('professor.form.profile.profile') }}</div>
                    </div>
                    <div class="card-body" v-if="user">
                        <table class="table table_bordered table_fixed">
                            <tbody>
                                <tr>
                                    <th>{{ trans('common.index.name') }}</th>
                                    <td><span>{{ user.name }}</span></td>
                                    <td rowspan="3">
                                        <div class="text-center">
                                            <img class="img_circle_with_100px" v-if="user && user.photo" :src="user.photo" alt="">
                                            <img class="img_circle_with_100px" v-else src="/images/profile_avatar.jpg" alt="">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ trans('professor.form.profile.name_chines') }}</th>
                                    <td> <span>{{ user.name_chinese }}</span></td>
                                </tr>
                                <tr>
                                    <th>{{ trans('professor.form.profile.name_hungul') }}</th>
                                    <td> <span>{{ user.name_hangul }}</span></td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table_bordered table_fixed">
                            <tbody>
                            <tr>
                                <th>{{ trans('professor.form.profile.id_no') }}</th>
                                <td><span>{{ user.professor_no }}</span></td>
                                <th>{{ trans('professor.form.profile.email') }}</th>
                                <td><span>{{ user.email }}</span></td>
                            </tr>
                                <tr>
                                    <th>{{ trans('professor.form.profile.cell_phone') }}</th>
                                    <td><span>{{ user.mobile }}</span></td>
                                    <th>{{ trans('professor.form.profile.address') }}</th>
                                    <td><span>{{ user.address }}</span></td>
                                </tr>
                                <tr>
                                    <th>{{ trans('professor.form.profile.dob') }}</th>
                                    <td><span>{{ user.dob }}</span></td>
                                    <th>{{ trans('professor.form.profile.department') }}</th>
                                    <td><span>{{ user.department ? user.department.name : '' }}</span></td>
                                </tr>

                            </tbody>
                        </table>
                        <div class="d_flex_end">
                            <router-link :to="{ name: 'profile_edit' }" class="btn btn_info"><i class="bx bx-edit-alt"> {{ trans('professor.label.edit') }}</i></router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title width_full">
                            <div class="d_flex_btwn">
                                <div>{{ trans('professor.form.profile.employee_history') }}</div>
                                <button @click.prevent="openCareerModal" class="btn btn_info">{{ trans('professor.form.profile.add_new_career') }}</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table_bordered table_center table_fixed">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('professor.form.profile.position') }}</th>
                                <th>{{ trans('professor.form.profile.employer') }}</th>
                                <th>{{ trans('professor.form.profile.department') }}</th>
                                <th>{{ trans('professor.form.profile.period') }}</th>
                                <th>{{ trans('professor.label.action') }}</th>
                            </tr>
                            </thead>
                            <tbody v-if="careers">
                                <tr v-for="(career, i) in careers" :key="'career_'+i">
                                    <td>{{ i+1 }}</td>
                                    <td>{{ career.position }}</td>
                                    <td>{{ career.employer }}</td>
                                    <td>{{ career.department }}</td>
                                    <td>{{ career.period }}</td>
                                    <td>
                                        <button class="btn btn_blue" @click.prevent="editCareer(career)"><i class="bx bx-edit-alt"></i></button>
                                        <button class="btn btn_danger" @click.prevent="deleteItem(career, 'career')"><i class='bx bxs-trash'></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title width_full">
                            <div class="d_flex_btwn">
                                <div>{{ trans('professor.form.profile.academic_history') }}</div>
                                <button @click.prevent="openEducationModal" class="btn btn_info">{{ trans('professor.form.profile.add_new_education') }}</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" v-if="educations">
                        <table class="table table_bordered table_center table_fixed">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('professor.form.profile.school') }}</th>
                                <th>{{ trans('professor.form.profile.scholarship_start') }}</th>
                                <th>{{ trans('professor.form.profile.scholarship_finish') }}</th>
                                <th>{{ trans('professor.form.profile.degree') }}</th>
                                <th>{{ trans('professor.label.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(education, i) in educations" :key="'career_'+i">
                                    <td>{{ i+1 }}</td>
                                    <td>{{ education.school }}</td>
                                    <td>{{ education.scholarship_s }}</td>
                                    <td>{{ education.scholarship_f }}</td>
                                    <td>{{ education.degree }}</td>
                                    <td>
                                        <button class="btn btn_blue" @click.prevent="editEducation(education)"><i class="bx bx-edit-alt"></i></button>
                                        <button class="btn btn_danger" @click.prevent="deleteItem(education, 'education')"><i class='bx bxs-trash'></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <!--Career Modal-->
        <div class="modal" data-modal="modal" :class="{open_modal:careerModelOpen}">
            <div class="modal_overlay" data-modal-close="modal"></div>
            <div class="modal_inner">
                <div class="modal_wrapper modal_1080p">
                    <div class="modal_header">
                        <span data-modal-close="modal" class="close_icon close_icon_sm" @click.prevent="closeModal">×</span>
                        <h2 v-if="careerModelStatus === 'add'">{{ trans('professor.form.profile.add_new_career') }}</h2>
                        <h2 v-else>{{ trans('professor.form.profile.edit_career') }}</h2>
                    </div>
                    <div class="modal_content">
                        <div class="row">
                            <div class="col_6">
                                <div class="form-group ">
                                    <label>{{ trans('professor.form.profile.position_and_occupation') }}</label>
                                    <input type="text" class="form_global"   v-model="careerForm.position">
                                    <v-errors :errors="errorFor('position')"></v-errors>
                                </div>
                            </div>
                            <div class="col_6">
                                <div class="form-group ">
                                    <label>{{ trans('professor.form.profile.employer') }}</label>
                                    <input type="text" class="form_global"   v-model="careerForm.employer">
                                    <v-errors :errors="errorFor('employer')"></v-errors>
                                </div>
                            </div>
                            <div class="col_6">
                                <div class="form-group ">
                                    <label>{{ trans('professor.form.profile.department') }}</label>
                                    <input type="text" class="form_global"   v-model="careerForm.department">
                                    <v-errors :errors="errorFor('department')"></v-errors>
                                </div>
                            </div>
                            <div class="col_6">
                                <div class="form-group ">
                                    <label>{{ trans('professor.form.profile.period_of_employment') }}</label>
                                    <input type="text" class="form_global"   v-model="careerForm.period">
                                    <v-errors :errors="errorFor('period')"></v-errors>
                                </div>
                            </div>
                        </div>
                        <div class="d_flex_end">
                            <button class="btn btn_secondary mr_5" @click.prevent="closeModal">{{ trans('professor.label.cancel') }}</button>
                            <button class="btn btn_md btn_success" @click.prevent="submitCareerForm">{{ trans('professor.label.save') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Educations Modal-->
        <div class="modal" data-modal="modal" :class="{open_modal:educationModelOpen}">
            <div class="modal_overlay" data-modal-close="modal"></div>
            <div class="modal_inner">
                <div class="modal_wrapper modal_1080p">
                    <div class="modal_header">
                        <span data-modal-close="modal" class="close_icon close_icon_sm" @click.prevent="closeModal">×</span>
                        <h2 v-if="educationModelStatus === 'add'">{{ trans('professor.form.profile.add_new_education') }}</h2>
                        <h2 v-else>{{ trans('professor.form.profile.edit_education') }}</h2>
                    </div>
                    <div class="modal_content">
                        <div class="row">
                            <div class="col_6">
                                <div class="form-group ">
                                    <label>{{ trans('professor.form.profile.school_name') }}</label>
                                    <input type="text" class="form_global"   v-model="educationForm.school">
                                    <v-errors :errors="errorFor('school')"></v-errors>
                                </div>
                            </div>
                            <div class="col_6">
                                <div class="form-group ">
                                    <label>{{ trans('professor.form.profile.scholarship_start') }}</label>
                                    <datepicker :typeable="true"  input-class="form_global form_date_picker" :value="educationForm.scholarship_s" @input="educationForm.scholarship_s = dateFormat($event, 'YYYY-MM-DD') "></datepicker>
                                    <v-errors :errors="errorFor('scholarship_s')"></v-errors>
                                </div>
                            </div>
                            <div class="col_6">
                                <div class="form-group ">
                                    <label>{{ trans('professor.form.profile.scholarship_finish') }}</label>
                                    <datepicker :typeable="true"  input-class="form_global form_date_picker" :value="educationForm.scholarship_f" @input="educationForm.scholarship_f = dateFormat($event, 'YYYY-MM-DD') "></datepicker>
                                    <v-errors :errors="errorFor('scholarship_f')"></v-errors>
                                </div>
                            </div>
                            <div class="col_6">
                                <div class="form-group ">
                                    <label>{{ trans('professor.form.profile.degree') }}</label>
                                    <input type="text" class="form_global"   v-model="educationForm.degree">
                                    <v-errors :errors="errorFor('degree')"></v-errors>
                                </div>
                            </div>
                        </div>
                        <div class="d_flex_end">
                            <button class="btn btn_secondary mr_5" @click.prevent="closeModal">{{ trans('professor.label.cancel') }}</button>
                            <button class="btn btn_md btn_success" @click.prevent="submitEducationForm">{{ trans('professor.label.save') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Datepicker from 'vuejs-datepicker';
import validationErrors from "../../mixins/validationErrors";
export default {
    mixins: [validationErrors],
    components: {Datepicker},
    data() {
        return {
            careerModelStatus: null,
            careerModelOpen: false,
            careerForm:{
                position:null,
                employer:null,
                department:null,
                period:null,
            },
            careers:[],
            user:null,
            educationModelStatus: null,
            educationModelOpen: false,
            educationForm:{
                school:null,
                scholarship_s:null,
                scholarship_f:null,
                degree:null,
            },
            educations:[],
        }
    },
    created() {
        axios.get('/api/professor/profile').then((response) => {  this.user = response.data.data })
        this.getProfessorCareer();
        this.getProfessorEducation();
    },
    methods: {
        dateFormat(e, format){
            if(e){
                return this.moment(e).format(format)
            }
            return null
        },
        submitCareerForm(){
            this.errors = null;
            axios.post('/api/professor/profile/career/save', this.careerForm)
                .then((response) => {
                    this.careerModelOpen = false;
                    this.getProfessorCareer();
                })
                .catch((err) => this.errors = err.response.data.errors)
                .finally(() => this.loading = false);
        },
        editCareer(data){
            this.careerForm = data;
            this.careerModelOpen = true;
        },
        openCareerModal(){
            this.careerModelStatus = 'add';
            this.careerModelOpen = true;
        },
        closeModal(){
            this.careerModelOpen = false;
            this.educationModelOpen = false;
        },
        getProfessorCareer(){
            axios.get('/api/professor/profile/careers').then((response) => { this.careers = response.data.data })
        },
        getProfessorEducation(){
            axios.get('/api/professor/profile/educations').then((response) => { this.educations = response.data.data; })
        },
        submitEducationForm(){
            this.errors = null;
            axios.post('/api/professor/profile/education/save', this.educationForm)
                .then((response) => {
                    this.educationModelOpen = false;
                    this.getProfessorEducation();
                })
                .catch((err) => this.errors = err.response.data.errors)
                .finally(() => this.loading = false);
        },
        editEducation(data){
            this.educationForm = data;
            this.educationModelOpen = true;
        },
        openEducationModal(){
            this.educationModelStatus = 'add';
            this.educationModelOpen = true;
        },
        deleteItem(item, type) {
            this.$swal({
                title: this.trans('professor.label.delete_confirmation'),
                text: this.trans('professor.label.warning'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: this.trans('professor.label.yes_delete'),
                cancelButtonText: this.trans('professor.label.no_cancel'),
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    if(type === 'career'){
                        axios.delete('/api/professor/profile/career/delete/'+item.id).then((response) => {
                                this.getProfessorCareer();
                                this.$swal.fire(
                                    'Deleted!',
                                    item.name+' has been deleted.',
                                    'success'
                                )
                            })
                    }else if(type === 'education'){
                        axios.delete('/api/professor/profile/education/delete/'+item.id).then((response) => {
                                this.getProfessorEducation();
                                this.$swal.fire(
                                    'Deleted!',
                                    item.name+' has been deleted.',
                                    'success'
                                )
                            })
                    }
                }
            });
        }
    }
}
</script>
<style scoped>
.img_circle_with_100px {
    width: 100px;
    height: 100px;
    border-radius: 5px;
}
</style>

