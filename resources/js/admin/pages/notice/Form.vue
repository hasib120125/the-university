<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ pageName }}</div>
                </div>
                <div :class="['card-body', {'loading_overlay': loading}]">
                    <div class="row">
                        <div class="col_4">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.notices.subject') }}</label>
                                <input type="text" class="form_global"   v-model="form.subject">
                                <v-errors :errors="errorFor('subject')"></v-errors>
                            </div>
                        </div>
                        <div class="col_4">
                            <div class="form-group mb_0">
                                <label class="pb_0">{{ trans('common.index.status') }}</label> 
                            </div>
                            <div class="form_radio">
                                <input type="radio" id="status_1" name="radio" v-model="form.status" value="1">
                                <label for="status_1">{{ trans('common.index.active') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" id="status_0" name="radio" v-model="form.status" value="0">
                                <label for="status_0">{{ trans('common.index.in_active') }}</label>
                            </div>
                            <v-errors :errors="errorFor('status')"></v-errors>
                        </div>
                        <div class="col_4">
                            <div class="form-group mb_0">
                                <label class="pb_0">{{ trans('admin.form.notices.notice_to') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" id="all"  v-model="form.category" value="All">
                                <label for="all">{{ trans('admin.form.notices.all') }}</label>
                            </div>
                            <div class="form_radio ml_20">
                                <input type="radio" id="Professor"  v-model="form.category" value="Professor">
                                <label for="Professor">{{ trans('admin.form.notices.professor') }}</label>
                            </div>
                            <div class="form_radio ml_20">
                                <input type="radio" id="Student"  v-model="form.category" value="Student">
                                <label for="Student">{{ trans('admin.form.notices.student') }}</label>
                            </div>

                            <v-errors :errors="errorFor('category')"></v-errors>
                        </div>

                        <div class="col_12">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.notices.description') }}</label>
                                <froala-text-editor :model.sync="form.description" :deleteImages.sync="deleteImages"/>
                                <v-errors :errors="errorFor('description')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.notices.attachment_1') }}</label>
                                <div class="file_input">
                                    <input type="file" id="file" ref="file" class="form_global" placeholder="Photo" @change="attachmentUpload($event, 'attachment1')">
                                    <v-errors :errors="errorFor('attachment1')"></v-errors>
                                </div>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.notices.attachment_2') }}</label>
                                <div class="file_input">
                                    <input type="file" class="form_global" placeholder="Photo" @change="attachmentUpload($event, 'attachment2')">
                                    <v-errors :errors="errorFor('attachment2')"></v-errors>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="d_flex_end">
                        <router-link class="btn btn_secondary mr_5" :to="{name: 'notices'}">{{ trans('admin.label.cancel') }}</router-link>
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
    name: 'notice-form',
    mixins: [validationErrors],
    components: {
        FroalaTextEditor
    },
    data(){
        return {
            deleteImages: [],
            form: {
                subject: '',
                category: '',
                description: '',
                attachment1: '',
                attachment2: '',
                status: 1,
            },
            pageName: this.trans('admin.form.notices.add_new_notice'),

        }
    },
    created() {
        if (this.$route.name === 'notices_edit') {
            this.loading = true;
            this.pageName = this.trans('admin.form.notices.edit_notices');
            axios.get('/api/admin/notices/'+ this.$route.params.id)
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

            let formData = new FormData()

            Object.keys(this.form).forEach(key => {
                formData.append(key, this.form[key] ? this.form[key] : '');
            })

            if (this.$route.name === 'notices_edit') {
                formData.append('_method', 'PUT');

                axios.post('/api/admin/notices/'+ this.$route.params.id, formData)
                    .then((response) => {
                        this.$router.push({name: 'notices'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            }else{
                axios.post('/api/admin/notices', formData)
                    .then((response) => {
                        this.$router.push({name: 'notices'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            }

            axios.post('/api/admin/delete/image', {images: this.deleteImages});
        },
        attachmentUpload(e, callFrom) {
            this.$set(this.form, callFrom, e.target.files[0])
        },

    },
}
</script>


