<template>
    <div class="lecture_area custom_p_40">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 mb_15">
                    <div class="card">
                        <div class="card_header">
                            <div class="card_title width_full">
                                <div class="d_flex_btwn" v-if="student">
                                    <div>{{ trans('new.index.available_credit') }} - {{ student.available_credit }}
                                        <!-- <button class="btn btn_sm btn_success" @click="printCertificate">Print Certificate</button> -->
                                    </div>
                                    <router-link type="button" class="btn btn_info" :to="{name: 'apply_new_subject'}">{{ trans('new.index.apply_new_subject_new') }}</router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb_15">
                    <div class="card">
                        <div class="card_body">
                            <table-component :api-url="'/api/student/subjects'"
                                             :fields="fields"
                                             ref="tableComponent"
                                             :sort-order="sortOrder"
                                             @delete="deleteItem">
                            </table-component>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d_none">
            <form id="print-certificate"  action="/api/student/print-certificate" method="get">

            </form>
        </div>
    </div>
</template>

<script>
import TableComponent from "../../components/TableComponent";

export default {
    components: { TableComponent },
    data() {
        return {
            fields: [
                {
                    name: 'subject.name',
                    title: this.trans('new.index.name'),
                    sortField: 'subject.name',
                    sortable: true,
                    searchable: true
                },
                {
                    name: 'subject.code',
                    title: this.trans('new.index.code'),
                    sortField: 'subject.code',
                    sortable: true,
                    searchable: true
                },
                {
                    name: 'subject.credit',
                    title: this.trans('new.index.credit'),
                    sortField: 'subject.credit',
                    sortable: true,
                    searchable: true
                },
                {
                    name: 'subject.allDepartmentsName',
                    title: this.trans('new.index.departments')
                },
                {
                    name: 'semester',
                    title: this.trans('new.index.semester'),
                    formatter: this.semesterFullName,
                },
                {
                    name: this.locale === 'en' ? 'subject.professor.name_english' : 'subject.professor.name_hangul',
                    title: this.trans('new.index.professor'),
                    sortField: this.locale === 'en' ? 'subject.professor.name_english' : 'subject.professor.name_hangul',
                    sortable: true,
                    searchable: true
                },
                {
                    name: 'action-slot',
                    title: this.trans('new.index.action'),
                    searchable: false,
                    data: [
                        {
                            class: 'btn btn_sm btn_danger mr_5',
                            title: '<i class="far fa-trash-alt"></i>',
                            tooltip: this.trans('student.label.delete'),
                            condition: ["deleteAble", true],
                            action: 'delete'
                        },
                        {
                            class: 'btn btn_sm btn_blue mr_5',
                            title:  '<i class="fas fa-play"></i>',
                            tooltip:  this.trans('new.index.details'),
                            route: 'subject_overview',
                            params: {id: 'id'}
                        }
                    ]
                }
            ],
            sortOrder: [
                {
                    field: 'semester.year',
                    direction: 'desc'
                }
            ],
            student: null,
        }
    },
    created(){
        this.getStudentData()
    },
    methods:{
        getStudentData(){
            axios.get('/api/student/profile')
                .then((response) => {
                    this.student = response.data.data;
                })
        },
        semesterFullName(semester){
            if(semester){
                return semester.year + '-' + semester.season_name
            }
            return ''
        },
        printCertificate(){
            document.getElementById('print-certificate').submit()
        },
        deleteItem(item) {
            this.$swal({
                title: this.trans('student.label.delete_confirmation'),
                text: this.trans('student.label.warning'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: this.trans('student.label.yes_delete'),
                cancelButtonText: this.trans('student.label.no_cancel'),
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/api/student/subjects/'+ item.id).then(() => {
                        this.getStudentData()
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
