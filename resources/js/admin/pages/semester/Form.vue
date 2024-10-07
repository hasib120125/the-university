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
                                <label>{{ trans('admin.form.semester.year') }}</label>
                                <select class="form_global" id="year" v-model="form.year">
                                    <option value="">{{ trans('admin.form.semester.select_year') }}</option>
                                    <option :value="year" v-for="(year, yearIndex) in years" :key="'year' + yearIndex">{{year}}</option>
                                </select>
                                <v-errors :errors="errorFor('year')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.semester.season') }}</label>
                                <select class="form_global" id="season" v-model="form.season">
                                    <option value="">{{ trans('admin.form.semester.select_season') }}</option>
                                    <option value="1">{{ trans('admin.form.semester.season_1') }}</option>
                                    <option value="2">{{ trans('admin.form.semester.season_2') }}</option>
                                    <option value="3">{{ trans('admin.form.semester.season_3') }}</option>
                                    <option value="4">{{ trans('admin.form.semester.season_4') }}</option>
                                </select>
                                <v-errors :errors="errorFor('season')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.lecture.start_period') }}</label>
                                <datepicker :typeable="true"  input-class="form_global form_date_picker" :value="form.start_period" @input="form.start_period = dateFormat($event, 'YYYY-MM-DD') "></datepicker>
                                <v-errors :errors="errorFor('start_period')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.lecture.end_period') }}</label>
                                <datepicker :typeable="true"  input-class="form_global form_date_picker" :value="form.end_period" @input="form.end_period = dateFormat($event, 'YYYY-MM-DD') "></datepicker>
                                <v-errors :errors="errorFor('end_period')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.semester.last_subject_cancel_date') }}</label>
                                <datepicker :typeable="true"  input-class="form_global form_date_picker" :value="form.last_subject_cancel_date" @input="form.last_subject_cancel_date = dateFormat($event, 'YYYY-MM-DD') "></datepicker>
                                <v-errors :errors="errorFor('last_subject_cancel_date')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.semester.grade_period') }}</label>
                                <datepicker :typeable="true"  input-class="form_global form_date_picker" :value="form.grade_period" @input="form.grade_period = dateFormat($event, 'YYYY-MM-DD') "></datepicker>
                                <v-errors :errors="errorFor('grade_period')"></v-errors>
                            </div>
                        </div>
                    </div>
                    <div class="d_flex_end">
                        <router-link class="btn btn_secondary mr_5" :to="{name: 'semesters'}">{{ trans('admin.label.cancel') }}</router-link>
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
                year: new Date().getFullYear(),
                season: '',
                code: null,
                start_period: '',
                end_period: '',
                last_subject_cancel_date: '',
                grade_period: '',
            },
            years: [],
            pageName: this.trans('admin.form.semester.add_new_semester'),
        }
    },
    created() {
        let currentYear = new Date().getFullYear() + 10
        let startYear = 1980

        while ( startYear <= currentYear ) {
            this.years.push(startYear++);
        }   

        
        if (this.$route.name === 'semester_edit') {
            this.loading = true;
            this.pageName = this.trans('admin.form.semester.edit_semester');
            axios.get('/api/admin/semesters/'+ this.$route.params.id)
                .then((response) => {
                    this.form = response.data.data;
                }).finally(() => this.loading = false);
        }
    },
    methods: {
        dateFormat(e, format){
            if(e){
                return this.moment(e).format(format)
            }
            return null
        },
        submitForm(){
            this.loading = true;
            this.errors = null;
            if (this.$route.name === 'semester_edit') {
                axios.patch('/api/admin/semesters/'+ this.$route.params.id, this.form)
                    .then((response) => {
                        this.$router.push({name: 'semesters'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);
            }else{
                axios.post('/api/admin/semesters', this.form)
                    .then((response) => {
                        this.$router.push({name: 'semesters'});
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


