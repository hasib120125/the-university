<template>
    <div class="modal " :class="{ 'open_modal': showModal}"  data-modal="modal">
        <div class="modal_overlay" data-modal-close="modal" @click="closeModal()"></div>
        <div class="modal_inner">
            <div class="modal_header">
                <span data-modal-close="modal" class="close_icon close_icon_sm" @click="closeModal()">×</span>
                <h2>{{ trans('admin.form.attendance.title') }}</h2>
            </div>
            <div class="modal_wrapper">
                <div class="modal_content modal_500p">
                    <div class="container">
                        <div class="row">
                            <div class="col_12" v-for="(lecture, index) in lectures" :key="'attendance' + index">
                                <div class="form_row_inline">
                                    <label class="width_260p">{{ lecture.lecture_name }}</label>
                                    <select class="form_global" v-model="lectures[index].lecture_progress_status"> //1['Completed'], 3['Late'], 2['Absent]
                                        <option value="">{{ trans('admin.form.attendance.select_attendance_status') }}</option>
                                        <option value="1">{{ trans('admin.form.attendance.completed') }}</option>
                                        <option value="2">{{ trans('admin.form.attendance.absent') }}</option>
                                        <option value="3">{{ trans('admin.form.attendance.late') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col_12 d_flex_end mt_10">
                                <button class="btn btn_md btn_success" @click.prevent="submitForm">{{ trans('admin.label.save') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment'

export default {
    props: {
        studentData: {
            type: Object,
            required: true,
            default: {}
        }
    },
    components: {

    },
    data() {
        return {
            showModal: false,
            lectures: []
        }
    },
    mounted(){

    },
    methods: {
        loadData(){
            axios.get(`/api/admin/students/subject-attendance`, {params: this.studentData})
                .then((response) => {
                    this.lectures = _.map(response.data, (lecture)=> {

                        let lecture_progress_status = ''

                        if(lecture.lecture_progress[0]){
                            let lecture_progress =  lecture.lecture_progress[0]
                            lecture_progress_status = this.calculateLectureProgress(lecture_progress)
                        }

                        return {
                            lecture_id: lecture.id,
                            lecture_name: lecture.name,
                            student_id: this.studentData.student_id,
                            lecture_progress_id: lecture.lecture_progress[0] ? lecture.lecture_progress[0].id : null,
                            current_content_type: lecture.lecture_progress[0] ? lecture.lecture_progress[0].current_content_type : null,
                            lecture_progress_status: lecture_progress_status,
                        }
                    })
                })
        },
        calculateLectureProgress(lecture_progress){
            //1['Completed'], 3['Late'], 2['Absent]

            if(lecture_progress.completed == 1 && lecture_progress.late == 1)
                return 3
            else if(lecture_progress.completed == 1 && lecture_progress.late == 0)
                return 1
            // else if(lecture_progress.completed == 0 && lecture_progress.late == 0)
            //     return 2

            return ''
        },
        closeModal(){
            this.showModal = false
        },
        show() {
            this.loadData()
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
