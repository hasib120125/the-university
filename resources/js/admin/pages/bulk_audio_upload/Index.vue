<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ trans('admin.form.bulk_upload.bulk_upload') }}</div>
                </div>
                <div :class="['card-body', {'loading_overlay': loading}]">
                    <div class="row">
                        <div class="col_12">
                            <div class="form-group">
                                <label>{{ trans('admin.form.bulk_upload.audio') }}</label>
                                <div class="d_flex_inline">
                                    <vue-dropzone ref="fileDropzone" class="form_global mr_5" v-on:vdropzone-removed-file="cancelFile" v-on:vdropzone-success="uploadFileSuccess" id="dropzone" :options="dropzoneVideoOptions"></vue-dropzone>
                                </div>
                                <v-errors :errors="errorFor('file')"></v-errors>
                            </div>
                        </div>
                    </div>

                    <div class="d_flex_end">
                        <button class="btn btn_md btn_success mr_5" @click.prevent="submitForm">{{ trans('admin.label.save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import validationErrors from "../../mixins/validationErrors";
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

export default {
    mixins: [validationErrors],
    components: {
        vueDropzone: vue2Dropzone,
    },
    data(){
        return {
            form: {
                files: [],
                originalFiles: [],
            },
            dropzoneVideoOptions: {
                url: '/api/admin/upload/temp',
                addRemoveLinks: true,
                maxFilesize: 5120,
                thumbnailHeight: 120,
                timeout: 9999990000,
                acceptedFiles: "audio/*",
                headers: {
                    "Authorization": `Bearer `+ JSON.parse(localStorage.getItem('user')).token,
                    "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                }
            },
        }
    },

    methods: {
        uploadFileSuccess(file, response) {
            this.form.originalFiles.push(file.name);
            this.form.files.push(response);
        },
        cancelFile(file, error, xhr){
            let index = this.form.originalFiles.findIndex(item => item === file.name);

            let deleteFile = this.form.files[index];

            if(this.$refs.fileDropzone.dropzone.disabled !== true){
                axios.post('/api/admin/bulk/audio-file/delete', {deleteFile}).then((response) => {
                    this.$swal.fire(
                        this.trans('common.message.deleted'),
                        this.trans('common.message.delete_message'),
                        'success'
                    )
                });

                this.form.originalFiles.splice(index, 1);
                this.form.files.splice(index, 1);
            }
        },
        submitForm(){
            this.loading = true;
            this.errors = null;

            axios.post('/api/admin/bulk/audio-file/upload', this.form)
                .then((response) => {
                    this.$router.push({name: 'bulk_audio_list'});
                })
                .catch((err) => this.errors = err.response.data.errors)
                .finally(() => this.loading = false);
        }
    },
}
</script>


