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
                                <label>{{ trans('admin.form.lecture_management.lecture_no') }}</label>
                                <input type="number" class="form_global" min="1"  v-model="form.lecture_number">
                                <v-errors :errors="errorFor('lecture_number')"></v-errors>
                            </div>
                        </div>
                        <div class="col_4">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.lecture_management.lecture_start_period') }}</label>
                                <datepicker :typeable="true"  input-class="form_global form_date_picker" format="yyyy-MM-dd" v-model="form.start_period"></datepicker>
                                <v-errors :errors="errorFor('start_period')"></v-errors>
                            </div>
                        </div>
                        <div class="col_4">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.lecture_management.lecture_end_period') }}</label>
                                <datepicker :typeable="true"  input-class="form_global form_date_picker" format="yyyy-MM-dd" v-model="form.end_period"></datepicker>
                                <v-errors :errors="errorFor('end_period')"></v-errors>
                            </div>
                        </div>
                        <div class="col_12">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.lecture_management.lecture_name') }}</label>
                                <input type="text" class="form_global" v-model="form.lecture_name">
                                <v-errors :errors="errorFor('lecture_name')"></v-errors>
                            </div>
                        </div>
                        <div class="col_4">
                            <div class="form-group">
                                <label>{{ trans('admin.form.lecture_management.video') }}</label>
                                <div class="d_flex_inline">
                                    <vue-dropzone ref="fileDropzone" class="form_global mr_5" v-on:vdropzone-removed-file="cancelFile" v-on:vdropzone-success="uploadFileSuccess" id="dropzone" :options="dropzoneVideoOptions"></vue-dropzone>
                                </div>
                                <v-errors :errors="errorFor('file')"></v-errors>
                            </div>
                        </div>
                        <div class="col_4">
                            <div class="form-group">
                                <label>{{ trans('admin.form.lecture_management.audio') }}</label>
                                <div class="d_flex_inline">
                                    <vue-dropzone ref="fileDropzone" class="form_global mr_5" v-on:vdropzone-removed-file="cancelAudioFile" v-on:vdropzone-success="uploadAudioSuccess" id="dropzone" :options="dropzoneAudioOptions"></vue-dropzone>
                                </div>
                                <v-errors :errors="errorFor('file')"></v-errors>
                            </div>
                        </div>
                        <div class="col_4">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.lecture_management.video_running_time') }}</label>
                                <vue-timepicker format="HH:mm:ss" input-width="250px" v-model="form.video_running_time" hide-clear-button></vue-timepicker>
                                <v-errors :errors="errorFor('video_running_time')"></v-errors>
                            </div>
                        </div>
                        <div class="col_12">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.lecture_management.content_description') }}</label>
                                <froala-text-editor :model.sync="form.description" :deleteImages.sync="deleteImages"/>
                                <v-errors :errors="errorFor('description')"></v-errors>
                            </div>
                        </div>

                    </div>

                    <div class="d_flex_end">
                        <router-link class="btn btn_secondary mr_5" :to="{name: 'lecture_managements'}">{{ trans('admin.label.cancel') }}</router-link>
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
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
import VueTimepicker from 'vue2-timepicker/src/vue-timepicker.vue'

export default {
    name:'lecture-management-add',
    mixins: [validationErrors],
    components: {
        FroalaTextEditor,
        Datepicker,
        vueDropzone: vue2Dropzone,
        VueTimepicker
    },
    data(){
        return {
            deleteImages: [],
            form: {
                lecture_number: null,
                lecture_name:null,
                audio:null,
                file:null,
                video_running_time:'',
                description:null,
                start_period:null,
                end_period: null,
            },
            dropzoneVideoOptions: {
                url: '/api/admin/upload/temp',
                addRemoveLinks: true,
                thumbnailHeight: 120,
                maxFiles:1,
                acceptedFiles: "video/mp4,video/x-m4v,video/*",
                headers: {
                    "Authorization": `Bearer `+ JSON.parse(localStorage.getItem('user')).token,
                    "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                }
            },
            dropzoneAudioOptions: {
                url: '/api/admin/upload/temp',
                addRemoveLinks: true,
                thumbnailHeight: 120,
                acceptedFiles: "audio/mpeg",
                maxFiles:1,
                headers: {
                    "Authorization": `Bearer `+ JSON.parse(localStorage.getItem('user')).token,
                    "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                }
            },
            
            pageName: this.trans('admin.form.lecture_management.add_new_lecture_material'),

        }
    },
    created() {
        if (this.$route.name === 'lecture_management_update') {
            this.pageName = this.trans('admin.form.lecture_management.edit_lecture_matrials');
            this.loading = true;
            axios.get('/api/admin/lectures/' + this.$route.params.id + '/managements/'+ this.$route.params.management_id)
                .then((response) => {
                    this.form = response.data.data;
                    this.form.file = '';
                    this.form.audio = '';
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
        uploadFileSuccess(file, response){
            this.form.file = response
        },
        uploadAudioSuccess(file, response){
            this.form.audio = response
        },
        cancelFile(file, error, xhr){
            this.form.file = null
        },
        cancelAudioFile(file, error, xhr){
            this.form.audio = null
        },
        submitForm(){
            this.loading = true;
            this.errors = null;

            let formData = this.form;

            if (this.$route.name === 'lecture_management_update') {
                axios.patch('/api/admin/lectures/' + this.$route.params.id + '/managements/'+ this.$route.params.management_id, formData)
                    .then((response) => {
                        this.$router.push({name: 'lecture_managements'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            }else{
                axios.post('/api/admin/lectures/' + this.$route.params.id + '/managements', formData)
                    .then((response) => {
                        this.$router.push({name: 'lecture_managements'});
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


