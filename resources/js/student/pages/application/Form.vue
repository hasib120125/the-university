<template>
    <div class="profile custom_p_40">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div >{{ pageName }}</div>
                        </div>
                        <div :class="['card-body', {'loading_overlay': loading}]">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group ">
                                        <label>{{ trans('new.index.subject') }}</label>
                                        <input type="text" class="form_global" v-model="form.subject">
                                        <v-errors :errors="errorFor('subject')"></v-errors>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>{{ trans('new.index.attachment') }}</label>
                                        <div class="d_flex_inline">
                                            <vue-dropzone ref="fileDropzone" class="form_global" v-on:vdropzone-removed-file="cancelFile" v-on:vdropzone-success="uploadFileSuccess" id="dropzone" :options="dropzoneVideoOptions"></vue-dropzone>
                                        </div>
                                        <v-errors :errors="errorFor('attachments')"></v-errors>
                                    </div>
                                </div>
                            </div>
                            <div class="d_flex_end">
                                <router-link class="btn btn_secondary mr_5" :to="{name: 'applications'}">{{ trans('student.label.cancel') }}</router-link>
                                <button class="btn btn_md btn_success" @click.prevent="submitForm">{{ trans('student.label.save') }}</button>
                            </div>

                        </div>
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
            loading: false,
            form: {
                title: '',
                files: [],
                originalFiles: [],
            },
            dropzoneVideoOptions: {
                url: '/api/student/application/attachment/upload',
                addRemoveLinks: true,
                thumbnailHeight: 120,
                acceptedFiles: "image/*,application/pdf,.doc,.docx",
                headers: {
                    "Authorization": `Bearer `+ JSON.parse(localStorage.getItem('user')).token,
                    "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                }
            },
            pageName: this.trans('new.index.add_application'),
        }
    },
    created() {
        
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
                axios.post('/api/student/application/attachment/delete', {deleteFile}).then((response) => {
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
            axios.post('/api/student/applications', this.form)
                .then((response) => {
                    this.$router.push({name: 'applications'});
                })
                .catch((err) => this.errors = err.response.data.errors)
                .finally(() => this.loading = false);
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
</style>


