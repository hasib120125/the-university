<template>
    <div class="row">
        <div class="col_12" :class="[{'loading_overlay': loading}]">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ pageName }}</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col_8">
                            <div class="form-group ">
                                <label>{{ trans('professor.form.exam.title') }}</label>
                                <input type="text" class="form_global" v-model="exam.title">
                                <v-errors :errors="errorFor('title')"></v-errors>
                            </div>
                        </div>
                        <div class="col_4">
                            <div class="form-group ">
                                <label>{{ trans('professor.form.exam.time_limit') }} <span class="color_danger">({{ trans('professor.form.exam.minute') }})</span></label>
                                <input type="number" class="form_global" v-model="exam.time_limit">
                                <v-errors :errors="errorFor('time_limit')"></v-errors>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col_4">
                            <div class="form-group ">
                                <label>{{ trans('professor.form.exam.start_date') }}</label>
                                <datepicker :typeable="true"  input-class="form_global form_date_picker" :value="exam.start_period" @input="exam.start_period = dateFormat($event, 'YYYY-MM-DD') "></datepicker>
                                <v-errors :errors="errorFor('start_period')"></v-errors>
                            </div>
                        </div>
                        <div class="col_4">
                            <div class="form-group ">
                                <label>{{ trans('professor.form.exam.end_date') }}</label>
                                <datepicker :typeable="true"  input-class="form_global form_date_picker" :value="exam.end_period" @input="exam.end_period = dateFormat($event, 'YYYY-MM-DD') "></datepicker>
                                <v-errors :errors="errorFor('end_period')"></v-errors>
                            </div>
                        </div>
                        <div class="col_4">
                            <div class="form-group ">
                                <label>{{ trans('professor.form.exam.classification_of_the_test') }}</label>
                                <select class="form_global" id="exam_type" v-model="exam.exam_type">
                                    <option value="1">{{ trans('professor.form.exam.midterm_exam') }}</option>
                                    <option value="2">{{ trans('professor.form.exam.finals') }}</option>
                                    <option value="3">{{ trans('professor.form.exam.bible_test') }}</option>
                                </select>
                                <v-errors :errors="errorFor('exam_type')"></v-errors>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card" v-for="(question, questionIndex) in exam.questions" :key="'question_' + questionIndex">
                <div class="card-header">
                    <div class="d_flex_end width_full">
                            <span @click="addQuestion" v-if=" questionIndex + 1 === exam.questions.length" class="cursor_pointer"><i class="lni lni-plus ml_10"></i></span>
                            <span @click="deleteQuestion(question, questionIndex)" v-if="exam.questions.length > 1" class="cursor_pointer"><i class="lni lni-minus ml_10"></i></span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col_6">
                            <div class="form-group mb_5">
                                <label>{{ trans('professor.form.exam.question.question_type') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" :id="'ox_type' + questionIndex" v-model="exam.questions[questionIndex].question_type" @change="changeType(questionIndex)" value="1">
                                <label :for="'ox_type' + questionIndex">{{ trans('professor.form.exam.question.ox_type') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" :id="'multiple_choice' + questionIndex" v-model="exam.questions[questionIndex].question_type" @change="changeType(questionIndex)" value="2">
                                <label :for="'multiple_choice' + questionIndex">{{ trans('professor.form.exam.question.mcq') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" :id="'short_answer' + questionIndex" v-model="exam.questions[questionIndex].question_type" @change="changeType(questionIndex)" value="3">
                                <label :for="'short_answer' + questionIndex">{{ trans('professor.form.exam.question.short') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" :id="'narrative' + questionIndex" v-model="exam.questions[questionIndex].question_type" @change="changeType(questionIndex)" value="4">
                                <label :for="'narrative' + questionIndex">{{ trans('professor.form.exam.question.narrative') }}</label>
                            </div>
                            <v-errors :errors="errorFor('questions.'+ questionIndex +'.question_type')"></v-errors>
                        </div>
                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('professor.form.exam.question.difficulty') }} <small class="ml_5 color_danger"> {{ trans('professor.form.exam.question.dif_message') }}</small></label>
                                <div class="d_flex_inline">
                                    <input type="number" min="1" max="5" class="form_global" v-model="exam.questions[questionIndex].difficulty">
                                </div>
                                <v-errors :errors="errorFor('questions.'+ questionIndex +'.difficulty')"></v-errors>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col_4">
                            <div class="form-group ">
                                <label>{{ trans('professor.form.exam.classification_of_the_test') }}</label>
                                <select class="form_global" id="exam_type" v-model="exam.questions[questionIndex].quater_code">
                                    <option value="1">{{ trans('professor.form.exam.midterm_exam') }}</option>
                                    <option value="2">{{ trans('professor.form.exam.finals') }}</option>
                                    <option value="3">{{ trans('professor.form.exam.bible_test') }}</option>
                                </select>
                                <v-errors :errors="errorFor('questions.'+ questionIndex +'.quater_code')"></v-errors>
                            </div>
                        </div>
                        <div class="col_4">
                            <div class="form-group ">
                                <label>{{ trans('professor.form.exam.question.title') }}</label>
                                <input type="text" class="form_global" v-model="exam.questions[questionIndex].title">
                                <v-errors :errors="errorFor('questions.'+ questionIndex +'.title')"></v-errors>
                            </div>
                        </div>
                        <div class="col_4">
                            <div class="form-group ">
                                <label>{{ trans('professor.form.exam.question.marks') }}</label>
                                <input type="number" min="0" class="form_global" v-model="exam.questions[questionIndex].marks">
                                <v-errors :errors="errorFor('questions.'+ questionIndex +'.marks')"></v-errors>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('professor.form.exam.question.related_image') }}</label>
                                <input type="file" id="file" class="form_global"  @change="attachmentUpload($event, questionIndex ,'problem_related_image')" accept="image/png, image/gif, image/jpeg">
                                <v-errors :errors="errorFor('questions.'+ questionIndex +'.problem_related_image')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('professor.form.exam.question.attachment') }}</label>
                                <input type="file" id="file" class="form_global" @change="attachmentUpload($event, questionIndex ,'attachment')" accept="image/png, image/gif, image/jpeg">
                                <v-errors :errors="errorFor('questions.'+ questionIndex +'.attachment')"></v-errors>
                            </div>
                        </div>
                    </div> -->
                    <div class="row" v-if="exam.questions[questionIndex].question_type == 1">
                        <div class="col_12">
                            <div class="form-group mb_5">
                                <label>{{ trans('professor.form.exam.question.question_answer') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" :id="'o' + questionIndex" v-model="exam.questions[questionIndex].answer" value="0">
                                <label :for="'o' + questionIndex">O</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" :id="'x' + questionIndex" v-model="exam.questions[questionIndex].answer" value="1">
                                <label :for="'x' + questionIndex">X</label>
                            </div>
                            <v-errors :errors="errorFor('questions.'+ questionIndex +'.answer')"></v-errors>
                        </div>
                    </div>
                    <div class="row" v-if="exam.questions[questionIndex].question_type == 2">
                        <div class="col_12">
                            <div class="form-group">
                                <label>{{ trans('professor.form.exam.question.question_answer') }}</label>
                                <div class="row">
                                    <div class="d_flex_inline col_6">
                                        <div class="form_radio">
                                            <input type="radio" :id="'mcq1' + questionIndex" v-model="exam.questions[questionIndex].answer" value="1">
                                            <label :for="'mcq1' + questionIndex"></label>
                                        </div>
                                        <input type="text" class="form_global" v-model="exam.questions[questionIndex].mcq1" :placeholder="trans('professor.form.exam.question.mcq_placeholder')">
                                        <v-errors :errors="errorFor('questions.'+ questionIndex +'.mcq1')"></v-errors>

                                    </div>
                                    <div class="d_flex_inline col_6">
                                        <div class="form_radio">
                                            <input type="radio" :id="'mcq2' + questionIndex"  v-model="exam.questions[questionIndex].answer" value="2">
                                            <label :for="'mcq2' + questionIndex"></label>
                                        </div>
                                        <input type="text" class="form_global" v-model="exam.questions[questionIndex].mcq2" :placeholder="trans('professor.form.exam.question.mcq_placeholder')">
                                        <v-errors :errors="errorFor('questions.'+ questionIndex +'.mcq2')"></v-errors>
                                    </div>
                                </div>
                                <div class="row mt_10">
                                    <div class="d_flex_inline col_6">
                                        <div class="form_radio">
                                            <input type="radio" :id="'mcq3' + questionIndex" v-model="exam.questions[questionIndex].answer" value="3">
                                            <label :for="'mcq3' + questionIndex"></label>
                                        </div>
                                        <input type="text" class="form_global" v-model="exam.questions[questionIndex].mcq3" :placeholder="trans('professor.form.exam.question.mcq_placeholder')">
                                        <v-errors :errors="errorFor('questions.'+ questionIndex +'.mcq3')"></v-errors>
                                    </div>
                                    <div class="d_flex_inline col_6">
                                        <div class="form_radio">
                                            <input type="radio" :id="'mcq4' + questionIndex"  v-model="exam.questions[questionIndex].answer" value="4">
                                            <label :for="'mcq4' + questionIndex"></label>
                                        </div>
                                        <input type="text" class="form_global" v-model="exam.questions[questionIndex].mcq4" :placeholder="trans('professor.form.exam.question.mcq_placeholder')">
                                        <v-errors :errors="errorFor('questions.'+ questionIndex +'.mcq4')"></v-errors>
                                    </div>
                                </div>
                                <div class="row mt_10">
                                    <div class="d_flex_inline col_6">
                                        <div class="form_radio">
                                            <input type="radio" :id="'mcq5' + questionIndex" v-model="exam.questions[questionIndex].answer" value="5">
                                            <label :for="'mcq5' + questionIndex"></label>
                                        </div>
                                        <input type="text" class="form_global" v-model="exam.questions[questionIndex].mcq5" :placeholder="trans('professor.form.exam.question.mcq_placeholder')">
                                        <v-errors :errors="errorFor('questions.'+ questionIndex +'.mcq5')"></v-errors>
                                    </div>
                                </div>
                                <v-errors :errors="errorFor('answer')"></v-errors>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-if="exam.questions[questionIndex].question_type == 3">
                        <div class="col_12">
                            <div class="form-group ">
                                <label>{{ trans('professor.form.exam.question.answer') }}</label>
                                <textarea class="form_global" v-model="exam.questions[questionIndex].answer" rows="5"></textarea>
                                <v-errors :errors="errorFor('questions.'+ questionIndex +'.answer')"></v-errors>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-if="exam.questions[questionIndex].question_type == 4">
                        <div class="col_12">
                            <div class="form-group ">
                                <label>{{ trans('professor.form.exam.question.answer') }}</label>
                                <textarea class="form_global" v-model="exam.questions[questionIndex].answer" rows="10"></textarea>
                                <v-errors :errors="errorFor('questions.'+ questionIndex +'.answer')"></v-errors>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d_flex_end">
                        <router-link class="btn btn_secondary mr_5" :to="{name: 'subject_exams', params: {semester_id: $route.params.semester_id }}">{{ trans('professor.label.cancel') }}</router-link>
                        <button class="btn btn_md btn_success" @click.prevent="submitForm">{{ trans('professor.label.save') }}</button>
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
            exam: {
                semester_id: this.$route.params.semester_id,
                title: null,
                start_period: null,
                end_period: null,
                time_limit: null,
                exam_type: 1,
                questions: [
                    {
                        question_type : 1,
                        difficulty : '',
                        quater_code : 1,
                        title : '',
                        problem_related_image : '',
                        attachment : '',
                        answer : '',
                        marks : null,
                        mcq1 : '',
                        mcq2 : '',
                        mcq3 : '',
                        mcq4 : '',
                        mcq5 : '',
                    }
                ]
            },
            removeQuestions: [],
            loading: false,
            pageName: this.trans('professor.form.exam.add_new_exam'),
        }
    },
    created() {
        if (this.$route.name === 'subject_exam_update') {
            this.pageName = this.trans('professor.form.exam.edit_exam');
            this.loading = true;

            axios.get('/api/professor/subjects/' + this.$route.params.id + '/exams/'+ this.$route.params.exam_id)
                .then((response) => {
                    this.exam = response.data.data;
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
        changeType(questionIndex){
            this.exam.questions[questionIndex].difficulty = ''
            this.exam.questions[questionIndex].quater_code = 1
            this.exam.questions[questionIndex].title = ''
            this.exam.questions[questionIndex].problem_related_image = ''
            this.exam.questions[questionIndex].attachment = ''
            this.exam.questions[questionIndex].answer = ''
            this.exam.questions[questionIndex].marks = null
            this.exam.questions[questionIndex].mcq1 = ''
            this.exam.questions[questionIndex].mcq2 = ''
            this.exam.questions[questionIndex].mcq3 = ''
            this.exam.questions[questionIndex].mcq4 = ''
            this.exam.questions[questionIndex].mcq5 = ''
        },
        addQuestion(){
            let question = {
                        question_type : 1,
                        difficulty : '',
                        quater_code : 1,
                        title : '',
                        problem_related_image : '',
                        attachment : '',
                        answer : null,
                        marks : '',
                        mcq1 : '',
                        mcq2 : '',
                        mcq3 : '',
                        mcq4 : '',
                        mcq5 : '',
                    }

            this.exam.questions.push(question)
        },
        deleteQuestion(question, index){
            this.removeQuestions.push(question)
            this.exam.questions.splice(index, 1);
        },
        submitForm(){
            this.loading = true;
            this.errors = null;
            this.exam.removeQuestions = this.removeQuestions
            let formData = new FormData()

            Object.keys(this.exam).forEach(key => {
                formData.append(key, this.exam[key])
            });

            if (this.$route.name === 'subject_exam_update') {
                // formData.append('_method','patch')
                axios.patch('/api/professor/subjects/' + this.$route.params.id + '/exams/'+ this.$route.params.exam_id, this.exam)
                    .then((response) => {
                        this.$router.push({name: 'subject_exams', params: {semester_id: this.$route.params.semester_id }});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            }else{
                axios.post('/api/professor/subjects/' + this.$route.params.id + '/exams', this.exam)
                    .then((response) => {
                        this.$router.push({name: 'subject_exams', params: {semester_id: this.$route.params.semester_id }});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            }
        },
        attachmentUpload(e, questionIndex ,callFrom) {
            this.$set(this.exam.questions[questionIndex], callFrom, e.target.files[0])
        },
    },
}
</script>


