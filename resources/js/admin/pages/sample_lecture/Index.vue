<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title width_full">
                        <div class="d_flex_btwn">
                            <div>{{ pageName }}</div>
                            <button @click.prevent="addNewVideo()" class="btn btn_info">{{ trans('admin.form.sample_lecture.add_new_lecture_video') }}</button>
                        </div>
                    </div>
                </div>
                <div :class="['card-body', {'loading_overlay': loading}]">
                    <div class="row">
                        <div class="col_12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col_3" v-for="(sampleLecture, i) in sampleLectures" :key="'image_'+i">
                                            <video-component :video="sampleLecture.video" :id="'player_'+i"></video-component>
<!--                                            <video width="400" controls="true" class="width_full">
                                                <source :src="sampleLecture.video" type="video/mkv">
                                                &lt;!&ndash; <source src="mov_bbb.ogg" type="video/ogg">  &ndash;&gt;
                                            </video>-->
                                            <a class="btn btn_danger width_full mt_5 mb_5" href="Javascript:void(0)" @click="deleteItem(sampleLecture)">{{ trans('admin.label.delete') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" data-modal="modal" :class="{open_modal:modelOpen}">
            <div class="modal_overlay" data-modal-close="modal"></div>
            <div class="modal_inner">
                <div class="modal_header">
                    <span data-modal-close="modal" class="close_icon close_icon_sm" @click.prevent="closeModal">×</span>
                </div>
                <div class="modal_wrapper ">
                    <div class="modal_content modal_1080p">
                        <div class="container">
                            <div class="row">
                                <div class="col_11">
                                    <div class="form-group">
                                        <label>{{ this.trans('admin.form.sample_lecture.video') }}</label>
                                        <input type="file" id="sample_lecture_video" class="form_global" @change="selectVideo" accept="video/mp4,video/x-m4v,video/*">
                                        <v-errors :errors="errorFor('video')"></v-errors>
                                    </div>
                                </div>
                                <div class="col_1 mt_20">
                                    <div class="d_flex_end pt_10">
                                        <button  class="btn btn_md btn_success" @click.prevent="submitForm">{{ trans('admin.label.save') }}</button>
                                    </div>
                                </div>
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
import VideoComponent from "./VideoComponent";

export default {
    mixins: [validationErrors],
    components: {VideoComponent},
    data(){
        return {
            modelOpen: false,
            modelStatus: null,
            sampleLectures: [],
            pageName: this.trans('admin.form.sample_lecture.title'),
            form:{
                video: null,
            }
        }
    },
    created() {
        this.loading = true;
        this.sampleLecture();
    },
    methods: {
        sampleLecture(){
            this.loading = true;
            axios.get('/api/admin/sample-lectures')
                .then((response) => {
                    this.sampleLectures = response.data.data;
                }).finally(() => this.loading = false);
        },
        closeModal(){
            $('#sample_lecture_video').val('');
            this.form.video = null;
            this.modelOpen = false;
        },
        selectVideo(e){
            this.form.video = e.target.files[0];
        },
        addNewVideo(){
            this.form.video = null;
            this.modelOpen = true;
        },
        submitForm() {
            this.errors = null;
            this.loading = true;
            let formData = new FormData();
            Object.keys(this.form).forEach(key => {
                formData.append(key, this.form[key]);
            });

            axios.post('/api/admin/sample-lectures', formData)
                .then((response) => {
                    this.$swal.fire(
                        this.trans('common.message.success'),
                        this.trans('common.message.uploaded_message'),
                        'success'
                    )
                    this.closeModal()
                    this.sampleLecture()
                })
                .catch((err) => {
                    this.modelOpen = true;
                    this.errors = err.response.data.errors
                })
                .finally(() => {
                    this.loading = false;
                });
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
                    axios.delete('/api/admin/sample-lectures/' + item.id).then(() => {
                        this.sampleLecture();
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
