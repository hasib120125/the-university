<template>
    <div class="inner overview" v-if="plan">
        <div class="table_responsive">
            <table class="table table_bordered white_space_nowrap">
                <tbody>
                <tr>
                    <th>{{ trans('new.index.subject_details.name') }}</th>
                    <td>{{ plan.subject.name }}</td>
                    <th>{{ trans('admin.form.subject.code') }}</th>
                    <td>{{ plan.subject.code }}</td>
                    <th>{{ trans('admin.form.subject.credit') }}</th>
                    <td>{{ plan.subject.credit }}</td>
                    <th>{{ trans('admin.form.subject.department') }}</th>
                    <td>{{ plan.subject.allDepartmentsName}}</td>
                </tr>

                <tr>
                    <td>{{ trans('admin.form.subject.subject_outline') }}</td>
                    <td colspan="7">{{ plan.subject_outline ? plan.subject_outline : '-' }}</td>
                </tr>
                <tr>
                    <td>{{ trans('admin.form.subject.textbook') }}</td>
                    <td colspan="7">{{ plan.textbook ? plan.textbook : '-' }}</td>
                </tr>
                <tr>
                    <td>{{ trans('admin.form.subject.reference_books') }}</td>
                    <td colspan="7">{{ plan.reference_book ? plan.reference_book : '-' }}</td>
                </tr>
                <tr>
                    <td>{{ trans('admin.form.subject.evaluation_standard') }}</td>
                    <td colspan="7">{{ plan.evaluation_standard ? plan.evaluation_standard : '-' }}</td>
                </tr>
                <tr>
                    <td>{{ trans('admin.form.subject.grade_evaluation') }}</td>
                    <td colspan="7">{{ trans('admin.form.subject.attendance') }}: {{ plan.attendance }}
                        {{ trans('admin.form.subject.mid') }}: {{ plan.middle }}
                        {{ trans('admin.form.subject.final') }}: {{ plan.ending }}
                        {{ trans('admin.form.subject.others') }}: {{ plan.etc }}
                        {{ trans('admin.form.subject.total') }}:  {{ totalMark(plan) > 0 ? totalMark(plan) : 0 }} %</td>
                </tr>
                <tr>
                    <td>{{ trans('admin.form.subject.mark_evaluation') }}</td>
                    <td colspan="7">{{ trans('admin.form.subject.attendance') }}: {{ plan.attendance_mark }}
                        {{ trans('admin.form.subject.mid') }}: {{ plan.middle_mark }}
                        {{ trans('admin.form.subject.final') }}: {{ plan.ending_mark }}
                        {{ trans('admin.form.subject.others') }}: {{ plan.etc_mark }}
                    </td>
                </tr>
                <tr v-if="plan.subject_plan_topics.length > 0">
                    <th colspan="2">{{ trans('admin.form.subject.date') }}</th>
                    <th colspan="4">{{ trans('admin.form.subject.topic') }}</th>
                    <th colspan="2">{{ trans('admin.form.subject.remark') }}</th>
                </tr>
                <tr v-for="(subject_plan_topic, subject_plan_topic_index) in plan.subject_plan_topics" :key="subject_plan_topic_index">
                    <td colspan="2">{{ subject_plan_topic.date }}</td>
                    <td colspan="4">{{ subject_plan_topic.topic }}</td>
                    <td colspan="2">{{ subject_plan_topic.remark }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            plan: null,
            days: [
                this.trans('common.index.saturday'),
                this.trans('common.index.sunday'),
                this.trans('common.index.monday'),
                this.trans('common.index.tuesday'),
                this.trans('common.index.wednesday'),
                this.trans('common.index.thursday'),
                this.trans('common.index.friday')
            ],
            periods: [
                this.trans('common.index.1st_period'),
                this.trans('common.index.2nd_period'),
            ]
        }
    },
    created() {
        axios.get('/api/student/subjects-plan/' + this.$route.params.id)
            .then((response) => this.plan = response.data.data)
    },
    methods: {
        totalMark(lecture){
            return Number(lecture.attendance) + Number(lecture.middle) + Number(lecture.ending) + Number(lecture.etc)
        }
    },
}
</script>
