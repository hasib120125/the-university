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
                                <label for="name">{{ trans('admin.form.lecture.lecture_name') }}</label>
                                <input id="name" type="text" class="form_global" v-model="form.name">
                                <v-errors :errors="errorFor('name')"></v-errors>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col_4">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.lecture.start_period') }}</label>
                                <datepicker :typeable="true"  input-class="form_global form_date_picker" :value="form.start_period" @input="form.start_period = dateFormat($event, 'YYYY-MM-DD') "></datepicker>
                                 <v-errors :errors="errorFor('start_period')"></v-errors>
                            </div>
                        </div>
                        <div class="col_4">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.lecture.end_period') }}</label>
                                <datepicker :typeable="true"  input-class="form_global form_date_picker" :value="form.end_period" @input="form.end_period = dateFormat($event, 'YYYY-MM-DD') "></datepicker>
                                 <v-errors :errors="errorFor('end_period')"></v-errors>
                            </div>
                        </div>
                        <div class="col_4">
                            <div class="form-group mb_5 mt_15 "><label class="pb_0">{{ trans('admin.form.lecture.status') }}</label> </div>
                            <div class="form_radio">
                                <input type="radio" id="status_1" name="radio" v-model="form.status" value="1">
                                <label for="status_1">{{ trans('admin.form.lecture.active') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" id="status_0" name="radio" v-model="form.status" value="0">
                                <label for="status_0">{{ trans('admin.form.lecture.inactive') }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col_4">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.lecture_management.video') }}</label>
                                <multiselect v-model="selectedVideo" :allow-empty="false" :options="videos" track-by="id" label="original_filename" 
                                    :placeholder="trans('admin.form.lecture_management.select_video')" open-direction="bottom">
                                    <template slot="singleLabel" slot-scope="{ option }">{{ option.original_filename }}</template>
                                </multiselect>
                                <v-errors :errors="errorFor('bulk_video_id')"></v-errors>
                            </div>
                        </div>
                        <div class="col_4">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.lecture_management.audio') }}</label>
                                <multiselect v-model="selectedAudeo" :allow-empty="false" :options="audios" track-by="id" label="original_filename" 
                                    :placeholder="trans('admin.form.lecture_management.select_audio')" open-direction="bottom">
                                    <template slot="singleLabel" slot-scope="{ option }">{{ option.original_filename }}</template>
                                </multiselect>
                                <v-errors :errors="errorFor('bulk_audio_id')"></v-errors>
                            </div>
                        </div>
                        <div class="col_4">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.lecture_management.subtitle') }}</label>
                                <multiselect v-model="selectedSubtitle" :allow-empty="false" :options="subtitles" track-by="id" label="original_filename" 
                                    :placeholder="trans('admin.form.lecture_management.select_subtitle')" open-direction="bottom">
                                    <template slot="singleLabel" slot-scope="{ option }">{{ option.original_filename }}</template>
                                </multiselect>
                                <v-errors :errors="errorFor('bulk_subtitle_id')"></v-errors>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col_12">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.lecture_management.content_description') }}</label>
                                <textarea class="form_global" rows="5" v-model="form.description" ></textarea>
                                <v-errors :errors="errorFor('description')"></v-errors>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-if="form.convert_status == 'Completed'">
                        <div class="col_12">
                            <div id="player"></div>
                        </div>
                    </div>

                    <div class="d_flex_end mt_10">
                        <router-link class="btn btn_secondary mr_5" :to="{name: 'subject_lectures', params:{semester_id: $route.params.semester_id}}">{{ trans('professor.label.cancel') }}</router-link>
                        <button class="btn btn_md btn_success" @click.prevent="submitForm">{{ trans('admin.label.save') }}</button>
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
import Multiselect from "vue-multiselect"

export default {
    mixins: [validationErrors],
    components: {
        FroalaTextEditor,
        Datepicker,
        vueDropzone: vue2Dropzone,
        Multiselect,
    },
    data(){
        return {
            deleteImages: [],
            form: {
                name: null,
                subject_id: this.$route.params.id,
                semester_id: this.$route.params.semester_id,
                bulk_video_id: '',
                bulk_audio_id: '',
                bulk_subtitle_id: '',
                description: null,
                start_period: null,
                end_period: null,
                status: 1,
                convert_status: null,
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
            pageName: this.trans('admin.form.lecture.add_new_lecture'),
            loading: false,
            audios: [],
            videos: [],
            subtitles: [],
            selectedVideo: '',
            selectedAudeo: '',
            selectedSubtitle: '',
        }
    },
    created() {

        axios.get('/api/admin/bulk-audio')
            .then((response) => {
                this.audios = response.data.data
            })

        axios.get('/api/admin/bulk-subtitle')
            .then((response) => {
                this.subtitles = response.data.data
            })

        axios.get('/api/admin/bulk-video/forLecture')
            .then((response) => {
                this.videos = response.data.data
            })

        if (this.$route.name === 'lectures_edit') {
            this.loading = true;
            this.pageName = this.trans('admin.form.lecture.edit_lecture');
            axios.get('/api/admin/lectures/'+ this.$route.params.lecture_id)
                .then((response) => {
                    this.form = response.data.data;
                    this.selectedVideo = this.form.bulkVideo
                    this.selectedAudeo = this.form.bulkAudio
                    this.selectedSubtitle = this.form.bulkSubtitle
                    this.form.original_video_file = '';
                    this.form.audio_file = '';

                    if(this.form.convert_status == 'Completed'){
                        setTimeout(() => {
                        jwplayer("player").setup({
                            file: this.form.smil,
                            "tracks": [{
                                "kind": "captions",
                                "file": response.data.data.subtitle_file_formatted,
                                "label": response.data.data.subtitle_label
                            }]
                        });
                    }, 200);
                    }
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
        cancelFile(file, error, xhr){
            this.form.original_video_file = null
        },
        cancelAudioFile(file, error, xhr){
            this.form.audio_file = null
        },
        submitForm(){
            this.loading = true;
            this.errors = null;
            if(this.selectedVideo)
                    this.form.bulk_video_id = this.selectedVideo.id
            if(this.selectedAudeo)
                    this.form.bulk_audio_id = this.selectedAudeo.id
            if(this.selectedSubtitle)
                    this.form.bulk_subtitle_id = this.selectedSubtitle.id

            if (this.$route.name === 'lectures_edit') {
                axios.patch('/api/admin/lectures/'+ this.$route.params.lecture_id, this.form)
                    .then((response) => {
                        this.$router.push({name: 'subject_lectures', params:{semester_id: this.$route.params.semester_id}});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            }else{

                axios.post('/api/admin/lectures', this.form)
                    .then((response) => {
                        this.$router.push({name: 'subject_lectures', params:{semester_id: this.$route.params.semester_id}});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);
            }

            axios.post('/api/admin/delete/image', {images: this.deleteImages});
        }
    },
}
</script>


