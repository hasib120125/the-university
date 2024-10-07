<template>
    <div>
        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-body">
                        <router-link :to="{ name: 'students_add' }" class="btn btn_info">{{ trans('admin.form.student.add_new_student') }}</router-link>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-header d_flex_btwn width_full">
                        <div class="card-title">{{ trans('common.index.active') }} - {{ trans('admin.form.student.student') }}</div>

                        <div class="d_flex_center">
                            <button class="btn btn_success mr_10" @click="exportStudent">
                                <i class="fas fa-file-export mr_5"></i> {{ trans('admin.form.student.export_student') }}
                            </button>
                            <div class="custom_upload">
                                <button class="btn btn_success"><span class="mr_5"><i class="fas fa-file-import"></i></span> {{ trans('admin.form.student.import_student') }}</button>
                                <input type="file" name="upload_file" id="importStudents" accept=".xlsx, .csv,text/csv, application/excel, application/vnd.ms-excel, application/vnd.msexce" @change="importStudents" />
                            </div>
                        </div>
                    </div>
                    <div :class="['card-body', {'loading_overlay': loading}]">
                        <table-component api-url="/api/admin/active-students"
                                         :fields="fields"
                                         ref="tableComponent"
                                         :sort-order="sortOrder"
                                         @delete="deleteItem"
                                         @showCreditModal="showCreditModal"
                                         @showSubjectModal="showSubjectModal"
                                         >
                        </table-component>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal " :class="{ 'open_modal': creditModalShow}"  data-modal="modal">
            <div class="modal_overlay" data-modal-close="modal" @click="closeModal"></div>
            <div class="modal_inner">
                <div class="modal_header">
                    <span data-modal-close="modal" class="close_icon close_icon_sm" @click="closeModal">×</span>
                    <h2>{{ trans('admin.form.student.give_credit')}} - {{selectedStudent.available_credit}}</h2>
                </div>
                <div class="modal_wrapper ">
                    <div class="modal_content modal_500p">
                        <div class="container">
                            <div class="row">
                                <div class="col_12">
                                    <div class="form-group ">
                                        <label>{{ trans('admin.form.student.credit') }}</label>
                                        <input type="text" class="form_global"  v-model="form.credit">
                                        <v-errors :errors="errorFor('credit')"></v-errors>
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

        <SubjectModal ref="subjectModal" :student_id="selectedStudentId"/>
    </div>
</template>

<script>
import TableComponent from "./../../components/TableComponent";
import validationErrors from "../../../admin/mixins/validationErrors";
import SubjectModal from "./SubjectModal.vue"


export default {
    mixins: [validationErrors],
    components: {
        TableComponent,
        SubjectModal
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
                    name: this.locale === 'en' ? 'name_english' : 'name_hangul',
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
                            class: 'btn btn_sm btn_success mr_5',
                            title: '<i class="fas fa-book-open"></i>',
                            tooltip: this.trans('admin.form.subject.subject'),
                            action: 'showSubjectModal'
                        },
                        {
                            class: 'btn btn_sm btn_info mr_5',
                            title: '<i class="fas fa-hand-holding-usd"></i>',
                            tooltip: this.trans('admin.form.student.give_credit'),
                            action: 'showCreditModal'
                        },
                        {
                            class: 'btn btn_sm btn_success mr_5',
                            title: '<i class="fas fa-eye"></i>',
                            tooltip: this.trans('admin.label.details'),
                            route: 'student_details',
                            params: {id: 'id'}
                        },
                        {
                            class: 'btn btn_sm btn_info mr_5',
                            title: '<i class="far fa-edit"></i>',
                            tooltip: this.trans('admin.label.edit'),
                            route: 'students_edit',
                            params: {id: 'id'}
                        },
                        {
                            class: 'btn btn_sm btn_danger',
                            title: '<i class="far fa-trash-alt"></i>',
                            tooltip: this.trans('admin.label.delete'),
                            action: 'delete'
                        }
                    ]
                }
            ],
            sortOrder: [
                {
                    direction: 'desc', 
                    field: 'created_at', 
                    sortField: 'created_at', 
                }
            ],
            loading : false,
            creditModalShow : false,
            form: {
                student_id: null,
                credit: 0
            },
            selectedStudent: {},
            selectedStudentId: 0,
        }
    },
    methods: {
        showSubjectModal(student){
            this.selectedStudentId = student.id
            setTimeout(() => {
                this.$refs.subjectModal.show();
            }, 200);
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
                if (result.isConfirmed) {
                    axios.delete('/api/admin/students/'+item.id).then(() => {
                        this.$refs.tableComponent.refresh();
                        this.$swal.fire(
                            this.trans('common.message.deleted'),
                            this.trans('common.message.delete_message'),
                            'success'
                        )
                    });
                }
            });
        },
        async importStudents(e) {
            if (await this.checkFileTypeExcel() == false) {
                document.getElementById("importStudents").value = null;
                return
            }

            if (await this.takeConfirmation() == false) {
                document.getElementById("importStudents").value = null;
                return
            }

            let formData = new FormData()

            formData.append('file', e.target.files[0]);

            this.loading = true
            axios.post('/api/admin/students/import', formData).then((response) => {
                this.$refs.tableComponent.refresh();
                this.$swal.fire(
                    this.trans('common.message.success'),
                    response.data.message,
                    'success'
                )

            })
            .catch((err) => {
                this.$swal.fire(
                    this.trans('common.message.error'),
                    this.trans('common.message.something_wrong'),
                    'error'
                )
            })
            .finally(() => this.loading = false);

            document.getElementById("importStudents").value = null;
            return
        },
        async takeConfirmation(){
            let confirm = false
            await this.$swal({
                title: this.trans('admin.label.import_confirmation'),
                text: this.trans('admin.label.warning'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: this.trans('admin.label.yes_import'),
                cancelButtonText: this.trans('admin.label.no_cancel'),
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    confirm = true
                }
            })

            return confirm
        },
        checkFileTypeExcel() {
            let validExts = new Array(".xlsx", ".xls", ".csv")
            let fileExt = document.getElementById("importStudents").value

            fileExt = fileExt.substring(fileExt.lastIndexOf('.'))
            if (validExts.indexOf(fileExt) < 0) {
                toast.fire({
                    icon: 'error',
                    title: "Invalid file selected, valid files are of " + validExts.toString() + " types."
                })
                return false;
            }
            else return true;
        },
        showCreditModal(student){
            this.selectedStudent = student
            this.form.student_id = student.id
            this.creditModalShow = true
        },
        closeModal(){
            this.form = {
                student_id: null,
                credit: 0
            }
            this.creditModalShow = false
        },
        submitForm(){
            axios.post(`/api/admin/students/${this.form.student_id}/give-credit`, this.form)
                    .then((response) => {
                        this.$refs.tableComponent.refresh();
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
        exportStudent(){
            axios({
                url: '/api/admin/students/export',
                method: 'GET',
                responseType: 'blob',
            }).then((response) => {
                var a = document.createElement("a");
                document.body.appendChild(a);
                a.style = "display: none"
                var json = response.data,
                    blob = new Blob([json], {type: "octet/stream"}),
                    url = window.URL.createObjectURL(blob);
                a.href = url;
                a.download = 'students.xlsx';
                a.click();
                window.URL.revokeObjectURL(url);
            });
        }
    }
}
</script>

