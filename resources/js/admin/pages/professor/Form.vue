<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ pageName }}</div>
                </div>
                <div :class="['card-body', {'loading_overlay': loading}]">
                    <div class="row">
                        <div class="col_4">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.professors.name_hangul') }}</label>
                                <input type="text" class="form_global" v-model="form.name_hangul">
                                <v-errors :errors="errorFor('name_hangul')"></v-errors>
                            </div>
                        </div>
                        <div class="col_4">
                            <div class="form-group">
                                <label>{{ trans('admin.form.professors.name_chinese') }}</label>
                                <input type="text" class="form_global" v-model="form.name_chinese">
                                <v-errors :errors="errorFor('name_chinese')"></v-errors>
                            </div>
                        </div>
                        <div class="col_4">
                            <div class="form-group">
                                <label>{{ trans('admin.form.professors.name_english') }}</label>
                                <input type="text" class="form_global" v-model="form.name_english">
                                <v-errors :errors="errorFor('name_english')"></v-errors>
                            </div>
                        </div>

                        <div class="col_4">
                            <div class="form-group">
                                <label>{{ trans('admin.form.professors.date_of_birth') }}</label>
                                <datepicker :typeable="true"  input-class="form_global form_date_picker" :value="form.dob" @input="form.dob = dateFormat($event, 'YYYY-MM-DD') "></datepicker>
                                <v-errors :errors="errorFor('dob')"></v-errors>
                            </div>
                        </div>

                        <div class="col_4">
                            <div class="form-group">
                                <label>{{ trans('admin.form.professors.photo') }} {{ form.temp_photo ? '('+ form.temp_photo + ')' : '' }}</label>
                                <div class="file_input">
                                    <span>Browse</span>
                                    <input type="file" class="form_global" @change="attachmentUpload($event, 'photo')" :placeholder="trans('admin.form.professors.photo')" accept="image/png, image/gif, image/jpeg">
                                </div>
                                 <v-errors :errors="errorFor('photo')"></v-errors>
                            </div>
                        </div>

                        <div class="col_4">
                            <div class="form-group">
                                <label>{{ trans('admin.form.professors.telephone') }}</label>
                                <input type="input" class="form_global" v-model="form.phone">
                                <v-errors :errors="errorFor('phone')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.professors.email') }}</label>
                                <input type="email" class="form_global" v-model="form.email">
                                <v-errors :errors="errorFor('email')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.professors.address') }}</label>
                                <input type="text" class="form_global" v-model="form.address">
                                <v-errors :errors="errorFor('address')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.professors.subject') }}</label>
                                <select class="form_global" v-model="form.custom_subject_id">
                                    <option value="">{{ trans('admin.form.professors.select_subject') }}</option>
                                    <option v-for="(customSubject, i) in customSubjects" :key="'professor_'+i" :value="customSubject.id">
                                        {{ customSubject.name }}</option>
                                </select>
                                <v-errors :errors="errorFor('custom_subject_id')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.professors.mobile') }}</label>
                                <input type="text" class="form_global" v-model="form.mobile">
                                <v-errors :errors="errorFor('mobile')"></v-errors>
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
                            <div class="form-group">
                                <label>{{ trans('admin.form.professors.details_image') }} {{ form.temp_details_image ? '('+ form.temp_details_image + ')' : '' }}</label>
                                <div class="file_input">
                                    <span>Browse</span>
                                    <input type="file" class="form_global" @change="attachmentUpload($event, 'details_image')" :placeholder="trans('admin.form.professors.details_image')" accept="image/png, image/gif, image/jpeg">
                                </div>
                                 <v-errors :errors="errorFor('details_image')"></v-errors>
                            </div>
                        </div>

                        <div class="col_12">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.professors.details') }}</label>
                                <froala-text-editor :model.sync="form.details"/>
                                <v-errors :errors="errorFor('details')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group mb_5 mt_15 "><label class="pb_0">{{ trans('common.index.status') }}</label> </div>
                            <div class="form_radio">
                                <input type="radio" id="status_1" name="radio" v-model="form.status" value="1">
                                <label for="status_1">{{ trans('common.index.active') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" id="status_0" name="radio" v-model="form.status" value="0">
                                <label for="status_0">{{ trans('common.index.in_active') }}</label>
                            </div>
                        </div>

                    </div>

                    <div class="d_flex_end">
                        <router-link class="btn btn_secondary mr_5" :to="{name: 'professors'}">{{ trans('admin.label.cancel') }}</router-link>
                        <button class="btn btn_md btn_success" @click.prevent="submitForm">{{ trans('admin.label.save') }}</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import validationErrors from "../../mixins/validationErrors";
import Datepicker from 'vuejs-datepicker';
import FroalaTextEditor from "./../../components/FroalaTextEditor.vue";

export default {
    name: 'professor-form',
    mixins: [validationErrors],
    components: {Datepicker, FroalaTextEditor},
    data(){
        return {
            form: {
                name_hangul: null,
                name_chinese: null,
                name_english: null,
                dob: null,
                photo: null,
                temp_photo: null,
                email: null,
                address: null,
                reg_no: null,
                grade: null,
                subject: '',
                mobile: null,
                phone: null,
                status: 1,
                password: '',
                details: '',
                temp_details_image: null,
            },
            pageName: this.trans('admin.form.professors.add_new_professor'),
            customSubjects: [],
        }
    },
    created() {
        axios.get('/api/admin/professors/customSubjects')
            .then((response) => {
                this.customSubjects = response.data.data;
            })

        if (this.$route.name === 'professors_edit') {
            this.loading = true;
            this.pageName = this.trans('admin.form.professors.edit_professor');
            axios.get('/api/admin/professors/'+ this.$route.params.id)
                .then((response) => {
                    this.form = response.data.data;
                    this.form.photo = '';
                    this.form.details_image = '';
                    this.form.department_id = response.data.data.department.id;
                    this.form.password = ''
                }).finally(() => this.loading = false);
        }
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

            if (this.$route.name === 'professors_edit') {
                formData.append('_method','PATCH')
                axios.post('/api/admin/professors/'+ this.$route.params.id, formData)
                    .then((response) => {
                        this.$router.push({name: 'professors'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            }else{
                axios.post('/api/admin/professors', formData)
                    .then((response) => {
                        this.$router.push({name: 'professors'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            }
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


