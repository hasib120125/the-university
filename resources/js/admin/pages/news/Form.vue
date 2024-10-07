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
                                <label>{{ this.trans('admin.form.news.title_english') }}</label>
                                <input type="text" class="form_global" v-model="form.title_en">
                                <v-errors :errors="errorFor('title_en')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ this.trans('admin.form.news.title_korean') }}</label>
                                <input type="text" class="form_global" v-model="form.title_ko">
                                <v-errors :errors="errorFor('title_ko')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ this.trans('admin.form.news.summary_en') }}</label>
                                <textarea class="form_global" v-model="form.summary_en" cols="30" rows="10"></textarea>
                                <v-errors :errors="errorFor('summary_en')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ this.trans('admin.form.news.summary_ko') }}</label>
                                <textarea class="form_global" v-model="form.summary_ko" cols="30" rows="10"></textarea>
                                <v-errors :errors="errorFor('summary_ko')"></v-errors>
                            </div>
                        </div>

                        <div class="col_12">
                            <div class="form-group ">
                                <label>{{ this.trans('admin.form.news.content_en') }}</label>
                                <froala-text-editor :model.sync="form.content_en" :deleteImages.sync="deleteImages" />
                                <v-errors :errors="errorFor('content_en')"></v-errors>
                            </div>
                        </div>
                        <div class="col_12">
                            <div class="form-group ">
                                <label>{{ this.trans('admin.form.news.content_ko') }}</label>
                                <froala-text-editor :model.sync="form.content_ko" :deleteImages.sync="deleteImages" />
                                <v-errors :errors="errorFor('content_ko')"></v-errors>
                            </div>
                        </div>

                        <div class="col_4">
                            <div class="form-group">
                                <label>{{ this.trans('admin.form.news.banner') }}</label>
                                <div class="file_input">
                                    <input type="file" id="file" ref="file" class="form_global" placeholder="Photo" @change="form.banner = $event.target.files[0]">
                                    <v-errors :errors="errorFor('banner')"></v-errors>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d_flex_end">
                        <router-link class="btn btn_secondary mr_5" :to="{name: 'news'}">{{ trans('admin.label.cancel') }}</router-link>
                        <button class="btn btn_md btn_success" @click.prevent="submitForm">{{ trans('admin.label.save') }}</button>
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
                title_en: '',
                title_ko: '',
                content_en: '',
                content_ko: '',
                summary_en: '',
                summary_ko: '',
                banner: ''
            },
            pageName: this.trans('admin.form.news.add_news'),
        }
    },
    created() {
        if (this.$route.name === 'news_edit') {
            this.loading = true;
            this.pageName = this.trans('admin.form.news.edit_news');

            axios.get('/api/admin/news/'+ this.$route.params.id , {params: {content_en: true, content_ko: true}})
                .then((response) => {
                    this.form = response.data.data;
                    this.form.banner = '';
                    this.form.deleteImages = [];
                }).finally(() => this.loading = false);
        }
    },
    methods: {
        submitForm() {
            this.loading = true;
            this.errors = null;

            let formData = new FormData();
            Object.keys(this.form).forEach(key => {
                formData.append(key, this.form[key]);
            });

            if (this.$route.name === 'news_edit') {
                formData.append('_method', 'PUT');

                axios.post('/api/admin/news/'+ this.$route.params.id, formData)
                    .then((response) => {
                        this.$router.push({name: 'news'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            } else {
                axios.post('/api/admin/news', formData)
                    .then((response) => {
                        this.$router.push({name: 'news'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);
            }

            axios.post('/api/admin/delete/image', {images: this.deleteImages});
        },
    },
}
</script>
