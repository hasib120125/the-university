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
                                <label>{{ trans('admin.form.curriculum_fees.semester') }}</label>
                                <select class="form_global" id="semester" v-model="form.semester_id">
                                    <option value="">{{ trans('admin.form.curriculum_fees.select_semester') }}</option>
                                    <option v-for="(semester, i) in semesters" :key="'semester_'+i" :value="semester.id">
                                        {{ semester.year }}- {{ semester.season }}</option>
                                </select>
                                <v-errors :errors="errorFor('semester_id')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.curriculum_fees.curriculum') }}</label>
                                <select class="form_global" id="curriculum" v-model="form.curriculum_id">
                                    <option value="">{{ trans('admin.form.curriculum_fees.select_curriculum') }}</option>
                                    <option v-for="(curriculum, i) in curriculums" :key="'curriculum_'+i" :value="curriculum.id">
                                        {{ curriculum.name }}</option>
                                </select>
                                <v-errors :errors="errorFor('curriculum_id')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.curriculum_fees.grade') }}</label>
                                <input type="text" class="form_global"   v-model="form.grade">
                                <v-errors :errors="errorFor('grade')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.curriculum_fees.subject_fees') }}</label>
                                <input type="text" class="form_global"   v-model="form.subject_fee">
                                <v-errors :errors="errorFor('subject_fee')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.curriculum_fees.orientation_fees') }}</label>
                                <input type="text" class="form_global"   v-model="form.orientation_fee">
                                <v-errors :errors="errorFor('orientation_fee')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.curriculum_fees.others_fees') }}</label>
                                <input type="text" class="form_global"   v-model="form.others_fee">
                                <v-errors :errors="errorFor('others_fee')"></v-errors>
                            </div>
                        </div>

                    </div>

                    <div class="d_flex_end">
                        <router-link class="btn btn_secondary mr_5" :to="{name: 'curriculum_fees'}">{{ trans('admin.label.cancel') }}</router-link>
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
                semester_id: '',
                curriculum_id: '',
                grade: null,
                subject_fee: null,
                orientation_fee: null,
                others_fee: null,
            },
            pageName: this.trans('admin.form.curriculum_fees.add_curriculum_fees'),
            students: [],
            semesters: [],
            curriculums: [],
        }
    },
    created() {
        axios.get('/api/admin/semesters')
            .then((response) => {
                this.semesters = response.data.data;
            })

        axios.get('/api/admin/curriculums')
            .then((response) => {
                this.curriculums = response.data.data;
            })


        if (this.$route.name === 'curriculum_fees_edit') {
            this.loading = true;
            this.pageName = this.trans('admin.form.curriculum_fees.edit_curriculum_fees');
            axios.get('/api/admin/curriculum-fees/'+ this.$route.params.id)
                .then((response) => {
                    this.form = response.data.data;
                    this.form.semester_id = response.data.data.semester.id;
                    this.form.curriculum_id = response.data.data.curriculum.id;
                }).finally(() => this.loading = false);
        }
    },
    methods: {
        submitForm(){
            this.loading = true;
            this.errors = null;
            if (this.$route.name === 'curriculum_fees_edit') {

                axios.patch('/api/admin/curriculum-fees/'+ this.$route.params.id, this.form)
                    .then((response) => {
                        this.$router.push({name: 'curriculum_fees'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            }else{
                axios.post('/api/admin/curriculum-fees', this.form)
                    .then((response) => {
                        this.$router.push({name: 'curriculum_fees'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            }
        }
    },
}
</script>

<style>
    .vdp-datepicker__calendar .cell.selected {
        color: #fff;
    }
</style>


