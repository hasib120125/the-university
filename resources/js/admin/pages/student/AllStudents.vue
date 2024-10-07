<template>
    <div>
        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-body">
                        <div class="d_flex_btwn">
                            <router-link :to="{ name: 'students_add' }" class="btn btn_info">{{ trans('admin.form.student.add_new_student') }}</router-link>

                            <div class="form_row_inline">
                                <label class="width_260p">Select Semester</label>
                                <select class="form_global " v-model="semester_id">
                                    <option value="">All Semester</option>
                                    <option :value="semester.id" v-for="(semester, index) in semesters" :key="'semester_'+index">{{ semester.year+ ' - '+semester.season_name }}</option>
                                </select>

                                <button class="btn btn_info ml_20" @click.prevent="exportGrade">Export Grade</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ trans('admin.form.student.student') }}</div>
                    </div>
                    <div class="card-body">
                        <table-component api-url="/api/admin/all-students"
                                         :fields="fields"
                                         ref="tableComponent"
                                         :sort-order="sortOrder"
                                         @certificate="generateCertificate"
                                         @transcript="generateTranscript"
                                         >
                        </table-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TableComponent from "./../../components/TableComponent";
export default {
    components: {
        TableComponent
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
                            params: {id: 'id'},
                        },
                        {
                            class: 'btn btn_sm btn_success mr_5',
                            title: '<i class="fas fa-certificate"></i>',
                            tooltip: this.trans('common.index.certificate'),
                            action: 'certificate',
                            condition: ['show_transcript', 1]
                        },
                        {
                            class: 'btn btn_sm btn_success mr_5',
                            title: '<i class="fas fa-sticky-note"></i>',
                            tooltip: this.trans('common.index.transcript'),
                            action: 'transcript',
                            condition: ['show_transcript', 1]
                        },
                        {
                            class: 'btn btn_sm btn_info mr_5',
                            title: '<i class="fas fa-poll"></i>',
                            tooltip: this.trans('common.index.result'),
                            route: 'student_result',
                            params: {student_id: 'id'},
                            condition: ['active', 1]
                        },
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
            semesters: [],
            semester_id: ''
        }
    },
    created() {
        axios.get('/api/admin/semesters').then((response) => {
            this.semesters = response.data.data

            axios.get('/api/admin/setting').then((settingResponse) => {
                if (settingResponse.data.data.length && settingResponse.data.data[0].current_semester_id) {
                    this.semester_id = settingResponse.data.data[0].current_semester_id.id
                }
            })
        })
    },
    methods: {
        generateCertificate(student){
            axios({
                url: '/api/admin/generate-certificate/' + student.id,
                method: 'GET',
                responseType: 'blob',
            }).then((response) => {
                var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                var fileLink = document.createElement('a');
                fileLink.href = fileURL;
                fileLink.setAttribute('download', student.name + '-certificate.pdf');
                document.body.appendChild(fileLink);

                fileLink.click();
            });
        },
        generateTranscript(student){
            axios({
                url: '/api/admin/generate-transcript/' + student.id,
                method: 'GET',
                responseType: 'blob',
            }).then((response) => {
                var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                var fileLink = document.createElement('a');
                fileLink.href = fileURL;
                fileLink.setAttribute('download', student.name + '-transcript.pdf');
                document.body.appendChild(fileLink);

                fileLink.click();
            });
        },
        exportGrade(){
            axios.get(`/api/admin/students/export-grade?semester_id=${this.semester_id}`, {
                responseType: 'blob',
            }).then((response) => {
                // let fileURL = window.URL.createObjectURL(new Blob([response.data]));
                // let fileLink = document.createElement('a');
                // fileLink.href = fileURL;
                // fileLink.setAttribute('download',  'grade.xlsx');
                // document.body.appendChild(fileLink);
                //
                // fileLink.click();
            });
        }
    }
}
</script>

