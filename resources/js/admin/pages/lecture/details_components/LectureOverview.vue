<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ trans('admin.form.lecture.lecture_overview') }}</div>
                </div>
                <div class="card-body" v-if="lecture">
                    <table class="table table_bordered table_center table_fixed">
                        <thead>
                            <tr>
                                <th>{{ trans('admin.form.lecture.subject') }}</th>
                                <th>{{ trans('admin.form.lecture.professor') }}</th>
                                <th>{{ trans('admin.form.lecture.start_time') }}</th>
                                <th>{{ trans('admin.form.lecture.end_time') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ lecture.subject ? lecture.subject.name : '' }}</td>
                                <td>{{ lecture.professor.name }}</td>
                                <td>{{ periods[lecture.start_time - 1 ] }}</td>
                                <td>{{ periods[lecture.end_time - 1 ] }}</td>
                            </tr>
                        </tbody>
                        <thead>
                            <tr>
                                <th>{{ trans('admin.form.lecture.room') }}</th>
                                <th>{{ trans('admin.form.lecture.class') }}</th>
                                <th>{{ trans('admin.form.lecture.start_period') }}</th>
                                <th>{{ trans('admin.form.lecture.end_period') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ lecture.room }}</td>
                                <td>{{ lecture.class }}</td>
                                <td>{{ lecture.start_period }}</td>
                                <td>{{ lecture.end_period }}</td>
                            </tr>
                        </tbody>
                        <thead>
                            <tr>
                                <th>{{ trans('admin.form.lecture.weekly_hour') }}</th>
                                <th>{{ trans('admin.form.lecture.weekly_number') }}</th>
                                <th>{{ trans('admin.form.lecture.participant') }}</th>
                                <th>{{ trans('admin.form.lecture.day_of_the_week') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ lecture.weekly_hour }}</td>
                                <td>{{ lecture.weekly_num }}</td>
                                <td>{{ lecture.participants }}</td>
                                <td>{{ days[lecture.day - 1] }}</td>
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
            lecture: null,
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
        axios.get('/api/admin/lectures/' + this.$route.params.id)
            .then((response) => { this.lecture = response.data.data })
    },
    methods: {

    },
}
</script>
