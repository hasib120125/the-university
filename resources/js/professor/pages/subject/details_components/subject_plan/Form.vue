<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ trans('professor.form.subject.subject_plan') }}</div>
                </div>
                <div :class="['card-body', {'loading_overlay': loading}]" >
                    <table class="table table_bordered table_fixed" v-if="subject_plan">
                        <tbody>
                            <tr v-if="subject">
                                <th>{{ trans('professor.form.subject.name') }}</th>
                                <td>{{ subject.name }}</td>
                                <th>{{ trans('professor.form.subject.code') }}</th>
                                <td>{{ subject.code }}</td>
                                <th>{{ trans('professor.form.subject.credit') }}</th>
                                <td>{{ subject.credit }}</td>
                                <th>{{ trans('professor.form.subject.department') }}</th>
                                <td>{{ subject.allDepartmentsName }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('professor.form.subject.subject_outline') }}</td>
                                <td colspan="7"><input type="text" class="form_global" v-model="subject_plan.subject_outline"></td>
                            </tr>

                            <tr>
                                <td>{{ trans('professor.form.subject.textbook') }}</td>
                                <td colspan="7"><input type="text" class="form_global" v-model="subject_plan.textbook"></td>
                            </tr>
                            <tr>
                                <td>{{ trans('professor.form.subject.reference_books') }}</td>
                                <td colspan="7"><input type="text" class="form_global" v-model="subject_plan.reference_book"></td>
                            </tr>
                            <tr>
                                <td>{{ trans('professor.form.subject.evaluation_standard') }}</td>
                                <td colspan="7"><input type="text" class="form_global" v-model="subject_plan.evaluation_standard"></td>
                            </tr>
                            <tr>
                                <td>{{ trans('professor.form.subject.grade_evaluation') }}</td>
                                <td colspan="7">
                                    <div class="row">
                                        <div class="col_4">
                                            <div class="form_row_inline">
                                                <label>{{ trans('professor.form.subject.attendance') }}</label>
                                                <input min="0" type="number" class="form_global" v-model="subject_plan.attendance">
                                                <v-errors :errors="errorFor('attendance')"></v-errors>
                                            </div>
                                        </div>
                                        <div class="col_4">
                                            <div class="form_row_inline">
                                                <label>{{ trans('professor.form.subject.mid') }}</label>
                                                <input min="0" type="number" class="form_global" v-model="subject_plan.middle">
                                                <v-errors :errors="errorFor('middle')"></v-errors>
                                            </div>
                                        </div>
                                        <div class="col_4">
                                            <div class="form_row_inline">
                                                <label>{{ trans('professor.form.subject.final') }}</label>
                                                <input min="0" type="number" class="form_global" v-model="subject_plan.ending">
                                                <v-errors :errors="errorFor('ending')"></v-errors>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt_10">
                                        <div class="col_4">
                                            <div class="form_row_inline">
                                                <label>{{ trans('professor.form.subject.others') }}</label>
                                                <input min="0" type="number" class="form_global" v-model="subject_plan.etc">
                                                <v-errors :errors="errorFor('etc')"></v-errors>
                                            </div>
                                        </div>
                                        <div class="col_4">
                                            <div class="form_row_inline">
                                                <p>{{ trans('professor.form.subject.total') }}: <span :class="totalMark > 100 || totalMark < 100 ? 'color_danger' : ''">{{ totalMark > 0 ? totalMark: 0 }} %</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <v-errors :errors="errorFor('total_mark')"></v-errors>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ trans('professor.form.subject.mark_evaluation') }}</td>
                                <td colspan="7">
                                    <div class="row">
                                        <div class="col_4">
                                            <div class="form_row_inline">
                                                <label>{{ trans('professor.form.subject.attendance') }}</label>
                                                <input min="0" type="number" class="form_global" v-model="subject_plan.attendance_mark">
                                                <v-errors :errors="errorFor('attendance_mark')"></v-errors>
                                            </div>
                                        </div>
                                        <div class="col_4">
                                            <div class="form_row_inline">
                                                <label>{{ trans('professor.form.subject.mid') }}</label>
                                                <input min="0" type="number" class="form_global" v-model="subject_plan.middle_mark">
                                                <v-errors :errors="errorFor('middle_mark')"></v-errors>
                                            </div>
                                        </div>
                                        <div class="col_4">
                                            <div class="form_row_inline">
                                                <label>{{ trans('professor.form.subject.final') }}</label>
                                                <input min="0" type="number" class="form_global" v-model="subject_plan.ending_mark">
                                                <v-errors :errors="errorFor('ending_mark')"></v-errors>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt_10">
                                        <div class="col_4">
                                            <div class="form_row_inline">
                                                <label>{{ trans('professor.form.subject.others') }}</label>
                                                <input min="0" type="number" class="form_global" v-model="subject_plan.etc_mark">
                                                <v-errors :errors="errorFor('etc_mark')"></v-errors>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="2">{{ trans('professor.form.subject.date') }}</th>
                                <th colspan="4">{{ trans('professor.form.subject.topic') }}</th>
                                <th colspan="2">{{ trans('professor.form.subject.remark') }}</th>
                            </tr>
                            <tr v-for="(subject_plan_topic, subject_plan_topic_index) in subject_plan.subject_plan_topics" :key="subject_plan_topic_index">
                                <td colspan="2">
                                    <datepicker :typeable="true"  input-class="form_global form_date_picker" :value="subject_plan.subject_plan_topics[subject_plan_topic_index].date" 
                                        @input="subject_plan.subject_plan_topics[subject_plan_topic_index].date = dateFormat($event, 'YYYY-MM-DD') "></datepicker>
                                    <v-errors :errors="errorFor('subject_plan_topics.'+subject_plan_topic_index +'.date')"></v-errors>
                                </td>
                                <td colspan="4">
                                    <input type="text" class="form_global" v-model="subject_plan.subject_plan_topics[subject_plan_topic_index].topic">
                                    <v-errors :errors="errorFor('subject_plan_topics.'+subject_plan_topic_index +'.topic')"></v-errors>
                                </td>
                                <td colspan="2">
                                    <div class="d_flex_btwn">
                                        <div class="form-group mb_0 width_full">
                                            <input type="text" class="form_global" v-model="subject_plan.subject_plan_topics[subject_plan_topic_index].remark">
                                            <v-errors :errors="errorFor('subject_plan_topics.'+subject_plan_topic_index +'.remark')"></v-errors>
                                        </div>
                                        <div class="d_flex_start ml_15">
                                            <span @click="addSPT" v-if=" subject_plan_topic_index + 1 === subject_plan.subject_plan_topics.length" class="cursor_pointer"><i class="lni lni-plus mr_10"></i></span>
                                            <span @click="deleteSPT(subject_plan_topic, subject_plan_topic_index)" v-if="subject_plan.subject_plan_topics.length > 1" class="cursor_pointer"><i class="lni lni-minus"></i></span>
                                        </div>
                                    </div>
                                    
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="d_flex_end">
                        <router-link class="btn btn_secondary mr_5" :to="{name: 'subject_plan', params:{semester_id: $route.params.semester_id}}">{{ trans('professor.label.cancel') }}</router-link>
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
    name: 'subject-plan-edit',
    mixins: [validationErrors],
    components: {
        Datepicker
    },
    data() {
        return {
            loading: false,
            subject_plan: {
                semester_id : this.$route.params.semester_id,
                subject_outline : '',
                textbook : '',
                reference_book : '',
                evaluation_standard : '',
                attendance : 0,
                middle : 0,
                ending : 0,
                etc : 0,
                attendance_mark : 0,
                middle_mark : 0,
                ending_mark : 0,
                etc_mark : 0,
                subject_plan_topics : [
                    {
                        subject_plan_id : null,
                        date : '',
                        topic : '',
                        remark : ''
                    }
                ]
            },
            subject : null,
            removeSPT : [],
        }
    },
    created() {
        axios.get('/api/professor/subjects/' + this.$route.params.id)
            .then((response) => { this.subject = response.data.data })

        axios.get('/api/professor/subjects/' + this.$route.params.id + '/plans/' + this.$route.params.semester_id)
            .then((response) => {
                if(response.data.data){
                    this.subject_plan = response.data.data 
                }
            })
    },
    computed:{
        totalMark(){
            let lecture = this.subject_plan
            return Number(lecture.attendance) + Number(lecture.middle) + Number(lecture.ending) + Number(lecture.etc)
        }
    },
    methods: {
        dateFormat(e, format){
            if(e){
                return this.moment(e).format(format)
            }
            return null
        },
        addSPT(){
            let subjectPlanTopic = {
                        subject_plan_id : null,
                        subject_id : this.$route.params.id,
                        date : '',
                        topic : '',
                        remark : ''
                    }

            this.subject_plan.subject_plan_topics.push(subjectPlanTopic)
        },
        deleteSPT(subject_plan_topic, index){
            this.removeSPT.push(subject_plan_topic)
            this.subject_plan.subject_plan_topics.splice(index, 1);
        },
        submitForm(){
            this.loading = true;

            if(this.subject_plan.id){
                this.subject_plan.removeSPT = this.removeSPT

                axios.patch('/api/professor/subjects/'+ this.$route.params.id + '/subject-plans/' + this.subject_plan.id, this.subject_plan)
                    .then((response) => {
                        this.$router.push({name: 'subject_plan'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);
            }else{
                axios.post('/api/professor/subjects/'+ this.$route.params.id + '/subject-plans', this.subject_plan)
                    .then((response) => {
                        this.$router.push({name: 'subject_plan'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);
            }
            
        },
    },
}
</script>
