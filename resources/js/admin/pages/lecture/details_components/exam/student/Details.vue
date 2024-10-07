<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-header">
                    <div class="col_10">
                        <div class="card-title">{{ exam && exam.lecture && exam.lecture.subject ? exam.lecture.subject.name : '' }} {{ trans('admin.form.exam.details.exam_questions') }}</div>
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
                                <th>{{ trans('admin.form.exam.details.exam_title') }}</th>
                                <td colspan="3">{{ exam.test_title }}</td>
                            </tr>
                            <tr>
                                <th>{{ trans('common.index.period') }}</th>
                                <td>{{ exam.start_period }} ~ {{ exam.end_period }}</td>
                                <th>{{ trans('common.index.current_time') }}</th>
                                <td><span class="color_danger">{{ today }}</span></td>
                            </tr>
                            <tr>
                                <th>{{ trans('admin.form.exam.details.total_question') }}</th>
                                <td>{{ exam.number_of_question}}</td>
                                <th>Marks per question</th>
                                <td>{{ exam.marks_per_question }}</td>
                            </tr>
                            <tr>
                                <th>{{ trans('admin.form.exam.details.exam_type') }}</th>
                                <td>{{ exam_type[exam.exam_type - 1]}}</td>
                                <th>{{ trans('admin.form.exam.details.exam_duration') }}</th>
                                <td>{{ exam.time_limit }} {{ trans('common.index.minutes') }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col_12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">{{ trans('admin.form.exam.details.questions_answer') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <template v-for="(question, index) in questions" >
                    <div class="row" :key="index" v-if="question.student_answer">
                        <div class="col_12">
                            <div class="card">
                                <div class="card-body">
                                    <h4>{{ index + 1 }}. {{ question.exam_title }}</h4>
                                    <template v-if="question.question_type == 1">
                                        <h4>{{ trans('admin.form.exam.details.student_answer') }} : {{ question.student_answer ? ox[question.student_answer.answer] : '' }}</h4>
                                        <h4>{{ trans('admin.form.exam.details.answer') }} : {{ ox[question.answer] }}</h4>

                                        <div class="form-group col_4 pl_0">
                                            <div class="d_flex_inline">
                                                <label class="mr_10 fw_bold">{{ trans('admin.label.correct') }}</label>
                                                <div class="form_radio">
                                                    <input type="radio" :id="'yes' + index" value="1" v-model="questions[index].student_answer.correct">
                                                    <label :for="'yes' + index">{{ trans('admin.label.yes') }}</label>
                                                </div>
                                                <div class="form_radio">
                                                    <input type="radio" :id="'no' + index" value="0" v-model="questions[index].student_answer.correct">
                                                    <label :for="'no' + index">{{ trans('admin.label.no') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    <template v-else-if="question.question_type == 2">
                                        <h4>{{ trans('admin.form.exam.details.student_answer') }} : {{ question.student_answer ? mcq[question.student_answer.answer - 1] +'. '+ answerOptionName(question, question.student_answer.answer)  : '' }}</h4>
                                        <h4>{{ trans('admin.form.exam.details.answer') }} : {{ mcq[question.answer - 1] +'. '+ answerOptionName(question, question.answer)}}</h4>

                                        <div class="form-group col_4 pl_0">
                                            <div class="d_flex_inline">
                                                <label class="mr_10 fw_bold">{{ trans('admin.label.correct') }}</label>
                                                <div class="form_radio">
                                                    <input type="radio" :id="'yes' + index" value="1" v-model="questions[index].student_answer.correct">
                                                    <label :for="'yes' + index">{{ trans('admin.label.yes') }}</label>
                                                </div>
                                                <div class="form_radio">
                                                    <input type="radio" :id="'no' + index" value="0" v-model="questions[index].student_answer.correct">
                                                    <label :for="'no' + index">{{ trans('admin.label.no') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <h4>{{ trans('admin.form.exam.details.student_answer') }} : {{ question.student_answer ? question.student_answer.answer : '' }}</h4>
                                        <h4>{{ trans('admin.form.exam.details.answer') }} : {{ question.answer }}</h4>

                                        <div class="form-group col_4 pl_0">
                                            <div class="d_flex_inline">
                                                <label class="mr_10 fw_bold">{{ trans('admin.label.correct') }}</label>
                                                <div class="form_radio">
                                                    <input type="radio" :id="'yes' + index" value="1" v-model="questions[index].student_answer.correct">
                                                    <label :for="'yes' + index">{{ trans('admin.label.yes') }}</label>
                                                </div>
                                                <div class="form_radio">
                                                    <input type="radio" :id="'no' + index" value="0" v-model="questions[index].student_answer.correct">
                                                    <label :for="'no' + index">{{ trans('admin.label.no') }}</label>
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
                                <router-link class="btn btn_secondary mr_5" :to="{name: 'lecture_exam_students'}">{{ trans('admin.label.cancel') }}</router-link>
                                <button class="btn btn_md btn_success" @click.prevent="submitForm">{{ trans('admin.label.save') }}</button>
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
    mixins: [validationErrors],
    data() {
        return {
            ox: ['O','X'],
            mcq: ['A','B','C','D','E'],
            exam: {},
            exam_type:['Midterm exam', 'Finals', 'Bible test'],
            questions:[]
        }
    },
    created() {
        axios.get(`/api/admin/lectures/exams/${this.$route.params.exam_id}/students/${this.$route.params.student_id}`)
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
            axios.patch(`/api/admin/lectures/exams/${this.$route.params.exam_id}/students/${this.$route.params.student_id}`, {questions: this.questions})
            .then((response) => {
                this.$swal.fire(
                    this.trans('admin.label.submitted') + '!',
                    this.trans('admin.label.store_messasge') + '.',
                    'success'
                )
                
                this.$router.push({name: 'lecture_exam_students'})
            })
            .catch((err) => this.errors = err.response.data.errors)
            .finally(() => this.loading = false)
        },
    },
}
</script>
