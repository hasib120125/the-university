<template>
    <div>
        <div class="inner">
            <div class="inner_wrap">
                <div class="table_responsive" v-if="exams.length > 0">
                    <table class="table table_center">
                        <thead>
                            <tr>
                                <th class="text-left">{{trans('student.form.exam.title')}}</th>
                                <th>{{trans('student.form.exam.start_period')}}</th>
                                <th>{{trans('student.form.exam.end_period')}}</th>
                                <th>{{trans('common.index.status')}}</th>
                                <th>{{trans('student.form.exam.score')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(exam, examIndex) in exams" :key="examIndex">
                                <td class="text-left">{{exam.title}}</td>
                                <td>{{exam.start_period}}</td>
                                <td>{{exam.end_period}}</td>
                                <td>{{exam.submission_status_message}}</td>
                                <td>{{exam.student_exam_score}}</td>
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
            exams: [],
        }
    },
    activated(){
        this.loadData()
    },
    methods: {
        loadData(){
            axios.get(`/api/student/subjects/${this.$route.params.id}/examList`)
                .then((response) => this.exams = response.data.data);
        }
    }
}
</script>
