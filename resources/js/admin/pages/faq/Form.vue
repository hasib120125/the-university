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
                                <label>{{ trans('admin.form.faq.question') }}</label>
                                <input type="text" id="question"   class="form_global" :placeholder="trans('admin.form.faq.question')" v-model="form.question">
                                <v-errors :errors="errorFor('question')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group mb_0">
                                <label> {{ trans('admin.form.faq.status') }} </label> 
                            </div>
                            <div class="form_radio">
                                <input type="radio" id="active"  v-model="form.status" value="1">
                                <label for="active">{{ trans('admin.form.faq.active') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" id="inactive"  v-model="form.status" value="0">
                                <label for="inactive">{{ trans('admin.form.faq.inactive') }}</label>
                            </div>
                            <v-errors :errors="errorFor('status')"></v-errors>
                        </div>

                        <div class="col_12">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.faq.answer') }}</label>
                                <froala-text-editor :model.sync="form.answer" :deleteImages.sync="deleteImages"/>
                                <v-errors :errors="errorFor('answer')"></v-errors>
                            </div>
                        </div>

                    </div>

                    <div class="d_flex_end">
                        <router-link class="btn btn_secondary mr_5" :to="{name: 'faqs'}">{{ trans('admin.label.cancel') }}</router-link>
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
                question: '',
                answer: '',
                status: '',
            },
            
            pageName: this.trans('admin.form.faq.add_new_question'),

        }
    },
    created() {
        if (this.$route.name === 'faqs_edit') {
            this.loading = true;
            this.pageName = this.trans('admin.form.faq.edit_faq');
            axios.get('/api/admin/faqs/'+ this.$route.params.id)
                .then((response) => { this.form = response.data.data; })
                .finally(() => this.loading = false);
        }
    },
    methods: {
        submitForm(){
            this.loading = true;
            this.errors = null;
            this.loading = true;

            if (this.$route.name === 'faqs_edit') {
                axios.patch('/api/admin/faqs/'+ this.$route.params.id, this.form)
                    .then((response) => {
                        this.$router.push({name: 'faqs'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            }else{
                axios.post('/api/admin/faqs', this.form)
                    .then((response) => {
                        this.$router.push({name: 'faqs'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            }

            axios.post('/api/admin/delete/image', {images: this.deleteImages});
        },
        
    },
}
</script>


