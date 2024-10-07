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
                            <div class="form-group mb_5">
                                <label>{{ trans('admin.form.exam.question.question_type') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" id="ox_type" v-model="form.question_type" @change="changeType()" value="1">
                                <label for="ox_type">{{ trans('admin.form.exam.question.ox_type') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" id="multiple_choice" v-model="form.question_type" @change="changeType()" value="2">
                                <label for="multiple_choice">{{ trans('admin.form.exam.question.mcq') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" id="short_answer" v-model="form.question_type" @change="changeType()" value="3">
                                <label for="short_answer">{{ trans('admin.form.exam.question.short') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" id="narrative" v-model="form.question_type" @change="changeType()" value="4">
                                <label for="narrative">{{ trans('admin.form.exam.question.narrative') }}</label>
                            </div>
                            <v-errors :errors="errorFor('question_type')"></v-errors>
                        </div>
                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.exam.question.difficulty') }}</label>
                                <div class="d_flex_inline">
                                    <input type="number" min="1" max="5" class="form_global" v-model="form.difficulty">
                                    <span class="ml_5 color_danger"> {{ trans('admin.form.exam.question.dif_message') }}</span>
                                </div>
                                <v-errors :errors="errorFor('difficulty')"></v-errors>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col_4">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.exam.classification_of_the_test') }}</label>
                                <select class="form_global" id="exam_type" v-model="form.quater_code">
                                    <option value="1">{{ trans('admin.form.exam.midterm_exam') }}</option>
                                    <option value="2">{{ trans('admin.form.exam.finals') }}</option>
                                    <option value="3">{{ trans('admin.form.exam.bible_test') }}</option>
                                </select>
                                <v-errors :errors="errorFor('quater_code')"></v-errors>
                            </div>
                        </div>
                        <div class="col_8">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.exam.question.problem') }}</label>
                                <input type="text" class="form_global" v-model="form.exam_title">
                                <v-errors :errors="errorFor('exam_title')"></v-errors>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.exam.question.related_image') }}</label>
                                <input type="file" id="file" ref="file" class="form_global"  @change="attachmentUpload($event, 'problem_related_image')">
                                <v-errors :errors="errorFor('problem_related_image')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.exam.question.attachment') }}</label>
                                <input type="file" id="file" ref="file" class="form_global" @change="attachmentUpload($event, 'attachment')">
                                <v-errors :errors="errorFor('attachment')"></v-errors>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-if="form.question_type == 1">
                        <div class="col_12">
                            <div class="form-group mb_5">
                                <label>{{ trans('admin.form.exam.question.question_answer') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" id="o" v-model="form.answer" value="0">
                                <label for="o">O</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" id="x" v-model="form.answer" value="1">
                                <label for="x">X</label>
                            </div>
                            <v-errors :errors="errorFor('answer')"></v-errors>
                        </div>
                    </div>
                    <div class="row" v-if="form.question_type == 2">
                        <div class="col_12">
                            <div class="form-group">
                                <label>{{ trans('admin.form.exam.question.question_answer') }}</label>
                                <div class="row">
                                    <div class="d_flex_inline col_6">
                                        <div class="form_radio">
                                            <input type="radio" id="mcq1" v-model="form.answer" value="1">
                                            <label for="mcq1"></label>
                                        </div>
                                        <input type="text" class="form_global" v-model="form.mcq1" :placeholder="trans('admin.form.exam.question.mcq_placeholder')">
                                        <v-errors :errors="errorFor('mcq1')"></v-errors>
                                    </div>
                                    <div class="d_flex_inline col_6">
                                        <div class="form_radio">
                                            <input type="radio" id="mcq2"  v-model="form.answer" value="2">
                                            <label for="mcq2"></label>
                                        </div>
                                        <input type="text" class="form_global" v-model="form.mcq2" :placeholder="trans('admin.form.exam.question.mcq_placeholder')">
                                        <v-errors :errors="errorFor('mcq2')"></v-errors>
                                    </div>
                                </div>
                                <div class="row mt_10">
                                    <div class="d_flex_inline col_6">
                                        <div class="form_radio">
                                            <input type="radio" id="mcq3" v-model="form.answer" value="3">
                                            <label for="mcq3"></label>
                                        </div>
                                        <input type="text" class="form_global" v-model="form.mcq3" :placeholder="trans('admin.form.exam.question.mcq_placeholder')">
                                        <v-errors :errors="errorFor('mcq3')"></v-errors>
                                    </div>
                                    <div class="d_flex_inline col_6">
                                        <div class="form_radio">
                                            <input type="radio" id="mcq4"  v-model="form.answer" value="4">
                                            <label for="mcq4"></label>
                                        </div>
                                        <input type="text" class="form_global" v-model="form.mcq4" :placeholder="trans('admin.form.exam.question.mcq_placeholder')">
                                        <v-errors :errors="errorFor('mcq4')"></v-errors>
                                    </div>
                                </div>
                                <div class="row mt_10">
                                    <div class="d_flex_inline col_6">
                                        <div class="form_radio">
                                            <input type="radio" id="mcq5" v-model="form.answer" value="5">
                                            <label for="mcq5"></label>
                                        </div>
                                        <input type="text" class="form_global" v-model="form.mcq5" :placeholder="trans('admin.form.exam.question.mcq_placeholder')">
                                        <v-errors :errors="errorFor('mcq5')"></v-errors>
                                    </div>
                                </div>
                                <v-errors :errors="errorFor('answer')"></v-errors>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-if="form.question_type == 3">
                        <div class="col_12">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.exam.question.answer') }}</label>
                                <textarea class="form_global" v-model="form.answer" rows="5"></textarea>
                                <v-errors :errors="errorFor('answer')"></v-errors>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-if="form.question_type == 4">
                        <div class="col_12">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.exam.question.answer') }}</label>
                                <textarea class="form_global" v-model="form.answer" rows="10"></textarea>
                                <v-errors :errors="errorFor('answer')"></v-errors>
                            </div>
                        </div>
                    </div>
                    <div class="d_flex_end">
                        <router-link class="btn btn_secondary mr_5" :to="{name: 'lecture_exam_questions'}">{{ trans('admin.label.cancel') }}</router-link>
                        <button class="btn btn_md btn_success" @click.prevent="submitForm">{{ trans('admin.label.save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import validationErrors from "../../../../../mixins/validationErrors";
import Datepicker from 'vuejs-datepicker';

export default {
    name:'question-form',
    mixins: [validationErrors],
    components: {Datepicker},
    data(){
        return {
            form: {
                question_type: '',
                difficulty: '',
                quater_code: 1,
                exam_title: '',
                problem_related_image: '',
                attachment: '',
                answer: '',
                mcq1: '',
                mcq2: '',
                mcq3: '',
                mcq4: '',
                mcq5: ''
            },
            pageName: this.trans('admin.form.exam.question.add_question') 
        }
    },
    created() {

        if (this.$route.name === 'lecture_exam_question_update') {
            this.pageName = this.trans('admin.form.exam.question.edit_question')
            this.loading = true

            axios.get(`/api/admin/lecture-exams/${this.$route.params.exam_id}/questions/${this.$route.params.question_id}`)
                .then((response) => {
                    this.form = response.data.data
                    this.form.problem_related_image = ''
                    this.form.attachment = ''
                }).finally(() => this.loading = false)
        }
    },
    methods: {
        changeType(){
            this.form.answer = ''
            this.form.mcq1 = ''
            this.form.mcq2 = ''
            this.form.mcq3 = ''
            this.form.mcq4 = ''
            this.form.mcq5 = ''
        },
        submitForm(){
            this.loading = true
            this.errors = null

            let formData = new FormData()

            Object.keys(this.form).forEach(key => {
                formData.append(key, this.form[key])
            });

            if (this.$route.name === 'lecture_exam_question_update') {
                formData.append('_method','patch')
                axios.post(`/api/admin/lecture-exams/${this.$route.params.exam_id}/questions/${this.$route.params.question_id}`, formData)
                    .then((response) => {
                        this.$router.push({name: 'lecture_exam_questions'})
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false)

            }else{
                axios.post(`/api/admin/lecture-exams/${this.$route.params.exam_id}/questions`, formData)
                    .then((response) => {
                        this.$router.push({name: 'lecture_exam_questions'})
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false)

            }
        },
        attachmentUpload(e, callFrom) {
            this.$set(this.form, callFrom, e.target.files[0])
        },
    },
}
</script>
<style scoped>
textarea {
  resize: none;
}
</style>


