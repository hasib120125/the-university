<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ trans('admin.form.lecture.lecture_overview') }}</div>
                </div>
                <div class="card-body" >
                    <table class="table table_bordered table_fixed" v-if="lecture">
                        <tbody>
                            <tr>
                                <th rowspan="2">{{ trans('admin.form.lecture.division') }}</th>
                                <th colspan="2">{{ trans('admin.form.lecture.course_title') }}</th>
                                <th>{{ trans('admin.form.lecture.professor_in_charge') }}</th>
                            </tr>
                            <tr>
                                <td colspan="2">{{ lecture.subject ? lecture.subject.name : '-' }}</td>
                                <td>{{ lecture.professor ? lecture.professor.name : '-' }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('admin.form.lecture.lecture_time') }}</td>
                                <td colspan="3"> {{ days[lecture.day - 1] }} {{ periods[lecture.start_time - 1] }} - {{ periods[lecture.end_time - 1] }} </td>
                            </tr>
                            <tr>
                                <td>{{ trans('admin.form.lecture.lecture_room') }}</td>
                                <td colspan="3">{{ lecture.room }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('admin.form.lecture.course_objectives') }}</td>
                                <td colspan="3">{{ lecture.course_objective ? lecture.course_objective : '-' }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('admin.form.lecture.lecture_outline') }}</td>
                                <td colspan="3">{{ lecture.lecture_outline ? lecture.lecture_outline : '-' }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('admin.form.lecture.textbook') }}</td>
                                <td colspan="3">{{ lecture.textbook ? lecture.textbook : '-' }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('admin.form.lecture.reference_books') }}</td>
                                <td colspan="3">{{ lecture.reference_book ? lecture.reference_book : '-' }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('admin.form.lecture.evaluation_standard') }}</td>
                                <td colspan="3">{{ lecture.evaluation_standard ? lecture.evaluation_standard : '-' }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('admin.form.lecture.grade_evaluation') }}</td>
                                <td colspan="3">{{ trans('admin.form.lecture.attendance') }}: {{ lecture.attendance }}
                                    {{ trans('admin.form.lecture.mid') }}: {{ lecture.middle }}
                                    {{ trans('admin.form.lecture.final') }}: {{ lecture.ending }}
                                    {{ trans('admin.form.lecture.others') }}: {{ lecture.etc }}
                                    {{ trans('admin.form.lecture.total') }}:  {{ totalMark(lecture) > 0 ? totalMark(lecture) : 0 }} %</td>
                            </tr>
                            <tr>
                                <th>{{ trans('admin.form.lecture.parking') }}</th>
                                <th>{{ trans('admin.form.lecture.main_topic') }}</th>
                                <th>{{ trans('admin.form.lecture.lecture_content') }}</th>
                                <th>{{ trans('admin.form.lecture.remark') }}</th>
                            </tr>
                            <tr v-for="(lecture_week, lecture_week_index) in lecture.lecture_weeks" :key="lecture_week_index">
                                <td>{{ trans('admin.form.lecture.week') }} {{ lecture_week.week }}</td>
                                <td>{{ lecture_week.topic }}</td>
                                <td>{{ lecture_week.lecture_content }}</td>
                                <td>{{ lecture_week.remark }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="d_flex_end">
                        <router-link class="btn btn_sm btn_info mr_5" :to="{name: 'lecture_plan_edit'}">{{ trans('admin.label.edit') }}</router-link>
                        <button class="btn btn_sm btn_secondary">{{ trans('admin.label.print') }}</button>
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
            lecture: null,
            days: ['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'],
            periods: ['1st Period','2nd Period']
        }
    },
    created() {
        axios.get('/api/admin/lectures/' + this.$route.params.id + '?week=true')
            .then((response) => { this.lecture = response.data.data })
    },
    methods: {
        totalMark(lecture){
            return Number(lecture.attendance) + Number(lecture.middle) + Number(lecture.ending) + Number(lecture.etc)
        }
    },
}
</script>
