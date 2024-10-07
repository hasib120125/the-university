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
                                <label>{{ trans('admin.form.grade_system.from') }}</label>
                                <input type="number" class="form_global" :placeholder="trans('admin.form.grade_system.from')" v-model="form.from" step="0.01" min="0">
                                <v-errors :errors="errorFor('from')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.grade_system.to') }}</label>
                                <input type="number" class="form_global" :placeholder="trans('admin.form.grade_system.to')" v-model="form.to" step="0.01" min="0">
                                <v-errors :errors="errorFor('to')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.grade_system.grade') }}</label>
                                <input type="text" class="form_global" :placeholder="trans('admin.form.grade_system.grade')" v-model="form.grade">
                                <v-errors :errors="errorFor('grade')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.grade_system.point') }}</label>
                                <input type="number" class="form_global" :placeholder="trans('admin.form.grade_system.point')" v-model="form.point" step="0.01" min="0">
                                <v-errors :errors="errorFor('point')"></v-errors>
                            </div>
                        </div>

                    </div>

                    <div class="d_flex_end">
                        <router-link class="btn btn_secondary mr_5" :to="{name: 'grade_system'}">{{ trans('admin.label.cancel') }}</router-link>
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
            form: {
                from: '',
                to: '',
                grade: '',
                point: '',
            },
            pageName: this.trans('admin.form.grade_system.grade_system_add'),

        }
    },
    created() {
        if (this.$route.name === 'grade_system_edit') {
            this.loading = true;
            this.pageName = this.trans('admin.form.grade_system.grade_system_edit');
            axios.get('/api/admin/grade-systems/'+ this.$route.params.id)
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

            if (this.$route.name === 'grade_system_edit') {
                axios.patch('/api/admin/grade-systems/'+ this.$route.params.id, this.form)
                    .then((response) => {
                        this.$router.push({name: 'grade_system'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            }else{
                axios.post('/api/admin/grade-systems', this.form)
                    .then((response) => {
                        this.$router.push({name: 'grade_system'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            }
        },
    },
}
</script>


