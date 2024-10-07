<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ pageName }}</div>
                </div>
                <div :class="['card-body', {'loading_overlay': loading}]">
                    <div class="row">
                        <div class="col_12">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.assignment.title_of_assignment') }}</label>
                                <input type="text" class="form_global" v-model="form.assignment_title">
                                <v-errors :errors="errorFor('assignment_title')"></v-errors>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col_3">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.assignment.start_date') }}</label>
                                <datepicker :typeable="true"  input-class="form_global form_date_picker" :value="form.start_period" @input="form.start_period = dateFormat($event, 'YYYY-MM-DD') "></datepicker>
                                <v-errors :errors="errorFor('start_period')"></v-errors>
                            </div>
                        </div>
                        <div class="col_3">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.assignment.end_date') }}</label>
                                <datepicker :typeable="true"  input-class="form_global form_date_picker" :value="form.end_period" @input="form.end_period = dateFormat($event, 'YYYY-MM-DD') "></datepicker>
                                <v-errors :errors="errorFor('end_period')"></v-errors>
                            </div>
                        </div>
                        <div class="col_3">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.assignment.task_type') }}</label>
                                <select class="form_global" id="task_type" v-model="form.task_type">
                                    <option value="1">{{ trans('admin.form.assignment.general_tasks') }}</option>
                                    <option value="2">{{ trans('admin.form.assignment.assignment_type_test') }}</option>
                                    <option value="3">{{ trans('admin.form.assignment.etc') }}</option>
                                </select>
                                <v-errors :errors="errorFor('task_type')"></v-errors>
                            </div>
                        </div>
                        <div class="col_3">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.assignment.task_type') }} <span class="color_danger">{{ trans('admin.form.assignment.task_type_after') }}</span></label>
                                <select class="form_global" id="end_open" v-model="form.end_open">
                                    <option value="1">{{ trans('admin.form.assignment.submission_allowed') }}</option>
                                    <option value="2">{{ trans('admin.form.assignment.prohibited_to_submit') }}</option>
                                </select>
                                <v-errors :errors="errorFor('end_open')"></v-errors>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col_12">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.assignment.description') }}</label>
                                <froala-text-editor :model.sync="form.description" :deleteImages.sync="deleteImages"/>
                                <v-errors :errors="errorFor('description')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.assignment.attachment_1') }}</label>
                                <div class="file_input">
                                    <input type="file" id="file" ref="file" class="form_global" placeholder="Photo" @change="attachment1Upload($event)">
                                    <v-errors :errors="errorFor('attachment1')"></v-errors>
                                </div>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.assignment.attachment_2') }}</label>
                                <div class="file_input">
                                    <input type="file" class="form_global" placeholder="Photo" @change="attachment2Upload($event)">
                                    <v-errors :errors="errorFor('attachment1')"></v-errors>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d_flex_end">
                        <router-link class="btn btn_secondary mr_5" :to="{name: 'subject_assignments', params: {semester_id: $route.params.semester_id}}">{{ trans('admin.label.cancel') }}</router-link>
                        <button class="btn btn_md btn_success" @click.prevent="submitForm">{{ trans('admin.label.save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import validationErrors from "../../../../mixins/validationErrors";
import FroalaTextEditor from "./../../../../components/FroalaTextEditor";
import Datepicker from 'vuejs-datepicker';

export default {
    mixins: [validationErrors],
    components: {FroalaTextEditor, Datepicker},
    data(){
        return {
            deleteImages: [],
            form: {
                semester_id: this.$route.params.semester_id,
                assignment_title: null,
                description: '',
                start_period: '',
                end_period: '',
                task_type: 1,
                end_open: 1,
                attachment1: '',
                attachment2: '',
            },
            
            pageName: this.trans('admin.form.assignment.add_new_assignment'),

        }
    },
    created() {
        if (this.$route.name === 'subject_assignment_update') {
            this.pageName = this.trans('admin.form.assignment.edit_assignments');
            this.loading = true;

            axios.get('/api/admin/subjects/' + this.$route.params.id + '/assignments/'+ this.$route.params.assignment_id)
                .then((response) => {
                    this.form = response.data.data;
                    this.form.attachment1 = '';
                    this.form.attachment2 = '';
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

            let formData = new FormData();

            Object.keys(this.form).forEach(key => {
                formData.append(key, this.form[key]);
            });

            if (this.$route.name === 'subject_assignment_update') {
                formData.append('_method','patch')
                axios.post('/api/admin/subjects/' + this.$route.params.id + '/assignments/'+ this.$route.params.assignment_id, formData)
                    .then((response) => {
                        this.$router.push({name: 'subject_assignments', params: {semester_id: this.$route.params.semester_id}});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            }else{
                axios.post('/api/admin/subjects/' + this.$route.params.id + '/assignments', formData)
                    .then((response) => {
                        this.$router.push({name: 'subject_assignments', params: {semester_id: this.$route.params.semester_id}});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            }

            axios.post('/api/admin/delete/image', {images: this.deleteImages});
        },
        attachment1Upload(e) {
            this.form.attachment1 = e.target.files[0];
        },
        attachment2Upload(e) {
            this.form.attachment2 = e.target.files[0];
        },
        
    },
}
</script>


