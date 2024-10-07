<template>
    <div>
        <div class="row">
            <div class="col_2">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ trans('professor.form.subject.subject_menu') }}</div>
                    </div>
                    <div class="card-body">
                        <select class="form_global" v-model="semesterId">
                            <option value="" v-if="!semesterId">{{ trans('professor.form.subject.select_semester') }}</option>
                            <option :value="semester.id" v-for="(semester, index) in semesters" :key="'semester_'+index">{{ semester.year+ ' - '+semester.season_name }}</option>
                        </select>
                        <br>
                        <hr>
                        <ul class="inside_custom_menu">
                            <li>
                                <router-link :to="{name: 'subject_overview'}" :semesterId="semesterId">{{ trans('professor.form.subject.overview') }}</router-link>
                            </li>

                            <li v-if="semesterId">
                                <router-link :to="{name: 'subject_plan', params: {semester_id: semesterId}}" :semesterId="semesterId">{{ trans('professor.form.subject.plan') }}</router-link>
                            </li>

                            <li v-if="semesterId">
                                <router-link :to="{name: 'subject_notices', params: {semester_id: semesterId}}">{{ trans('professor.form.subject.notices') }}</router-link>
                            </li>
                            <li v-if="semesterId">
                                <router-link :to="{name: 'subject_materials', params: {semester_id: semesterId}}">{{ trans('professor.form.subject.materials') }}</router-link>
                            </li>
                            <li v-if="semesterId">
                                <router-link :to="{name: 'subject_exams', params: {semester_id: semesterId}}">{{ trans('professor.form.exam.exams') }}</router-link>
                            </li>
                           <li v-if="semesterId"><router-link :to="{name: 'subject_lectures',  params: {semester_id: semesterId}}">{{ trans('professor.form.lecture.lectures') }}</router-link></li>
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
            semesterId: ''
        }
    },
    created() {
        axios.get('/api/professor/semesters').then((response) => {
            this.semesters = response.data.data;
            if (response.data.data.length) {
                this.semesterId = response.data.data[response.data.data.length - 1].id;
            }
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
