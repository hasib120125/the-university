<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ pageName }}</div>
                </div>
                <div :class="['card-body', {'loading_overlay': loading}]">
                    <div class="row">
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.features.name_en') }}</label>
                                <input type="text" class="form_global"   v-model="form.name">
                                <v-errors :errors="errorFor('name')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.features.name_ko') }}</label>
                                <input type="text" class="form_global"   v-model="form.name_ko">
                                <v-errors :errors="errorFor('name_ko')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.features.description_en') }}</label>
                                <input type="text" class="form_global"   v-model="form.text">
                                <v-errors :errors="errorFor('text')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.features.description_ko') }}</label>
                                <input type="text" class="form_global"   v-model="form.text_ko">
                                <v-errors :errors="errorFor('text_ko')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.features.image') }}</label>
                                <div class="file_input">
                                    <input type="file" class="form_global" :placeholder="trans('admin.form.features.image')" @change="imageUpload($event)">
                                    <v-errors :errors="errorFor('image')"></v-errors>
                                </div>
                            </div>
                        </div>
                        <div class="col_4">
                            <div class="form-group mb_5 mt_15 "><label class="pb_0">{{ trans('admin.form.features.status') }}</label> </div>
                            <div class="form_radio">
                                <input type="radio" id="Active"  v-model="form.status" value="1">
                                <label for="Active">{{ trans('admin.form.features.active') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" id="Inactive"  v-model="form.status" value="0">
                                <label for="Inactive">{{ trans('admin.form.features.inactive') }}</label>
                            </div>
                            <v-errors :errors="errorFor('status')"></v-errors>
                        </div>

                    </div>

                    <div class="d_flex_end">
                        <router-link class="btn btn_secondary mr_5" :to="{name: 'features'}">{{ trans('admin.label.cancel') }}</router-link>
                        <button class="btn btn_md btn_success" @click.prevent="submitForm">{{ trans('admin.label.save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import validationErrors from "../../mixins/validationErrors";

export default {
    mixins: [validationErrors],
    data(){
        return {
            form: {
                name: '',
                name_ko: '',
                text: '',
                text_ko: '',
                image: '',
                status: 1,
            },
            pageName: this.trans('admin.form.features.add_new_feature'),

        }
    },
    created() {
        if (this.$route.name === 'features_edit') {
            this.loading = true;
            this.pageName = this.trans('admin.form.features.edit_feature');
            axios.get('/api/admin/features/'+ this.$route.params.id)
                .then((response) => {
                    this.form = response.data.data;
                    this.form.image = '';
                }).finally(() => this.loading = false);
        }
    },
    methods: {
        submitForm(){
            this.errors = null;
            this.loading = true;
            let formData = new FormData();

            Object.keys(this.form).forEach(key => {
                formData.append(key, this.form[key]);
            });

            if (this.$route.name === 'features_edit') {
                formData.append('_method', 'PUT');
                axios.post('/api/admin/features/'+ this.$route.params.id, formData)
                    .then((response) => {
                        this.$router.push({name: 'features'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            }else{
                axios.post('/api/admin/features', formData)
                    .then((response) => {
                        this.$router.push({name: 'features'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            }
        },
        imageUpload(e) {
            this.form.image = e.target.files[0];
        },
    },
}
</script>


