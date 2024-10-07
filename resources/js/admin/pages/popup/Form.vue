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
                                <label>{{ trans('admin.form.popup.title') }}</label>
                                <input type="text" class="form_global" :placeholder="trans('admin.form.popup.title')" v-model="form.title">
                                <v-errors :errors="errorFor('title')"></v-errors>
                            </div>
                        </div>
                        <div class="col_3">
                            <div class="form-group">
                                <label>{{ trans('admin.form.popup.top') }}</label>
                                <input type="text" class="form_global" :placeholder="trans('admin.form.popup.top')" v-model="form.top">
                                <v-errors :errors="errorFor('top')"></v-errors>
                            </div>
                        </div>
                        <div class="col_3">
                            <div class="form-group">
                                <label>{{ trans('admin.form.popup.left') }}</label>
                                <input type="text" class="form_global" :placeholder="trans('admin.form.popup.left')" v-model="form.left">
                                <v-errors :errors="errorFor('left')"></v-errors>
                            </div>
                        </div>


                        <div class="col_12">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.popup.content') }}</label>
                                <froala-text-editor :model.sync="form.content" :deleteImages.sync="deleteImages"/>
                                <v-errors :errors="errorFor('content')"></v-errors>
                            </div>
                        </div>
                    </div>

                    <div class="d_flex_end">
                        <router-link class="btn btn_secondary mr_5" :to="{name: 'popup'}">{{ trans('admin.label.cancel') }}</router-link>
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
                title: '',
                top: '',
                left: '',
                content: '',
            },
            pageName: this.trans('admin.form.popup.popup_add'),

        }
    },
    created() {
        if (this.$route.name === 'popup_edit') {
            this.loading = true;
            this.pageName = this.trans('admin.form.popup.popup_edit');
            axios.get('/api/admin/popup/'+ this.$route.params.id)
                .then((response) => {
                    this.form = response.data.data;
                })
                .finally(() => this.loading = false);
        }
    },
    methods: {
        submitForm(){
            this.loading = true;
            this.errors = null;
            if (this.$route.name === 'popup_edit') {
                axios.patch('/api/admin/popup/'+ this.$route.params.id, this.form)
                    .then((response) => {
                        this.$router.push({name: 'popup'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            }else{
                axios.post('/api/admin/popup', this.form)
                    .then((response) => {
                        if(response.data.success == false){
                            this.$swal({
                                text: response.data.message,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: this.trans('admin.label.yes_delete'),
                                cancelButtonText: this.trans('admin.label.no_cancel'),
                                reverseButtons: true
                            }).then((result) => {
                                this.form.confirm_updte = 1;
                                this.submitForm();
                            });

                        }else{
                            this.$router.push({name: 'popup'});
                        }
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);
            }

            axios.post('/api/admin/delete/image', {images: this.deleteImages});
        },
    },
}
</script>


