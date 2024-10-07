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
                                <label>{{ trans('admin.form.sliders.heading') }}</label>
                                <input type="text" class="form_global"   v-model="form.heading">
                                <v-errors :errors="errorFor('heading')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.sliders.url') }}</label>
                                <input type="text" class="form_global"   v-model="form.url">
                                <v-errors :errors="errorFor('url')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.sliders.text') }}</label>
                                <input type="text" class="form_global"   v-model="form.text">
                                <v-errors :errors="errorFor('text')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.sliders.image') }}</label>
                                <div class="file_input">
                                    <input type="file" class="form_global" :placeholder="trans('admin.form.sliders.image')" @change="imageUpload($event)">
                                    <v-errors :errors="errorFor('image')"></v-errors>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="d_flex_end">
                        <router-link class="btn btn_secondary mr_5" :to="{name: 'sliders'}">{{ trans('admin.label.cancel') }}</router-link>
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
                heading: '',
                text: '',
                url: '',
                image: '',
            },
            pageName: this.trans('admin.form.sliders.add_new_slider'),

        }
    },
    created() {
        if (this.$route.name === 'sliders_edit') {
            this.loading = true;
            this.pageName = this.trans('admin.form.sliders.edit_slider');
            axios.get('/api/admin/sliders/'+ this.$route.params.id)
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

            if (this.$route.name === 'sliders_edit') {
                formData.append('_method', 'PUT');
                axios.post('/api/admin/sliders/'+ this.$route.params.id, formData)
                    .then((response) => {
                        this.$router.push({name: 'sliders'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            }else{
                axios.post('/api/admin/sliders', formData)
                    .then((response) => {
                        this.$router.push({name: 'sliders'});
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


