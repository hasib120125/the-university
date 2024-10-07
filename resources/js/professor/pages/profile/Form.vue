<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ pageName }}</div>
                </div>
                <div  :class="['card-body', {'loading_overlay': loading}]">
                    <div class="row">
                        <div class="col_4">
                            <div class="form-group ">
                                <label>{{ trans('professor.form.profile.name_hungul') }}</label>
                                <input type="text" class="form_global" v-model="form.name_hangul">
                                <v-errors :errors="errorFor('name_hangul')"></v-errors>
                            </div>
                        </div>
                        <div class="col_4">
                            <div class="form-group">
                                <label>{{ trans('professor.form.profile.name_chines') }}</label>
                                <input type="text" class="form_global" v-model="form.name_chinese">
                                <v-errors :errors="errorFor('name_chinese')"></v-errors>
                            </div>
                        </div>
                        <div class="col_4">
                            <div class="form-group">
                                <label>{{ trans('professor.form.profile.name_english') }}</label>
                                <input type="text" class="form_global" v-model="form.name_english">
                                <v-errors :errors="errorFor('name_english')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('professor.form.profile.dob') }}</label>
                                <datepicker :typeable="true"  input-class="form_global form_date_picker" :value="form.dob" @input="form.dob = dateFormat($event, 'YYYY-MM-DD') "></datepicker>
                                <v-errors :errors="errorFor('dob')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('professor.form.profile.photo') }}</label>
                                <div class="file_input">
                                    <span>Browse</span>
                                    <input type="file" accept="image/png, image/gif, image/jpeg" @change="attachmentUpload($event, 'photo')" class="form_global" :placeholder="trans('professor.form.profile.photo')">
                                </div>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('professor.form.profile.email') }}</label>
                                <input type="email" class="form_global" v-model="form.email">
                                <v-errors :errors="errorFor('email')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('professor.form.profile.password') }}</label>
                                <input type="password" class="form_global" v-model="form.password">
                                <v-errors :errors="errorFor('password')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('professor.form.profile.address') }}</label>
                                <input type="text" class="form_global" v-model="form.address">
                                <v-errors :errors="errorFor('address')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('professor.form.profile.department') }}</label>
                                <select class="form_global" id="department" v-model="form.department_id">
                                    <option value="">{{ trans('professor.form.profile.select_department') }}</option>
                                    <option v-for="(department, i) in departments" :key="'professor_'+i" :value="department.id">
                                        {{ department.name }}</option>
                                </select>
                                <v-errors :errors="errorFor('department_id')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('professor.form.profile.phone') }}</label>
                                <input type="text" class="form_global" v-model="form.mobile">
                                <v-errors :errors="errorFor('mobile')"></v-errors>
                            </div>
                        </div>

                    </div>

                    <div class="d_flex_end">
                        <router-link class="btn btn_secondary mr_5" :to="{name: 'profile'}">{{ trans('professor.label.cancel') }}</router-link>
                        <button class="btn btn_md btn_success" @click.prevent="submitForm">{{ trans('professor.label.save') }}</button>
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
    mixins: [validationErrors],
    components: {Datepicker},
    data(){
        return {
            form: {
                name_hangul: null,
                name_chinese: null,
                name_english: null,
                dob: null,
                photo: null,
                email: null,
                password: null,
                address: null,
                department_id: '',
                mobile: null,
                status: null,
            },
            pageName: this.trans('professor.form.profile.edit_professor'),
            departments: [],
            loading: false,
        }
    },
    created() {
        axios.get('/api/professor/departments')
            .then((response) => {
                this.departments = response.data.data;
            })
            
            this.loading = true;
            axios.get('/api/professor/profile')
                .then((response) => {
                    this.form = response.data.data;
                    this.form.photo = '';
                    this.form.department_id = response.data.data.department.id;
                }).finally(()=> this.loading = false)
                
    },
    methods: {
        dateFormat(e, format){
            if(e){
                return this.moment(e).format(format)
            }
            return null
        },
        submitForm(){
            this.loading = true;
            this.errors = null;

            let formData = new FormData()

            Object.keys(this.form).forEach(key => {
                formData.append(key, this.form[key] ? this.form[key] : '');
            })
            formData.append('_method','PATCH')
            axios.post('/api/professor/profile/update', formData)
                .then((response) => {
                    this.$router.push({name: 'profile'});
                })
                .catch((err) => this.errors = err.response.data.errors)
                .finally(() => this.loading = false);
        },
        attachmentUpload(e, callFrom) {
            this.$set(this.form, callFrom, e.target.files[0])
        },
    },
}
</script>

<style>
.vdp-datepicker__calendar .cell.selected {
    color: #fff;
}
</style>


