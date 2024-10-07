<template>
    <div class="inner">
        <div class="inner_wrap">
            <div class="table_responsive" v-if="assignments.length > 0">
                <table class="table table_center">
                    <thead>
                        <tr>
                            <th class="text-left" width="60%">{{trans('student.form.assignment_board.title')}}</th>
                            <th>{{trans('student.form.assignment_board.start_period')}}</th>
                            <th>{{trans('student.form.assignment_board.end_period')}}</th>
                            <th>{{trans('student.label.action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(assignment, assignmentIndex) in assignments" :key="assignmentIndex">
                            <td class="text-left">{{assignment.assignment_title}}</td>
                            <td>{{assignment.start_period}}</td>
                            <td>{{assignment.end_period}}</td>
                            <td>
                                <router-link class="btn btn_sm btn_blue" :to="{name: 'subject_assignment_view', params: {assignment_id: assignment.id}}"> {{ trans('student.label.details') }} </router-link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            assignments: [],
        }
    },
    created(){
        axios.get(`/api/student/subjects/${this.$route.params.id}/assignments`)
                .then((response) => this.assignments = response.data.data);
    },
    methods: {
        
    }
}
</script>
