<template>
    <div class="modal " :class="{ 'open_modal': showModal}"  data-modal="modal">
        <div class="modal_overlay" data-modal-close="modal" @click="closeModal()"></div>
        <div class="modal_inner">
            <div class="modal_header">
                <span data-modal-close="modal" class="close_icon close_icon_sm" @click="closeModal()">×</span>
                <h2>{{ trans('admin.form.attendance.title') }}</h2>
            </div>
            <div class="modal_wrapper ">
                <div class="modal_content modal_500p">
                    <div class="container">
                        <div class="row">
                            <div class="col_12">
                                <div class="form_row_inline">
                                    <label class="width_260p">{{ this.trans('admin.form.subject.subject') }}</label>
                                    <select class="form_global" v-model="selectedSubjectId" @change="loadAttendanceData">
                                        <option value="">{{ trans('admin.form.lecture.select_subject') }}</option>
                                        <option v-for="(subject, index) in subjects" :key="'subject' + index" :value="subject.subject_id">{{ subject.name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col_12" v-if="lectures.length > 0">
                                <div class="custom_line mb_12"></div>
                            </div>
                            <div class="col_12" v-for="(lecture, index) in lectures" :key="'attendance' + index">
                                <div class="form_row_inline">
                                    <label class="width_260p">{{ lecture.lecture_name }}</label>
                                    <select class="form_global" v-model="lectures[index].lecture_progress_status"> //1['Completed'], 2['Late'], 3['Absent]
                                        <option value="">{{ trans('admin.form.attendance.select_attendance_status') }}</option>
                                        <option value="1">{{ trans('admin.form.attendance.completed') }}</option>
                                        <option value="2">{{ trans('admin.form.attendance.absent') }}</option>
                                        <option value="3">{{ trans('admin.form.attendance.late') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col_12 d_flex_end mt_10">
                                <button class="btn btn_md btn_success" v-if="lectures.length > 0" @click.prevent="submitForm">{{ trans('admin.label.save') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment-timezone'

export default {
    name: 'student-subject-modal',
    props: {
        student_id: {
            type: Number,
            required: true,
            default: 0
        }
    },
    components: {
        
    },
    data() {
        return {
            showModal: false,
            lectures: [],
            subjects: [],
            selectedSubjectId: '',
            studentData: {},
            currentSemester: null,
        }
    },
    mounted(){
        this.getCurrentSemester()
    },
    methods: {
        getCurrentSemester() {
            axios.get(`/api/admin/current-semester`)
                    .then((response) => {
                        this.currentSemester = response.data.data
                    })
        },
        loadAttendanceData(){
            let studentData = _.find(this.subjects, (subject)=> subject.subject_id == this.selectedSubjectId)
            this.studentData = studentData
            let today = moment(new Date()).tz("Asia/Seoul")

            setTimeout(() => {
                axios.get(`/api/admin/students/subject-attendance`, {params: studentData})
                    .then((response) => {
                        this.lectures = _.map(response.data, (lecture)=> {
                            
                            let lecture_progress_status = ''

                            if(lecture.lecture_progress[0]){
                                let lecture_progress =  lecture.lecture_progress[0]
                                lecture_progress_status = lecture_progress.completed == 1 && lecture_progress.late == 1 ? 3 : 
                                                        (lecture_progress.completed == 1 && lecture_progress.late == 0 ? 1 : 
                                                        (lecture_progress.completed == 0 && lecture_progress.late == 0 ? 2 : '')
                                                        )
                            }

                            if(lecture_progress_status === 2 && moment(today).isAfter(moment(this.currentSemester.end_period)) === false) {
                                lecture_progress_status = 3
                            }

                            return {
                                lecture_id: lecture.id,
                                lecture_name: lecture.name,
                                student_id: this.student_id,
                                subject_id: this.selectedSubjectId,
                                lecture_progress_id: lecture.lecture_progress[0] ? lecture.lecture_progress[0].id : null,
                                current_content_type: lecture.lecture_progress[0] ? lecture.lecture_progress[0].current_content_type : null,
                                lecture_progress_status: lecture_progress_status,
                            }
                        })
                    })
            }, 100);
        },
        closeModal(){
            this.lectures = []
            this.subjects = []
            this.selectedSubjectId = ''
            this.showModal = false
        },
        show() {
            axios.get(`/api/admin/students/${this.student_id}/subjects`)
            .then((response) => {
                this.subjects = _.map(response.data.data, (activeSubject)=> {
                    return {
                        semester_id: activeSubject.semester_id, 
                        student_id: activeSubject.student_id, 
                        subject_id: activeSubject.subject_id, 
                        name: activeSubject.subject.name, 
                    }
                })
            })
            
            this.showModal = true
        },
        submitForm(){
            axios.post('/api/admin/students/subject-attendance', {lectures: this.lectures, others: this.studentData})
                    .then((response) => {
                        this.closeModal()
                        this.$swal.fire(
                            this.trans('admin.label.success'),
                            response.data.message,
                            'success'
                        )
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);
        },
    }
}
</script>