<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ pageName }}</div>
                </div>
                <div :class="['card-body', {'loading_overlay': loading}]">
                    <div class="row">
                        <div class="col_8">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.exam.test_title') }}</label>
                                <input type="text" class="form_global" v-model="form.test_title">
                                <v-errors :errors="errorFor('test_title')"></v-errors>
                            </div>
                        </div>
                        <div class="col_4">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.exam.number_of_questions') }}</label>
                                <input type="number" class="form_global" v-model="form.number_of_question">
                                <v-errors :errors="errorFor('number_of_question')"></v-errors>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col_4">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.exam.start_date') }}</label>
                                <datepicker :typeable="true"  input-class="form_global form_date_picker" :value="form.start_period" @input="form.start_period = dateFormat($event, 'YYYY-MM-DD') "></datepicker>
                                <v-errors :errors="errorFor('start_period')"></v-errors>
                            </div>
                        </div>
                        <div class="col_4">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.exam.end_date') }}</label>
                                <datepicker :typeable="true"  input-class="form_global form_date_picker" :value="form.end_period" @input="form.end_period = dateFormat($event, 'YYYY-MM-DD') "></datepicker>
                                <v-errors :errors="errorFor('end_period')"></v-errors>
                            </div>
                        </div>
                        <div class="col_4">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.exam.time_limit') }} <span class="color_danger">({{ trans('admin.form.exam.minute') }})</span></label>
                                <input type="number" class="form_global" v-model="form.time_limit">
                                <v-errors :errors="errorFor('time_limit')"></v-errors>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col_4">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.exam.distribution_per_question') }}<span class="color_danger">({{ trans('admin.form.exam.point') }})</span></label>
                                <input type="number" class="form_global" v-model="form.marks_per_question">
                                <v-errors :errors="errorFor('marks_per_question')"></v-errors>
                            </div>
                        </div>
                        <div class="col_4">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.exam.classification_of_the_test') }}</label>
                                <select class="form_global" id="exam_type" v-model="form.exam_type">
                                    <option value="1">{{ trans('admin.form.exam.midterm_exam') }}</option>
                                    <option value="2">{{ trans('admin.form.exam.finals') }}</option>
                                    <option value="3">{{ trans('admin.form.exam.bible_test') }}</option>
                                </select>
                                <v-errors :errors="errorFor('exam_type')"></v-errors>
                            </div>
                        </div>
                        <div class="col_4">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.exam.submitter') }}</label>
                                <select class="form_global" id="submitter_id" v-model="form.submitter_id">
                                    <option :value="professor.id" v-for="(professor, index) in professors" :key="index">{{ professor.name }}</option>
                                </select>
                                <v-errors :errors="errorFor('submitter_id')"></v-errors>
                            </div>
                        </div>
                    </div>
                    <div class="d_flex_end">
                        <router-link class="btn btn_secondary mr_5" :to="{name: 'lecture_exams'}">{{ trans('admin.label.cancel') }}</router-link>
                        <button class="btn btn_md btn_success" @click.prevent="submitForm">{{ trans('admin.label.save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import validationErrors from "../../../../mixins/validationErrors";
import Datepicker from 'vuejs-datepicker';

export default {
    name:'exam-form',
    mixins: [validationErrors],
    components: {Datepicker},
    data(){
        return {
            form: {
                test_title: null,
                start_period: null,
                end_period: null,
                time_limit: null,
                number_of_question: null,
                marks_per_question: null,
                exam_type: 1,
                submitter_id: null,
            },
            pageName: this.trans('admin.form.exam.add_new_exam'),
            professors:[],
        }
    },
    created() {
        axios.get('/api/admin/professors/')
            .then((response) => {
                this.professors = response.data.data
            })

        axios.get('/api/admin/lectures/' + this.$route.params.id)
                .then((response) => {
                    let lecture = response.data.data
                    this.form.submitter_id = lecture.professor ? lecture.professor.id : null
                })

        if (this.$route.name === 'lecture_exam_update') {
            this.pageName = this.trans('admin.form.exam.edit_exam');
            this.loading = true;

            axios.get('/api/admin/lectures/' + this.$route.params.id + '/exams/'+ this.$route.params.exam_id)
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

            if (this.$route.name === 'lecture_exam_update') {
                axios.patch('/api/admin/lectures/' + this.$route.params.id + '/exams/'+ this.$route.params.exam_id, this.form)
                    .then((response) => {
                        this.$router.push({name: 'lecture_exams'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            }else{
                axios.post('/api/admin/lectures/' + this.$route.params.id + '/exams', this.form)
                    .then((response) => {
                        this.$router.push({name: 'lecture_exams'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            }
        },
    },
}
</script>


