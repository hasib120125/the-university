<template>
    <div class="inner">
        <div class="inner_wrap" v-if="exam">
            <h5 class="mb_10">{{ exam && exam.subject? exam.subject.name : '' }} {{ trans('student.form.exam.details.exam_questions') }} </h5>
                <div class="table_responsive">
                    <table class="table table_bordered ">
                        <tbody>
                            <tr>
                                <th>{{ trans('student.form.exam.title') }}</th>
                                <td colspan="3">{{ exam.title }}</td>
                            </tr>
                            <tr>
                                <th>{{ trans('common.index.period') }}</th>
                                <td>{{ exam.start_period }} ~ {{ exam.end_period }}</td>
                                <th>{{ trans('common.index.current_time') }}</th>
                                <td><span class="color_danger">{{ today }}</span></td>
                            </tr>
                            <tr>
                                <th>{{ trans('student.form.exam.details.exam_type') }}</th>
                                <td>{{ exam_type[exam.exam_type - 1]}}</td>
                                <th>{{ trans('student.form.exam.details.exam_duration') }}</th>
                                <td>{{ exam.time_limit }} {{ trans('common.index.minutes') }}</td>
                            </tr>
                            <tr>
                                <th>{{ trans('student.form.exam.remaining_time') }}</th>
                                <td colspan="3">{{ timeInWord }}</td>
                            </tr>
                        </tbody>
                </table>
            </div>
            <div class="mt_15">
                <h5 class="mb_15">{{ trans('student.form.exam.details.submit_answer') }}</h5>
                <div class="row">
                    <template  v-for="(question, index) in questions" >
                        <div class="col-md-12 mb_10" :key="index">
                            <div class="d_flex_btwn">
                                <h5>{{ index+1 }}. {{ question.title }}</h5>
                                <div class="d_flex_start ">
                                    <span class="ml_15 white_space_nowrap fw_bold font_16p"> {{ question.marks }} {{ trans('student.form.exam.marks') }}</span>
                                </div>
                            </div>
                            <template v-if="question.question_type == 1">
                                <div class="form_radio mb_5">
                                    <input type="radio" :id="'o' + index" value="0" v-model="questions[index].answer">
                                    <label :for="'o' + index">A. O</label>
                                </div>
                                <div class="form_radio mb_5">
                                    <input type="radio" :id="'x' + index" value="1" v-model="questions[index].answer">
                                    <label :for="'x' + index">B. X</label>
                                </div>
                            </template>
                            <template v-else-if="question.question_type == 2">
                                <div class="row" v-if="question.mcq1">
                                    <div class="col-md-12">
                                        <div class="form_radio mb_5">
                                            <input type="radio" :id="'mcq1' + index" value="1" v-model="questions[index].answer">
                                            <label :for="'mcq1' + index">A. {{ question.mcq1 }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" v-if="question.mcq2">
                                    <div class="col-md-12">
                                        <div class="form_radio mb_5">
                                            <input type="radio" :id="'mcq2' + index" value="2" v-model="questions[index].answer">
                                            <label :for="'mcq2' + index">B. {{ question.mcq2 }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" v-if="question.mcq3">
                                    <div class="col-md-12">
                                        <div class="form_radio mb_5">
                                            <input type="radio" :id="'mcq3' + index" value="3" v-model="questions[index].answer">
                                            <label :for="'mcq3' + index">C. {{ question.mcq3 }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" v-if="question.mcq4">
                                    <div class="col-md-12">
                                        <div class="form_radio mb_5">
                                            <input type="radio" :id="'mcq4' + index" value="4" v-model="questions[index].answer">
                                            <label :for="'mcq4' + index">D. {{ question.mcq4 }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" v-if="question.mcq5">
                                    <div class="col-md-12">
                                        <div class="form_radio mb_5">
                                            <input type="radio" :id="'mcq5' + index" value="5" v-model="questions[index].answer">
                                            <label :for="'mcq5' + index">E. {{ question.mcq5 }}</label>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <template v-else-if="question.question_type == 3">
                                <div class="form-group mt_5">
                                    <textarea class="form_global" v-model="questions[index].answer" rows="5"></textarea>
                                </div>
                            </template>
                            <template v-else-if="question.question_type == 4">
                                <div class="form-group mt_5">
                                    <textarea class="form_global" v-model="questions[index].answer" rows="10"></textarea>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
                <div class="mt_10" v-show="questions.length > 0">
                    <router-link class="btn btn_secondary mr_5" :to="{name: 'subject_exams'}">{{ trans('student.label.cancel') }}</router-link>
                    <button class="btn btn_md btn_blue" @click.prevent="submitForm">{{ trans('student.label.submit') }}</button>
                </div>
            </div>
            <div class="exam_timer" ref="examTimer">
                <p>{{ timeInWord }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment'
import validationErrors from "../../../mixins/validationErrors";

export default {
    mixins: [validationErrors],
    data() {
        return {
            exam: {},
            exam_type:[
                    this.trans('student.form.exam.midterm_exam'), 
                    this.trans('student.form.exam.finals'), 
                    this.trans('student.form.exam.bible_test'), 
                ],
            questions:[],
            examDuration: 0,
            timeInWord: '',
        }
    },
    activated(){
        this.loadData()
        window.addEventListener('scroll', this.handleScroll);
    },
    computed:{
        today(){
            return moment().format('l h:mm:ss a')
        }
    },
    updated(){

    },
    methods: {
        handleScroll (event) {
            let videoContentHeight = localStorage.getItem('videoContentHeight')
            if(window.scrollY > (videoContentHeight / 2) ){
                this.$refs.examTimer.classList.value = 'fixed_timer'
            }else{
                this.$refs.examTimer.classList.value = 'exam_timer'
            }
        },
        countDownTimer() {
            if(this.examDuration > 0) {
                setTimeout(() => {
                    this.examDuration -= 1
                    this.timeConvert(this.examDuration)
                    this.countDownTimer()
                }, 1000)
            }else{
                if(this.examDuration == 0){
                    this.examDuration = 0
                    this.submitForm()
                }
            }
        },
        timeConvert(n) {
            let d = Number(n);
            let h = Math.floor(d / 3600);
            let m = Math.floor(d % 3600 / 60);
            let s = Math.floor(d % 3600 % 60);
            
            let hDisplay = h > 9 ? `${h}` : `0${h} `  + ' : ';
            let mDisplay = m > 9 ? `${m}` : `0${m} `  + ' : ';
            let sDisplay = s > 9 ? `${s}` : `0${s} `;
            
            this.timeInWord = hDisplay + mDisplay + sDisplay
        },
        loadData(){
            axios.get(`/api/student/subjects/${this.$route.params.id}/exams/${this.$route.params.exam_id}`)
                .then((response) => { 
                    if(response.data.exist){
                        this.$swal.fire(
                            this.trans('student.label.notify'),
                            response.data.message,
                            'error'
                        )
                        this.$router.push({name: 'subject_exams'})
                    }else if(response.data.exceedTime){
                        this.$swal.fire(
                            this.trans('student.label.canceled'),
                            response.data.message,
                            'error'
                        )
                        this.$router.push({name: 'subject_exams'})
                    }else{
                        this.exam = response.data.data 
                        this.questions = this.exam.questions
                        this.examDuration = this.exam.remainingTime
                        this.countDownTimer()
                    }
                })
        },
        submitForm(){
            this.loading = true
            axios.patch(`/api/student/subjects/${this.$route.params.id}/exams/${this.$route.params.exam_id}`, {questions: this.questions, examDuration: this.examDuration})
            .then((response) => {
                if(response.data.exist){
                    this.$swal.fire(
                        this.trans('student.label.notify'),
                        response.data.message,
                        'error'
                    )
                }else if(response.data.exceedTime){
                    this.$swal.fire(
                        this.trans('student.label.canceled'),
                        response.data.message,
                        'error'
                    )
                }
                else{
                    this.$swal.fire(
                        this.trans('student.label.submitted'),
                        this.trans('student.label.answer_submit_message'),
                        'success'
                    )
                }
                
                this.$router.push({name: 'subject_exams'})
            })
            .catch((err) => this.errors = err.response.data.errors)
            .finally(() => this.loading = false)
        },
    },
}
</script>
<style scoped lang="scss">
    .white_space_nowrap {
        white-space: nowrap;
    }

</style>