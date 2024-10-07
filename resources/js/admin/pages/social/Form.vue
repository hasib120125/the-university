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
                                <label>{{ trans('admin.form.socials.name') }}</label>
                                <input type="text" class="form_global" :placeholder="trans('admin.form.socials.name')" v-model="form.name">
                                <v-errors :errors="errorFor('name')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.socials.url') }}</label>
                                <input type="text" class="form_global" :placeholder="trans('admin.form.socials.url')" v-model="form.url">
                                <v-errors :errors="errorFor('url')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.socials.font_class_ex') }}:(fab fa-instagram)</label>
                                <input type="text" class="form_global" :placeholder="trans('admin.form.socials.class')" v-model="form.class">
                                <v-errors :errors="errorFor('class')"></v-errors>
                            </div>
                        </div>


                        <div class="col_4">
                            <div class="form-group mb_5 mt_15 "><label class="pb_0"> {{ trans('admin.form.socials.status') }} </label> </div>
                            <div class="form_radio">
                                <input type="radio" id="active"  v-model="form.status" value="1">
                                <label for="active">{{ trans('admin.form.socials.active') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" id="inactive"  v-model="form.status" value="0">
                                <label for="inactive">{{ trans('admin.form.socials.inactive') }}</label>
                            </div>
                            <v-errors :errors="errorFor('status')"></v-errors>
                        </div>
                    </div>

                    <div class="d_flex_end">
                        <router-link class="btn btn_secondary mr_5" :to="{name: 'socials'}">{{ trans('admin.label.cancel') }}</router-link>
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
                url: '',
                class: null,
                status: null,
            },
            pageName: this.trans('admin.form.socials.add_new_socials'),

        }
    },
    created() {
        if (this.$route.name === 'socials_edit') {
            this.loading = true;
            this.pageName = this.trans('admin.form.socials.edit_social');
            axios.get('/api/admin/socials/'+ this.$route.params.id)
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
            if (this.$route.name === 'socials_edit') {
                axios.patch('/api/admin/socials/'+ this.$route.params.id, this.form)
                    .then((response) => {
                        this.$router.push({name: 'socials'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            }else{
                axios.post('/api/admin/socials', this.form)
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
                            this.$router.push({name: 'socials'});
                        }
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);
            }
        },
    },
}
</script>


