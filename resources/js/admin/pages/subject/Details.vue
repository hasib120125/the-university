<template>
    <div>
        <div class="row">
            <div class="col_2">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title" v-if="subject">{{ subject.name }}-{{ trans('admin.form.subject.subject_menu') }}</div>
                    </div>
                    <div class="card-body">
                        <select class="form_global" v-model="semesterId">
                            <option value="" v-if="!semesterId">{{ trans('admin.form.subject.select_semester') }}</option>
                            <option :value="semester.id" v-for="(semester, index) in semesters" :key="'semester_'+index">{{ semester.year+ ' - '+semester.season_name }}</option>
                        </select>

                        <br>
                        <hr>

                        <ul class="inside_custom_menu">
                            <li>
                                <router-link :to="{name: 'subject_overview'}" :semesterId="semesterId">{{ trans('admin.form.subject.overview') }}- {{semesterId}}</router-link>
                            </li>

                            <li v-if="semesterId">
                                <router-link :to="{name: 'subject_plan', params: {semester_id: semesterId}}" :semesterId="semesterId">{{ trans('admin.form.subject.plan') }}</router-link>
                            </li>

                            <li v-if="semesterId">
                                <router-link :to="{name: 'subject_notices', params: {semester_id: semesterId}}">{{ trans('admin.form.subject.notices') }}</router-link>
                            </li>
                            <!-- <li><router-link :to="{name: 'subject_plan', params:{notice_id: $route.params.id}}">{{ trans('admin.form.subject.subject_plan') }}</router-link></li> -->
<!--                            <li><router-link :to="{name: 'subject_managements'}">{{ trans('admin.form.subject_management.subject_management') }}</router-link></li>-->
                            <li v-if="semesterId">
                                <router-link :to="{name: 'subject_materials', params: {semester_id: semesterId}}">{{ trans('admin.form.subject.materials') }}</router-link>
                            </li>
                            <li v-if="semesterId">
                                <router-link :to="{name: 'subject_assignments', params: {semester_id: semesterId}}">{{ trans('admin.form.assignment.assignments') }}</router-link>
                            </li>
                            <li v-if="semesterId">
                                <router-link :to="{name: 'subject_exams', params: {semester_id: semesterId}}">{{ trans('admin.form.exam.exams') }}</router-link>
                            </li>
<!--                            <li><router-link :to="{name: 'subject_majors'}">{{ trans('admin.form.majors.majors') }}</router-link></li>-->
                            <li v-if="semesterId"><router-link :to="{name: 'subject_lectures',  params: {semester_id: semesterId}}">{{ trans('admin.form.lecture.lectures') }}</router-link></li>
                            <li v-if="semesterId"><router-link :to="{name: 'subject_students',  params: {semester_id: semesterId}}">{{ trans('admin.form.student.student') }}</router-link></li>
                            <li v-if="semesterId"><router-link :to="{name: 'subject_grade_students',  params: {semester_id: semesterId}}">{{ trans('admin.form.grade_input.grade_input') }}</router-link></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col_10">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            semesters: [],
            semesterId: '',
            subject: null
        }
    },
    created() {
        axios.get('/api/admin/subjects/' + this.$route.params.id)
            .then((response) => { this.subject = response.data.data })

        axios.get('/api/admin/semesters').then((response) => {
            this.semesters = response.data.data

            axios.get('/api/admin/setting').then((settingResponse) => {
                if (settingResponse.data.data.length && settingResponse.data.data[0].current_semester_id) {
                    this.semesterId = settingResponse.data.data[0].current_semester_id.id
                }else{
                    if (response.data.data.length) {
                        this.semesterId = response.data.data[response.data.data.length - 1].id;
                    }
                }
            })
        })
    },
    watch: {
        semesterId() {
            if (this.$route.params.semester_id) {
                this.$router.push({params: {semester_id: this.semesterId}}).catch(() => {});
            }
        }
    }
}
</script>
