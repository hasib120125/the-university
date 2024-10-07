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
                                <label>{{ trans('admin.form.notices.title') }}</label>
                                <input type="text" class="form_global" v-model="form.title">
                                <v-errors :errors="errorFor('title')"></v-errors>
                            </div>
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
                                    <input type="file" id="file" ref="file" class="form_global" placeholder="" @change="attachment1Upload($event)">
                                    <v-errors :errors="errorFor('attachment1')"></v-errors>
                                </div>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.notices.attachment_2') }}</label>
                                <div class="file_input">
                                    <input type="file" class="form_global" placeholder="" @change="attachment2Upload($event)">
                                    <v-errors :errors="errorFor('attachment1')"></v-errors>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d_flex_end">
                        <router-link class="btn btn_secondary mr_5" :to="{name: 'subject_notices'}">{{ trans('admin.label.cancel') }}</router-link>
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
            semesters: [],
            form: {
                title: null,
                semester_id: this.$route.params.semester_id,
                category: null,
                description: null,
                attachment1: '',
                attachment2: '',
            },

            pageName: this.trans('admin.form.notices.add_new_notice'),

        }
    },
    created() {
        axios.get('/api/admin/semesters').then((response) => {
            this.semesters = response.data.data;
            if (response.data.data.length) {
                this.semesterId = response.data.data[response.data.data.length - 1].id;
            }
        })

        if (this.$route.name === 'subject_notice_update') {
            this.loading = true;
            this.pageName = this.trans('admin.form.notices.edit_notices');
            axios.get('/api/admin/subjects/' + this.$route.params.id + '/notices/'+ this.$route.params.notice_id)
                .then((response) => {
                    this.form = response.data.data;
                    this.form.attachment1 = '';
                    this.form.attachment2 = '';
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

            if (this.$route.name === 'subject_notice_update') {
                formData.append('_method','patch')
                axios.post('/api/admin/subjects/' + this.$route.params.id + '/notices/'+ this.$route.params.notice_id, formData)
                    .then((response) => {
                        this.$router.push({name: 'subject_notices', params: {semester_id: this.$route.params.semester_id}});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            }else{
                axios.post('/api/admin/subjects/' + this.$route.params.id + '/notices', formData)
                    .then((response) => {
                        this.$router.push({name: 'subject_notices', params: {semester_id: this.$route.params.semester_id}});
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


