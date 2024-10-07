<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ trans('professor.form.lecture_schedule.lecture_schedule') }}</div>
                </div>
                <div class="card-body">
                    <table class="table table_bordered table_center table_fixed">
                        <thead>
                        <tr>
                            <th>{{ trans('professor.form.lecture_schedule.room') }}</th>
                            <th>{{ trans('professor.form.lecture_schedule.start_time') }}</th>
                            <th>{{ trans('professor.form.lecture_schedule.end_time') }}</th>
                            <th>{{ trans('professor.form.lecture_schedule.start_period') }}</th>
                            <th>{{ trans('professor.form.lecture_schedule.end_period') }}</th>
                            <th>{{ trans('professor.form.lecture_schedule.mon') }}</th>
                            <th>{{ trans('professor.form.lecture_schedule.tue') }}</th>
                            <th>{{ trans('professor.form.lecture_schedule.wed') }}</th>
                            <th>{{ trans('professor.form.lecture_schedule.thu') }}</th>
                            <th>{{ trans('professor.form.lecture_schedule.fri') }}</th>
                            <th>{{ trans('professor.form.lecture_schedule.sat') }}</th>
                            <th>{{ trans('professor.form.lecture_schedule.sun') }}</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr v-for="(lecture, i) in lectures" :key="'lecture'+i">
                            <td>{{ lecture.room }}</td>
                            <td>{{ lecture.start_time }}</td>
                            <td>{{ lecture.end_time }}</td>
                            <td>{{ lecture.start_period }}</td>
                            <td>{{ lecture.end_period }}</td>
                            <td><span v-if="lecture.day === 3 && lecture.subject"> {{ lecture.subject.name }} </span></td>
                            <td><span v-if="lecture.day === 4 && lecture.subject"> {{ lecture.subject.name }} </span></td>
                            <td><span v-if="lecture.day === 5 && lecture.subject"> {{ lecture.subject.name }} </span></td>
                            <td><span v-if="lecture.day === 6 && lecture.subject"> {{ lecture.subject.name }} </span></td>
                            <td><span v-if="lecture.day === 7 && lecture.subject"> {{ lecture.subject.name }} </span></td>
                            <td><span v-if="lecture.day === 1 && lecture.subject"> {{ lecture.subject.name }} </span></td>
                            <td><span v-if="lecture.day === 2 && lecture.subject"> {{ lecture.subject.name }} </span></td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            lectures:[],
        }
    },
    created() {
        axios.get('/api/professor/lectures')
            .then((response) => { this.lectures = response.data.data })
    },
}
</script>
