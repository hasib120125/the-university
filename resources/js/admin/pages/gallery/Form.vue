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
                            <div class="form-group">
                                <label>{{ this.trans('admin.form.gallery.name_en') }}</label>
                                <input type="text" class="form_global" v-model="form.name_en">
                                <v-errors :errors="errorFor('name_en')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ this.trans('admin.form.gallery.name_kr') }}</label>
                                <input type="text" class="form_global" v-model="form.name_kr">
                                <v-errors :errors="errorFor('name_kr')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ this.trans('admin.form.gallery.description_en') }}</label>
                                <textarea class="form_global" v-model="form.description_en" cols="30" rows="10"></textarea>
                                <v-errors :errors="errorFor('description_en')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ this.trans('admin.form.gallery.description_kr') }}</label>
                                <textarea class="form_global" v-model="form.description_kr" cols="30" rows="10"></textarea>
                                <v-errors :errors="errorFor('description_kr')"></v-errors>
                            </div>
                        </div>
                        <div class="col_12">
                            <div class="d_flex_end">
                                <router-link class="btn btn_secondary mr_5" :to="{name: 'galleries'}">{{ trans('admin.label.cancel') }}</router-link>
                                <button class="btn btn_md btn_success" @click.prevent="submitForm">{{ trans('admin.label.save') }}</button>
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
            deleteImages: [],
            form: {
                name_en: '',
                name_kr: '',
                description_en: '',
                description_kr: '',
            },
            pageName: this.trans('admin.form.gallery.add_new'),
        }
    },
    created() {
        if (this.$route.name === 'galleries_edit') {
            this.loading = true;
            this.pageName = this.trans('admin.form.gallery.edit_gallery');
            axios.get('/api/admin/galleries/'+ this.$route.params.id)
                .then((response) => {
                    this.form = response.data.data;
                }).finally(() => this.loading = false);
        }
    },
    methods: {
        submitForm() {
            this.loading = true;
            this.errors = null;
            if (this.$route.name === 'galleries_edit') {
                axios.patch('/api/admin/galleries/'+ this.$route.params.id, this.form)
                    .then((response) => {
                        this.$router.push({name: 'galleries'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            } else {
                axios.post('/api/admin/galleries', this.form)
                    .then((response) => {
                        this.$router.push({name: 'galleries'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);
            }

        },
    },
}
</script>
