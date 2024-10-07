<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title width_full">
                        <div class="d_flex_btwn">
                            <div>{{ pageName }}</div>
                            <button @click.prevent="addNewImage()" class="btn btn_info">{{ trans('admin.form.gallery.add_new_image') }}</button>
                        </div>
                    </div>
                </div>
                <div :class="['card-body', {'loading_overlay': loading}]">
                    <div class="row" v-if="gallery">
                        <div class="col_12">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table_bordered   table_fixed">
                                        <tbody>
                                            <tr>
                                                <th>Gallery Name:</th>
                                                <td>{{ gallery.name}}</td>
                                            </tr>
                                            <tr>
                                                <th>Gallery Description:</th>
                                                <td>{{ gallery.description}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-if="gallery && gallery.images.length">
                        <div class="col_12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col_1" v-for="(image, i) in gallery.images" :key="'image_'+i">
                                            <img :src="image.image" alt="" class="width_full">
                                            <a class="btn btn_danger width_full mt_5" href="Javascript:void(0)" @click="deleteItem(image)">Delete</a>
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
                                <div class="col_8">
                                    <div class="form-group">
                                        <label>{{ this.trans('admin.form.gallery.image') }}</label>
                                        <input type="file" class="form_global" @change="selectImage" >
                                        <v-errors :errors="errorFor('image')"></v-errors>
                                    </div>
                                </div>
                                <div class="col_4 mt_20">
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
import FroalaTextEditor from "./../../components/FroalaTextEditor";

export default {
    mixins: [validationErrors],
    components: {FroalaTextEditor},
    data(){
        return {
            modelOpen: false,
            modelStatus: null,
            gallery:null,
            pageName: this.trans('admin.form.gallery.view'),
            form:{
                image:null,
            }
        }
    },
    created() {
        this.loading = true;
        this.getImages();
    },
    methods: {
        getImages(){
            this.loading = true;
            axios.get('/api/admin/galleries/'+this.$route.params.id)
                .then((response) => {
                    this.gallery = response.data.data;
                }).finally(() => this.loading = false);
        },
        closeModal(){
            this.modelOpen = false;
        },
        selectImage(e){
            this.form.image = e.target.files[0];
        },
        addNewImage(){
            this.form.image = null;
            this.modelOpen = true;
        },
        submitForm() {
            this.errors = null;
            this.loading = true;
            let formData = new FormData();
            Object.keys(this.form).forEach(key => {
                formData.append(key, this.form[key]);
            });
            axios.post('/api/admin/galleries/'+this.$route.params.id+'/images', formData)
                .then((response) => {
                    this.$swal.fire(
                        this.trans('common.message.success'),
                        this.trans('common.message.setting_update_message'),
                        'success'
                    )
                    this.modelOpen = false;
                    this.getImages()
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
                    axios.delete('/api/admin/galleries/'+item.gallery_id+'/images/'+item.id).then(() => {
                        this.getImages();
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
