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
                                <label>{{ trans('admin.form.faculty.name') }}</label>
                                <input type="text" class="form_global" :placeholder="trans('admin.form.faculty.name')" v-model="form.name">
                                <v-errors :errors="errorFor('name')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.faculty.code') }}</label>
                                <input type="text" class="form_global" :placeholder="trans('admin.form.faculty.code')" v-model="form.code">
                                <v-errors :errors="errorFor('code')"></v-errors>
                            </div>
                        </div>
                    </div>

                    <div class="d_flex_end">
                        <router-link class="btn btn_secondary mr_5" :to="{name: 'faculties'}">{{ trans('admin.label.cancel') }}</router-link>
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
                },
                pageName: this.trans('admin.form.faculty.add_new_faculty'),
            }
        },
        created() {
            if (this.$route.name === 'faculty_edit') {
                this.pageName = this.trans('admin.form.faculty.edit_faculty');

                this.loading = true;

                axios.get('/api/admin/faculties/'+ this.$route.params.id)
                    .then((response) => {
                        this.form.name = response.data.data.name;
                        this.form.code = response.data.data.code;
                    }).finally(() => this.loading = false);
            }
        },
        methods: {
            submitForm(){
                this.errors = null;
                this.loading = true;

                if (this.$route.name === 'faculty_edit') {
                    axios.patch('/api/admin/faculties/'+ this.$route.params.id, this.form)
                        .then((response) => {
                            this.$router.push({name: 'faculties'});
                        })
                        .catch((err) => this.errors = err.response.data.errors)
                        .finally(() => this.loading = false);
                } else {
                    axios.post('/api/admin/faculties', this.form)
                        .then((response) => {
                            this.$router.push({name: 'faculties'});
                        })
                        .catch((err) => this.errors = err.response.data.errors)
                        .finally(() => this.loading = false);
                }
            }
        },
    }
</script>


