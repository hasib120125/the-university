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
                                <label>{{ trans('admin.form.department.name') }}</label>
                                <input type="text" class="form_global" :placeholder="trans('admin.form.department.name')" v-model="form.name">
                                <v-errors :errors="errorFor('name')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.department.code') }}</label>
                                <input type="text" class="form_global" :placeholder="trans('admin.form.department.code')" v-model="form.code">
                                <v-errors :errors="errorFor('code')"></v-errors>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.department.degree') }}</label>
                                <select class="form_global" v-model="form.degree">
                                    <option value="">{{ trans('admin.form.department.select_degree') }}</option>
                                    <option value="Master">{{ trans('admin.form.department.master') }}</option>
                                    <option value="Bachelor">{{ trans('admin.form.department.bachelor') }}</option>
                                </select>
                                <v-errors :errors="errorFor('degree')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
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
                    </div>

                    <div class="d_flex_end">
                        <router-link class="btn btn_secondary mr_5" :to="{name: 'departments'}">{{ trans('admin.label.cancel') }}</router-link>
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
                name: null,
                code: null,
                degree: '',
                major: null,
                status: 1,
            },
            pageName: this.trans('admin.form.department.add_new_department'),
        }
    },
    created() {
        if (this.$route.name === 'department_edit') {
            this.loading = true;
            this.pageName = this.trans('admin.form.department.edit_department');
            axios.get('/api/admin/departments/'+ this.$route.params.id)
                .then((response) => {
                    this.form.name = response.data.data.name;
                    this.form.code = response.data.data.code;
                    this.form.degree = response.data.data.degree;
                    this.form.major = response.data.data.major;
                    this.form.status = response.data.data.status;
                }).finally(() => this.loading = false);

        }
    },
    methods: {
        submitForm(){
            this.loading = true;
            this.errors = null;
            this.loading = true;

            if (this.$route.name === 'department_edit') {
                axios.patch('/api/admin/departments/'+ this.$route.params.id, this.form)
                    .then((response) => {
                        this.$router.push({name: 'departments'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);
            }else{
                axios.post('/api/admin/departments', this.form)
                    .then((response) => {
                        this.$router.push({name: 'departments'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);
            }
        }
    },
}
</script>


