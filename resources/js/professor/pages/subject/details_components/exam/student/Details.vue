<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-header">
                    <div class="col_10">
                        <div class="card-title">{{ exam && exam.subject ? exam.subject.name : '' }} {{ trans('professor.form.exam.details.exam_questions') }}</div>
                    </div>
                    <div class="col_2">
                        <div class="d_flex_end">
                            <router-link class="btn btn_sm btn_secondary mr_5" :to="{name: 'lecture_exam_students'}"> {{ trans('common.index.back') }} </router-link>
                        </div>
                    </div>
                </div>
                <div class="card-body" v-if="exam">
                    <table class="table table_bordered table_fixed">
                        <tbody>
                            <tr>
                                <th>{{ trans('professor.form.exam.title') }}</th>
                                <td colspan="3">{{ exam.title }}</td>
                            </tr>
                            <tr>
                                <th>{{ trans('common.index.period') }}</th>
                                <td>{{ exam.start_period }} ~ {{ exam.end_period }}</td>
                                <th>{{ trans('common.index.current_time') }}</th>
                                <td><span class="color_danger">{{ today }}</span></td>
                            </tr>
                            <tr>
                                <th>{{ trans('professor.form.exam.details.exam_type') }}</th>
                                <td>{{ exam_type[exam.exam_type - 1]}}</td>
                                <th>{{ trans('professor.form.exam.details.exam_duration') }}</th>
                                <td>{{ exam.time_limit }} {{ trans('common.index.minutes') }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col_12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">{{ trans('professor.form.exam.details.questions_answer') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <template v-for="(question, index) in questions" >
                    <div class="row" :key="index" v-if="question.student_answer">
                        <div class="col_12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d_flex_btwn">
                                        <h5>{{ index+1 }}. {{ question.title }}</h5>
                                        <div class="d_flex_start ">
                                            <span class="mr_10 fw_bold font_16p">{{ trans('professor.form.exam.question.marks') }}</span>
                                            <input type="number" min="0" class="form_global width_50p" v-model="questions[index].student_answer.score" :disabled="[1,2].includes(question.question_type)">
                                            <span class="ml_15 white_space_nowrap fw_bold font_16p"> / {{ question.marks }}</span>
                                        </div>
                                    </div>
                                    <template v-if="question.question_type == 1">
                                        <h4>{{ trans('professor.form.exam.details.student_answer') }} : {{ question.student_answer ? ox[question.student_answer.answer] : '' }}</h4>
                                        <h4>{{ trans('professor.form.exam.details.answer') }} : {{ ox[question.answer] }}</h4>

                                        <div class="form-group col_4 pl_0">
                                            <div class="d_flex_inline">
                                                <label class="mr_10 fw_bold">{{ trans('professor.label.correct') }}</label>
                                                <div class="form_radio">
                                                    <input type="radio" :id="'yes' + index" value="1" v-model="questions[index].student_answer.correct">
                                                    <label :for="'yes' + index">{{ trans('professor.label.yes') }}</label>
                                                </div>
                                                <div class="form_radio">
                                                    <input type="radio" :id="'no' + index" value="0" v-model="questions[index].student_answer.correct">
                                                    <label :for="'no' + index">{{ trans('professor.label.no') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    <template v-else-if="question.question_type == 2">
                                        <h4>{{ trans('professor.form.exam.details.student_answer') }} : {{ question.student_answer ? mcq[question.student_answer.answer - 1] +'. '+ answerOptionName(question, question.student_answer.answer)  : '' }}</h4>
                                        <h4>{{ trans('professor.form.exam.details.answer') }} : {{ mcq[question.answer - 1] +'. '+ answerOptionName(question, question.answer)}}</h4>

                                        <div class="form-group col_4 pl_0">
                                            <div class="d_flex_inline">
                                                <label class="mr_10 fw_bold">{{ trans('professor.label.correct') }}</label>
                                                <div class="form_radio">
                                                    <input type="radio" :id="'yes' + index" value="1" v-model="questions[index].student_answer.correct">
                                                    <label :for="'yes' + index">{{ trans('professor.label.yes') }}</label>
                                                </div>
                                                <div class="form_radio">
                                                    <input type="radio" :id="'no' + index" value="0" v-model="questions[index].student_answer.correct">
                                                    <label :for="'no' + index">{{ trans('professor.label.no') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <h4>{{ trans('professor.form.exam.details.student_answer') }} : {{ question.student_answer ? question.student_answer.answer : '' }}</h4>
                                        <h4>{{ trans('professor.form.exam.details.answer') }} : {{ question.answer }}</h4>

                                        <div class="form-group col_4 pl_0">
                                            <div class="d_flex_inline">
                                                <label class="mr_10 fw_bold">{{ trans('professor.label.correct') }}</label>
                                                <div class="form_radio">
                                                    <input type="radio" :id="'yes' + index" value="1" v-model="questions[index].student_answer.correct">
                                                    <label :for="'yes' + index">{{ trans('professor.label.yes') }}</label>
                                                </div>
                                                <div class="form_radio">
                                                    <input type="radio" :id="'no' + index" value="0" v-model="questions[index].student_answer.correct">
                                                    <label :for="'no' + index">{{ trans('professor.label.no') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                    </template>
                    <div class="row" v-show="questions.length > 0">
                        <div class="col_12">
                            <div class="mt_10">
                                <router-link class="btn btn_secondary mr_5" :to="{name: 'lecture_exam_students'}">{{ trans('professor.label.cancel') }}</router-link>
                                <button class="btn btn_md btn_success" @click.prevent="submitForm">{{ trans('professor.label.save') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment'
import validationErrors from "../../../../../mixins/validationErrors";

export default {
    name : 'exam-evaluate',
    mixins: [validationErrors],
    data() {
        return {
            ox: ['O','X'],
            mcq: ['A','B','C','D','E'],
            exam: {},
            exam_type:[
                this.trans('student.form.exam.midterm_exam'), 
                this.trans('student.form.exam.finals'), 
                this.trans('student.form.exam.bible_test'), 
            ],
            questions:[],
            loading: false,
        }
    },
    created() {
        axios.get(`/api/professor/subjects/exams/${this.$route.params.exam_id}/students/${this.$route.params.student_id}`)
            .then((response) => {
                this.exam = response.data.data 
                this.questions = this.exam.questions
            })
    },
    computed:{
        today(){
            return moment().format('l h:mm:ss a')
        }
    },
    methods: {
        answerOptionName(question = null, answer= null){
            let value = ''
            switch (answer) {
                case '1':
                    value = question.mcq1
                    break;
                case '2':
                    value = question.mcq2
                    break;
                case '3':
                    value = question.mcq3
                    break;
                case '4':
                    value = question.mcq4
                    break;
                case '5':
                    value = question.mcq5
                    break;
            
                default:
                    break;
            }
            
            return value
        },
        submitForm(){
            this.loading = true
            axios.patch(`/api/professor/subjects/exams/${this.$route.params.exam_id}/students/${this.$route.params.student_id}`, {questions: this.questions})
            .then((response) => {
                this.$swal.fire(
                    this.trans('professor.label.success') + '!',
                    this.trans('professor.label.store_messasge') + '.',
                    'success'
                )
                
                this.$router.push({name: 'subject_exam_students'})
            })
            .catch((err) => this.errors = err.response.data.errors)
            .finally(() => this.loading = false)
        },
    },
}
</script>
<style scoped>
    .white_space_nowrap {
        white-space: nowrap;
    }
</style>
