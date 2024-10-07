<template>
    <div class="row">
        <div class="col_12">
            <div :class="['card', {'loading_overlay': loading}]">
                <div class="card-header" v-if="page">
                    <div class="card-title">{{ page.title }}</div>
                </div>
                <div class="card-body" v-if="page">
                    <div class="row">
                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.pages.page_title_en') }}</label>
                                <input type="text" id="title"   class="form_global" :placeholder="trans('admin.form.pages.page_title_en')" v-model="page.title_en">
                                <v-errors :errors="errorFor('title_en')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.pages.page_title_ko') }}</label>
                                <input type="text" id="title_ko"   class="form_global" :placeholder="trans('admin.form.pages.page_title_ko')" v-model="page.title_ko">
                                <v-errors :errors="errorFor('title_ko')"></v-errors>
                            </div>
                        </div>

                        <div class="col_12">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.pages.page_content_en') }}</label>
                                <froala-text-editor :model.sync="page.content_en" :deleteImages.sync="deleteImages"/>
                                <v-errors :errors="errorFor('content_en')"></v-errors>
                            </div>
                        </div>

                        <div class="col_12">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.pages.page_content_ko') }}</label>
                                <froala-text-editor :model.sync="page.content_ko" :deleteImages.sync="deleteImages"/>
                                <v-errors :errors="errorFor('content_ko')"></v-errors>
                            </div>
                        </div>
                    </div>

                    <div class="d_flex_end">
                        <router-link class="btn btn_secondary mr_5" :to="{name: 'static_pages'}">{{ trans('admin.label.cancel') }}</router-link>
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
            page: {
                content_en:'',
                content_ko:'',
            },
            deleteImages: []
        }
    },
    created() {
        axios.get('/api/admin/static-pages/'+ this.$route.params.id)
            .then((response) => {
                this.page = response.data.data;
            }).finally(() => this.loading = false);
    },
    methods: {
        submitForm() {
            this.loading = true;
            this.errors = null;

            axios.patch('/api/admin/static-pages/' + this.$route.params.id, this.page)
                .then((response) => {
                    this.$router.push({name: 'static_pages'});
                })
                .catch((err) => this.errors = err.response.data.errors)
                .finally(() => this.loading = false);
                
            axios.post('/api/admin/delete/image', {images: this.deleteImages});
        },
        
    },
}
</script>


