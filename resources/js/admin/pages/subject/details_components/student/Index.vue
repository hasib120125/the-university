<template>
    <div>
        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-body">
                        <button :to="{ name: 'students_add' }" class="btn btn_info" @click="addStudent">{{ trans('admin.form.student.add_new_student') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-header d_flex_btwn width_full">
                        <div class="card-title">{{ trans('admin.form.student.student') }}</div>
                    </div>
                    <div :class="['card-body', {'loading_overlay': loading}]">
                        <table-component :api-url="'/api/admin/subjects/'+ $route.params.id +'/students/' + $route.params.semester_id"
                                         :fields="fields"
                                         ref="tableComponent"
                                         :sort-order="sortOrder"
                                         @delete="deleteItem"
                                         @showAttendanceModal="showAttendanceModal"
                                         >
                        </table-component>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal " :class="{ 'open_modal': studentAddModalShow}"  data-modal="modal">
            <div class="modal_overlay" data-modal-close="modal" @click="closeModal"></div>
            <div class="modal_inner">
                <div class="modal_header">
                    <span data-modal-close="modal" class="close_icon close_icon_sm" @click="closeModal">×</span>
                    <h2>{{ trans('admin.form.student.add_new_student')}}</h2>
                </div>
                <div class="modal_wrapper ">
                    <div class="modal_content modal_500p">
                        <div class="container">
                            <div class="row">
                                <div class="col_12">
                                    <div class="form-group ">
                                        <label>{{ trans('admin.form.subject.student') }}</label>
                                        <multiselect v-model="selectedStudent" :allow-empty="false" :options="students" track-by="id" label="name"
                                        :placeholder="trans('admin.form.subject.select_student')" open-direction="bottom">
                                            <template slot="singleLabel" slot-scope="{ option }">{{ option.name }}</template>
                                        </multiselect>
                                        <v-errors :errors="errorFor('student_id')"></v-errors>
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
        <AttendanceModal ref="attendanceModal" :studentData="studentData"/>
    </div>
</template>

<script>
import TableComponent from "./../../../../components/TableComponent";
import validationErrors from "../../../../mixins/validationErrors";
import AttendanceModal from "./../../../../components/AttendanceModal.vue"
import Multiselect from "vue-multiselect"


export default {
    mixins: [validationErrors],
    components: {
        TableComponent,
        Multiselect,
        AttendanceModal
    },
    data() {
        return {
            fields: [
                {
                    name: 'student_no',
                    title: this.trans('admin.form.student.student_no'),
                    sortField: 'student_no',
                    searchable: true
                },
                {
                    name: 'name',
                    title: this.trans('admin.form.active_students.name'),
                    sortField: this.locale === 'en' ? 'name_english' : 'name_hangul',
                    searchable: true
                },
                {
                    name: 'department.name',
                    title: this.trans('admin.form.department.department'),
                    sortField: 'department.name',
                    searchable: true
                },
                {
                    name: 'semester',
                    title: this.trans('admin.form.semester.semester'),
                    sortable: false,
                    searchable: false,
                    formatter (value) {
                        if(value){
                            return value.year + ' - ' + value.season_name
                        }
                        return ''
                    }
                },
                {
                    name: 'status_text',
                    title: this.trans('admin.form.student.state'),
                    sortField: 'status_text'
                },
                {
                    name: 'email',
                    title: this.trans('admin.form.student.email'),
                    sortField: 'email',
                    searchable: true
                },
                {
                    name: 'mobile',
                    title: this.trans('admin.form.student.contact'),
                    sortField: 'mobile',
                    searchable: true
                },
                 {
                    name: 'action-slot',
                    title: this.trans('admin.label.action'),
                    searchable: false,
                    data: [
                        {
                            class: 'btn btn_sm btn_danger mr_5',
                            title: '<i class="far fa-trash-alt"></i>',
                            tooltip: this.trans('admin.label.delete'),
                            action: 'delete'
                        },
                        {
                            class: 'btn btn_sm btn_info mr_5',
                            title: this.trans('admin.form.attendance.title'),
                            action: 'showAttendanceModal'
                        }
                    ]
                }

            ],
            sortOrder: [],
            loading : false,
            studentAddModalShow : false,
            students : [],
            selectedStudent : '',
            form:{
                student_id : '',
                semester_id : this.$route.params.semester_id,
                subject_id : this.$route.params.id,
            },
            studentData:{
                student_id: null,
                semester_id : this.$route.params.semester_id,
                subject_id : this.$route.params.id,
            },
        }
    },
    created(){
        axios.get(`/api/admin/subjects/${this.$route.params.id}/all-except-current-students/${this.$route.params.semester_id}`)
            .then((response) => {
                this.students = response.data.data;
            })
    },
    methods: {
        showAttendanceModal(student){
            this.studentData.student_id = student.id
            setTimeout(() => {
                this.$refs.attendanceModal.show();
            }, 200);
        },
        addStudent(){
            this.studentAddModalShow = true
        },
        closeModal(){
            this.selectedStudent = ''
            this.studentAddModalShow = false
        },
        submitForm(){
            this.form.student_id = this.selectedStudent.id
            axios.post('/api/admin/subjects/add-student', this.form)
                    .then((response) => {
                        if(response.data.error === 'subject_full'){
                            this.$swal.fire(
                                this.trans('common.message.error'),
                                response.data.message,
                                'error'
                            )
                        }else{
                            this.$refs.tableComponent.refresh();
                            this.closeModal()
                            this.$swal.fire(
                                this.trans('admin.label.success'),
                                response.data.message,
                                'success'
                            )
                        }
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);
        },
        deleteItem(item) {
            this.$swal({
                title: this.trans('admin.label.delete_confirmation'),
                text: this.trans('admin.label.warning'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: this.trans('admin.label.yes_delete'),
                cancelButtonText: this.trans('admin.label.no_cancel'),
                reverseButtons: true
            }).then((result) => {
                let form = {
                    student_id : item.id,
                    semester_id : this.$route.params.semester_id,
                    subject_id : this.$route.params.id,
                }
                if (result.isConfirmed) {
                    axios.post('/api/admin/students/remove-subject', form ).then(() => {
                        this.$refs.tableComponent.refresh();
                        this.$swal.fire(
                            this.trans('common.message.deleted'),
                            this.trans('common.message.delete_message'),
                            'success'
                        )
                    });
                }
            });
        }
    }
}
</script>

