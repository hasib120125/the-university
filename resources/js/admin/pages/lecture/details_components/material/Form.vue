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
                                <label>{{ trans('admin.form.lecture_material.title') }}</label>
                                <input type="text" class="form_global"   v-model="form.title">
                                <v-errors :errors="errorFor('title')"></v-errors>
                            </div>
                        </div>

                        <div class="col_12">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.lecture_material.description') }}</label>
                                <froala-text-editor :model.sync="form.description" :deleteImages.sync="deleteImages"/>
                                <v-errors :errors="errorFor('description')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.lecture_material.attachment_1') }}</label>
                                <div class="file_input">
                                    <input type="file" id="file" ref="file" class="form_global" placeholder="" @change="attachment1Upload($event)">
                                    <v-errors :errors="errorFor('attachment1')"></v-errors>
                                </div>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.lecture_material.attachment_2') }}</label>
                                <div class="file_input">
                                    <input type="file" class="form_global" placeholder="" @change="attachment2Upload($event)">
                                    <v-errors :errors="errorFor('attachment1')"></v-errors>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="d_flex_end">
                        <router-link class="btn btn_secondary mr_5" :to="{name: 'lecture_materials'}">{{ trans('admin.label.cancel') }}</router-link>
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

export default {
    mixins: [validationErrors],
    components: {FroalaTextEditor},
    data(){
        return {
            deleteImages: [],
            form: {
                title: null,
                category: null,
                description: null,
                attachment1: '',
                attachment2: '',
            },
            
            pageName: this.trans('admin.form.lecture_material.add_new_material'),

        }
    },
    created() {
        if (this.$route.name === 'lecture_material_update') {
            this.pageName = this.trans('admin.form.lecture_material.edit_materials');
            this.loading = true;
            axios.get('/api/admin/lectures/' + this.$route.params.id + '/materials/'+ this.$route.params.material_id)
                .then((response) => {
                    this.form = response.data.data;
                    this.form.attachment1 = '';
                    this.form.attachment2 = '';
                }).finally(() => this.loading = false);
        }
    },
    methods: {
        submitForm(){
            this.loading = true;
            this.errors = null;

            let formData = new FormData();

            Object.keys(this.form).forEach(key => {
                formData.append(key, this.form[key]);
            });

            if (this.$route.name === 'lecture_material_update') {
                formData.append('_method','patch')
                axios.post('/api/admin/lectures/' + this.$route.params.id + '/materials/'+ this.$route.params.material_id, formData)
                    .then((response) => {
                        this.$router.push({name: 'lecture_materials'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            }else{
                axios.post('/api/admin/lectures/' + this.$route.params.id + '/materials', formData)
                    .then((response) => {
                        this.$router.push({name: 'lecture_materials'});
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


