<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ trans('professor.form.subject.subject_plan') }}</div>
                </div>
                <div class="card-body" >
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
                                <td colspan="7">{{ subject_plan.subject_outline ? subject_plan.subject_outline : '-' }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('professor.form.subject.textbook') }}</td>
                                <td colspan="7">{{ subject_plan.textbook ? subject_plan.textbook : '-' }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('professor.form.subject.reference_books') }}</td>
                                <td colspan="7">{{ subject_plan.reference_book ? subject_plan.reference_book : '-' }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('professor.form.subject.evaluation_standard') }}</td>
                                <td colspan="7">{{ subject_plan.evaluation_standard ? subject_plan.evaluation_standard : '-' }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('professor.form.subject.grade_evaluation') }}</td>
                                <td colspan="7">{{ trans('professor.form.subject.attendance') }}: {{ subject_plan.attendance }}
                                    {{ trans('professor.form.subject.mid') }}: {{ subject_plan.middle }}
                                    {{ trans('professor.form.subject.final') }}: {{ subject_plan.ending }}
                                    {{ trans('professor.form.subject.others') }}: {{ subject_plan.etc }}
                                    {{ trans('professor.form.subject.total') }}:  {{ totalMark(subject_plan) > 0 ? totalMark(subject_plan) : 0 }} %</td>
                            </tr>
                            <tr>
                                <td>{{ trans('professor.form.subject.mark_evaluation') }}</td>
                                <td colspan="7">{{ trans('professor.form.subject.attendance') }}: {{ subject_plan.attendance_mark }}
                                    {{ trans('professor.form.subject.mid') }}: {{ subject_plan.middle_mark }}
                                    {{ trans('professor.form.subject.final') }}: {{ subject_plan.ending_mark }}
                                    {{ trans('professor.form.subject.others') }}: {{ subject_plan.etc_mark }}
                                </td>
                            </tr>
                            <tr v-if="subject_plan.subject_plan_topics.length > 0">
                                <th colspan="2">{{ trans('professor.form.subject.date') }}</th>
                                <th colspan="4">{{ trans('professor.form.subject.topic') }}</th>
                                <th colspan="2">{{ trans('professor.form.subject.remark') }}</th>
                            </tr>
                            <tr v-for="(subject_plan_topic, subject_plan_topic_index) in subject_plan.subject_plan_topics" :key="subject_plan_topic_index">
                                <td colspan="2">{{ subject_plan_topic.date }}</td>
                                <td colspan="4">{{ subject_plan_topic.topic }}</td>
                                <td colspan="2">{{ subject_plan_topic.remark }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="d_flex_end">
                        <router-link class="btn btn_sm btn_info mr_5" :to="{name: 'subject_plan_edit' , params:{semester_id: $route.params.semester_id}}">
                            {{ subject_plan ? trans('professor.label.edit') : trans('professor.label.add_subject_plan') }}</router-link>
                        <!-- <button class="btn btn_sm btn_secondary">{{ trans('professor.label.print') }}</button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            subject_plan: {
                subject_id : this.$route.params.id,
                semester_id : this.$route.params.semester_id,
                subject_outline : '',
                textbook : '',
                reference_book : '',
                evaluation_standard : '',
                attendance : 0,
                middle : 0,
                ending : 0,
                etc : 0,
                subject_plan_topics : [

                ]
            },
            subject : null,
        }
    },
    created() {
        axios.get('/api/professor/subjects/' + this.$route.params.id)
            .then((response) => { this.subject = response.data.data })

        this.loadData();
    },
    watch: {
        $route() {
            this.loadData();
        }
    },
    methods: {
        totalMark(lecture){
            return Number(lecture.attendance) + Number(lecture.middle) + Number(lecture.ending) + Number(lecture.etc)
        },
        loadData() {
            this.resetData();

            axios.get('/api/professor/subjects/' + this.$route.params.id + '/plans/' + this.$route.params.semester_id)
                .then((response) => {
                    if (response.data.data)
                        this.subject_plan = response.data.data
                })
        },
        resetData() {
            this.subject_plan.semester_id = this.$route.params.semester_id;
            this.subject_plan.subject_outline = '';
            this.subject_plan.textbook = '';
            this.subject_plan.reference_book = '';
            this.subject_plan.evaluation_standard = '';
            this.subject_plan.attendance = 0;
            this.subject_plan.middle = 0;
            this.subject_plan.ending = 0;
            this.subject_plan.etc = 0;
            this.subject_plan.subject_plan_topics = [];
        }
    },
}
</script>
