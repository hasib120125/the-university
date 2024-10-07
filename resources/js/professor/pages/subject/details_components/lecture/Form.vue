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
                                <label for="name">{{ trans('professor.form.lecture.lecture_name') }}</label>
                                <input id="name" type="text" class="form_global" v-model="form.name">
                                <v-errors :errors="errorFor('name')"></v-errors>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('professor.form.lecture.start_period') }}</label>
                                <datepicker :typeable="true"  input-class="form_global form_date_picker" :value="form.start_period" @input="form.start_period = dateFormat($event, 'YYYY-MM-DD') "></datepicker>
                                 <v-errors :errors="errorFor('start_period')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group mb_5 mt_15 "><label class="pb_0">{{ trans('professor.form.lecture.status') }}</label> </div>
                            <div class="form_radio">
                                <input type="radio" id="status_1" name="radio" v-model="form.status" value="1">
                                <label for="status_1">{{ trans('professor.form.lecture.active') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" id="status_0" name="radio" v-model="form.status" value="0">
                                <label for="status_0">{{ trans('professor.form.lecture.inactive') }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col_4">
                            <div class="form-group">
                                <label>{{ trans('professor.form.lecture_management.video') }}</label>
                                <div class="d_flex_inline">
                                    <vue-dropzone ref="fileDropzone" class="form_global mr_5" v-on:vdropzone-removed-file="cancelFile" v-on:vdropzone-success="uploadFileSuccess" id="dropzone" :options="dropzoneVideoOptions"></vue-dropzone>
                                </div>
                                <v-errors :errors="errorFor('original_video_file')"></v-errors>
                            </div>
                        </div>
                        <div class="col_4">
                            <div class="form-group">
                                <label>{{ trans('professor.form.lecture_management.audio') }}</label>
                                <div class="d_flex_inline">
                                    <vue-dropzone ref="fileDropzone" class="form_global mr_5" v-on:vdropzone-removed-file="cancelAudioFile" v-on:vdropzone-success="uploadAudioSuccess" id="dropzone" :options="dropzoneAudioOptions"></vue-dropzone>
                                </div>
                                <v-errors :errors="errorFor('audio_file')"></v-errors>
                            </div>
                        </div>
                        <div class="col_4">
                            <div class="form-group">
                                <label>{{ trans('professor.form.lecture_management.subtitle') }}</label>
                                <div class="d_flex_inline">
                                    <vue-dropzone ref="fileDropzone" class="form_global mr_5" v-on:vdropzone-removed-file="cancelSubtitleFile" v-on:vdropzone-success="uploadSubtitleSuccess" id="dropzone" :options="dropzoneSubtitleOptions"></vue-dropzone>
                                </div>
                                <v-errors :errors="errorFor('subtitle_file')"></v-errors>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col_12">
                            <div class="form-group ">
                                <label>{{ trans('professor.form.lecture_management.content_description') }}</label>
                                <!-- <froala-text-editor :model.sync="form.description" :deleteImages.sync="deleteImages"/> -->
                                <textarea class="form_global" rows="5" v-model="form.description" ></textarea>
                                <v-errors :errors="errorFor('description')"></v-errors>
                            </div>
                        </div>
                    </div>

                    <div class="d_flex_end">
                        <router-link class="btn btn_secondary mr_5" :to="{name: 'subject_lectures', params:{semester_id: $route.params.semester_id}}">{{ trans('professor.label.cancel') }}</router-link>
                        <button class="btn btn_md btn_success" @click.prevent="submitForm">{{ trans('professor.label.save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import validationErrors from "../../../../mixins/validationErrors";
import Datepicker from 'vuejs-datepicker';
import FroalaTextEditor from "./../../../../components/FroalaTextEditor";
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

export default {
    mixins: [validationErrors],
    components: {
        FroalaTextEditor,
        Datepicker,
        vueDropzone: vue2Dropzone,
    },
    data(){
        return {
            deleteImages: [],
            form: {
                name: null,
                subject_id: this.$route.params.id,
                semester_id: this.$route.params.semester_id,
                audio_file: null,
                subtitle_file: null,
                original_video_file: null,
                description: null,
                start_period: null,
                end_period: null,
                status: 1
            },
            dropzoneVideoOptions: {
                url: '/api/professor/upload/video/temp',
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
                url: '/api/professor/upload/temp',
                addRemoveLinks: true,
                thumbnailHeight: 120,
                acceptedFiles: "audio/mpeg",
                maxFiles:1,
                headers: {
                    "Authorization": `Bearer `+ JSON.parse(localStorage.getItem('user')).token,
                    "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                }
            },
            dropzoneSubtitleOptions: {
                url: '/api/professor/upload/temp',
                addRemoveLinks: true,
                thumbnailHeight: 120,
                acceptedFiles: ".srt",
                maxFiles:1,
                headers: {
                    "Authorization": `Bearer `+ JSON.parse(localStorage.getItem('user')).token,
                    "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                }
            },
            pageName: this.trans('professor.form.lecture.add_new_lecture'),
            loading: false,
        }
    },
    created() {

        if (this.$route.name === 'lectures_edit') {
            this.loading = true;
            this.pageName = this.trans('professor.form.lecture.edit_lecture');
            axios.get('/api/professor/lectures/'+ this.$route.params.lecture_id)
                .then((response) => {
                    this.form = response.data.data;
                    this.form.original_video_file = '';
                    this.form.audio_file = '';
                    this.form.subtitle_file = '';
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
            this.form.original_video_file = response
        },
        uploadAudioSuccess(file, response){
            this.form.audio_file = response
        },
        uploadSubtitleSuccess(file, response){
            this.form.subtitle_file = response
        },
        cancelFile(file, error, xhr){
            this.form.original_video_file = null
        },
        cancelAudioFile(file, error, xhr){
            this.form.audio_file = null
        },
        cancelSubtitleFile(file, error, xhr){
            this.form.subtitle_file = null
        },
        submitForm(){
            this.loading = true;
            this.errors = null;
            if (this.$route.name === 'lectures_edit') {

                axios.patch('/api/professor/lectures/'+ this.$route.params.id, this.form)
                    .then((response) => {
                        this.$router.push({name: 'subject_lectures', params:{semester_id: this.$route.params.semester_id}});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            }else{

                axios.post('/api/professor/lectures', this.form)
                    .then((response) => {
                        this.$router.push({name: 'subject_lectures', params:{semester_id: this.$route.params.semester_id}});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);
            }

            axios.post('/api/professor/delete/image', {images: this.deleteImages});
        }
    },
}
</script>


