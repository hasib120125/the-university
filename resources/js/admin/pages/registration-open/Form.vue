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
                                <label>{{ trans('admin.form.registration_open.semester') }}</label>
                                <select class="form_global" id="semester_id" v-model="form.semester_id">
                                    <option value="">{{ trans('admin.form.registration_open.select_semester') }}</option>
                                    <option v-for="(semester, i) in semesters" :key="'semester_'+i" :value="semester.id">
                                        {{ semester.year }} - {{ semester.season_name }}
                                    </option>
                                </select>
                                <v-errors :errors="errorFor('semester_id')"></v-errors>
                            </div>
                        </div>

                        <div class="col_4">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.registration_open.start_date') }}</label>
                                <datepicker :typeable="true"  input-class="form_global form_date_picker" :value="form.start_date" @input="form.start_date = dateFormat($event, 'YYYY-MM-DD') "></datepicker>
                                <v-errors :errors="errorFor('start_date')"></v-errors>
                            </div>
                        </div>
                        <div class="col_4">
                            <div class="form-group">
                                <label>{{ trans('admin.form.registration_open.end_date') }}</label>
                                <datepicker :typeable="true"  input-class="form_global form_date_picker" :value="form.end_date" @input="form.end_date = dateFormat($event, 'YYYY-MM-DD') "></datepicker>
                                <v-errors :errors="errorFor('end_date')"></v-errors>
                            </div>
                        </div>
                    </div>

                    <div class="d_flex_end">
                        <router-link class="btn btn_secondary mr_5" :to="{name: 'registration_open'}">{{ trans('admin.label.cancel') }}</router-link>
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
    name : 'registration-open-form', 
    mixins: [validationErrors],
    components: {Datepicker},
    data(){
        return {
            form: {
                semester_id: '',
                start_date: '',
                end_date: ''
            },
            pageName: this.trans('admin.form.registration_open.add_new_registration_season'),
            semesters : []
        }
    },
    created() {
            axios.get('/api/admin/semesters')
            .then((response) => {
                this.semesters = response.data.data;
            })

            this.loading = true;
            this.pageName = this.trans('admin.form.registration_open.edit_registration_season');
            axios.get('/api/admin/registration-open/'+ this.$route.params.id)
                .then((response) => {
                    this.form = response.data.data;
                    this.form.semester_id = response.data.data.semester.id;
                }).finally(() => this.loading = false);
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
            axios.patch('/api/admin/registration-open/'+ this.$route.params.id, this.form)
                .then((response) => {
                    this.$router.push({name: 'registration_open'});
                })
                .catch((err) => this.errors = err.response.data.errors)
                .finally(() => this.loading = false);
           
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


