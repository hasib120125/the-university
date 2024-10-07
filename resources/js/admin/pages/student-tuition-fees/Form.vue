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
                                <label>{{ trans('admin.form.student_tuition_fees.student') }}</label>
                                <select class="form_global" id="curriculum" v-model="form.student_id">
                                    <option value="">{{ trans('admin.form.student_tuition_fees.select_student') }}</option>
                                    <option v-for="(student, i) in students" :key="'student_'+i" :value="student.id">
                                        {{ student.name }}</option>
                                </select>
                                <v-errors :errors="errorFor('student_id')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.student_tuition_fees.tuition_fees') }}</label>
                                <input type="text" class="form_global"   v-model="form.tuition_fee">
                                <v-errors :errors="errorFor('tuition_fee')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.student_tuition_fees.enterance_fees') }}</label>
                                <input type="text" class="form_global"   v-model="form.enterance_fee">
                                <v-errors :errors="errorFor('enterance_fee')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.student_tuition_fees.seminar_fees') }}</label>
                                <input type="text" class="form_global"   v-model="form.seminar_fee">
                                <v-errors :errors="errorFor('seminar_fee')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.student_tuition_fees.student_union_fees') }}</label>
                                <input type="text" class="form_global"   v-model="form.student_union_fee">
                                <v-errors :errors="errorFor('student_union_fee')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.student_tuition_fees.orientation_fees') }}</label>
                                <input type="text" class="form_global"   v-model="form.orientation_fee">
                                <v-errors :errors="errorFor('orientation_fee')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.student_tuition_fees.deduction') }}</label>
                                <input type="text" class="form_global"   v-model="form.deduction">
                                <v-errors :errors="errorFor('deduction')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.student_tuition_fees.scholarship') }}</label>
                                <input type="text" class="form_global"   v-model="form.scholarship">
                                <v-errors :errors="errorFor('scholarship')"></v-errors>
                            </div>
                        </div>

                    </div>

                    <div class="d_flex_end">
                        <router-link class="btn btn_secondary mr_5" :to="{name: 'tuition_fees'}">{{ trans('admin.label.cancel') }}</router-link>
                        <button class="btn btn_md btn_success" @click.prevent="submitForm">{{ trans('admin.label.save') }}</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import validationErrors from "../../mixins/validationErrors";
import Datepicker from 'vuejs-datepicker';

export default {
    mixins: [validationErrors],
    components: {Datepicker},
    data(){
        return {
            form: {
                student_id: '',
                tuition_fee: null,
                enterance_fee: null,
                seminar_fee: null,
                student_union_fee: null,
                orientation_fee: null,
                deduction: null,
                scholarship: null,
            },
            pageName: this.trans('admin.form.student_tuition_fees.add_tuition_fees'),
            students: [],
        }
    },
    created() {
        axios.get('/api/admin/students')
            .then((response) => {
                this.students = response.data.data;
            })
        if (this.$route.name === 'tuition_fees_edit') {
            this.loading = true;
            this.pageName = this.trans('admin.form.student_tuition_fees.edit_tuition_fees');
            axios.get('/api/admin/student-tuition-fees/'+ this.$route.params.id)
                .then((response) => {
                    this.form = response.data.data;
                    this.form.student_id = response.data.data.student.id;
                }).finally(() => this.loading = false);
        }
    },
    methods: {
        submitForm(){
            this.loading = true;
            this.errors = null;
            if (this.$route.name === 'tuition_fees_edit') {

                axios.patch('/api/admin/student-tuition-fees/'+ this.$route.params.id, this.form)
                    .then((response) => {
                        this.$router.push({name: 'tuition_fees'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            }else{
                axios.post('/api/admin/student-tuition-fees', this.form)
                    .then((response) => {
                        this.$router.push({name: 'tuition_fees'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            }
        }
    },
}
</script>

<style>
.form_date_picker {
    background-color: white !important;
    cursor: pointer !important;
    opacity: 1 !important;
}
</style>


