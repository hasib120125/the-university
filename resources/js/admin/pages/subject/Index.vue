<template>
    <div>
        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-body">
                        <router-link :to="{ name: 'subject_add' }" class="btn btn_info">{{ trans('admin.form.subject.add_new_subject') }}</router-link>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ trans('admin.form.subject.subject') }}</div>
                    </div>
                    <div class="card-body">
                        <table-component api-url="/api/admin/subjects"
                                         :fields="fields"
                                         ref="tableComponent"
                                         :sort-order="sortOrder"
                                         @delete="deleteItem"
                                         @clone="openCloneModal"
                                         @changeStatus="changeStatus"
                                         >
                        </table-component>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal " :class="{ 'open_modal': showCloneModal}"  data-modal="modal">
            <div class="modal_overlay" data-modal-close="modal" @click="closeModal"></div>
            <div class="modal_inner">
                <div class="modal_header">
                    <span data-modal-close="modal" class="close_icon close_icon_sm" @click="closeModal">×</span>
                    <h2>{{ trans('admin.label.clone')}}</h2>
                </div>
                <div class="modal_wrapper ">
                    <div class="modal_content modal_500p">
                        <div class="container">
                            <div class="row">
                                <div class="col_12">
                                    <div class="form-group ">
                                        <label>{{ trans('admin.form.subject.clone_source') }}</label>
                                        <select class="form_global"  v-model="clone.from_semester_id">
                                            <option value="">{{ trans('admin.form.subject.select_semester') }}</option>
                                            <option v-for="(semester, i) in semesters" :key="'semester_'+i" :value="semester.id"> {{ semester.name }} </option>
                                        </select>
                                        <div class="error-div" v-show="error.from_semester_id">
                                            <small class="text_danger">Semester Required</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col_12">
                                    <div class="form-group ">
                                        <label>{{ trans('admin.form.subject.clone_destination') }}</label>
                                        <select class="form_global"  v-model="clone.to_semester_id">
                                            <option value="">{{ trans('admin.form.subject.select_semester') }}</option>
                                            <option v-for="(semester, i) in semesters" :key="'semester_'+i" :value="semester.id"> {{ semester.name }} </option>
                                        </select>
                                        <div class="error-div" v-show="error.to_semester_id">
                                            <small class="text_danger">Semester Required</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col_12 d_flex_end mt_10">
                                    <button class="btn btn_md btn_success" @click.prevent="cloneSubject">{{ trans('admin.label.save') }}</button>
                                </div>
                            </div>
                        </div>
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
                    name: 'name',
                    title: this.trans('admin.form.subject.name'),
                    sortField: 'name',
                    searchable: true
                },
                {
                    name: 'code',
                    title: this.trans('admin.form.subject.code'),
                    sortField: 'code',
                    searchable: true
                },
                {
                    name: 'credit',
                    title: this.trans('admin.form.subject.credit'),
                    sortField: 'credit',
                    searchable: true
                },
                {
                    name: this.locale === 'en' ? 'professor.name_english' : 'professor.name_hangul',
                    title: this.trans('admin.form.subject.professor'),
                    sortField: this.locale === 'en' ? 'professor.name_english' : 'professor.name_hangul',
                    searchable: true
                },
                {
                    name: 'allDepartmentsName',
                    title: this.trans('admin.form.subject.department')
                },
                {
                    name: 'action-slot',
                    title: this.trans('admin.label.action'),
                    searchable: false,
                    data: [
                        {
                            class: 'btn btn_sm btn_danger mr_5',
                            title: '<i class="fas fa-check"></i>',
                            tooltip: this.trans('admin.label.active'),
                            action: 'changeStatus',
                            condition: ["status", 0],
                        },
                        {
                            class: 'btn btn_sm btn_success mr_5',
                            title: '<i class="fas fa-check"></i>',
                            tooltip: this.trans('admin.label.deactivate'),
                            action: 'changeStatus',
                            condition: ["status", 1],
                        },
                        {
                            class: 'btn btn_sm btn_info mr_5',
                            title: '<i class="fas fa-clone"></i>',
                            tooltip: this.trans('admin.label.clone'),
                            action: 'clone'
                        },
                        {
                            class: 'btn btn_sm btn_success mr_5',
                            title: '<i class="fas fa-eye"></i>',
                            tooltip: this.trans('admin.label.view'),
                            route: 'subject_overview',
                            params: {id: 'id'}
                        },
                        {
                            class: 'btn btn_sm btn_info mr_5',
                            title: '<i class="far fa-edit"></i>',
                            tooltip: this.trans('admin.label.edit'),
                            route: 'subject_edit',
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
                    field: 'name',
                    direction: 'asc'
                }
            ],
            semesters: [],
            showCloneModal: false,
            clone: {
                subject_id: null,
                from_semester_id: '',
                to_semester_id: '',
            },
            error: {
                from_semester_id: false,
                to_semester_id: false,
            },
        }
    },
    created(){
        axios.get('/api/admin/semesters')
                    .then((response) => {
                        this.semesters = response.data.data;
                    })
    },
    methods: {
        changeStatus(subject){
            this.$swal({
                title: subject.status == 1 ? this.trans('admin.label.deactivate_confirmation') : this.trans('admin.label.active_confirmation'),
                text: this.trans('admin.label.warning'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: subject.status == 1 ? this.trans('admin.label.yes_deactivate') : this.trans('admin.label.yes_activate'),
                cancelButtonText: this.trans('admin.label.no_cancel'),
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.patch(`/api/admin/subjects/${subject.id}/status-change`).then(() => {
                        this.$refs.tableComponent.refresh();
                        this.$swal.fire(
                            subject.status == 1 ? this.trans('common.message.deactivated') : this.trans('common.message.activated'),
                            this.trans('common.message.status_change'),
                            'success'
                        )
                    });
                }
            });
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
                    axios.delete('/api/admin/subjects/'+item.id).then(() => {
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
        openCloneModal(subject){
            this.showCloneModal = true
            this.clone.subject_id = subject.id
        },
        closeModal(){
            this.showCloneModal = false
            this.clone ={
                subject_id: null,
                from_semester_id: '',
                to_semester_id: '',
            }
        },
        cloneSubject() {
            this.error = {
                from_semester_id: false,
                to_semester_id: false,
            }

            if(!this.clone.from_semester_id){
                this.error.from_semester_id = true
                return
            }

            if(!this.clone.to_semester_id){
                this.error.to_semester_id = true
                return
            }

            this.$swal({
                title: this.trans('admin.label.clone_confirmation'),
                text: this.trans('admin.label.warning'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: this.trans('admin.label.yes_clone'),
                cancelButtonText: this.trans('admin.label.no_cancel'),
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/api/admin/subjects/'+ this.clone.subject_id + '/clone', this.clone).then(() => {
                        this.$refs.tableComponent.refresh();
                        this.closeModal()
                        this.$swal.fire(
                            this.trans('common.message.cloned'),
                            this.trans('common.message.clone_message'),
                            'success'
                        )
                    });
                }
            });
        }
    }
}
</script>
<style scoped>
.error-div {
    width: 100%;
}

.error-div small {
    color: red;
}
</style>
