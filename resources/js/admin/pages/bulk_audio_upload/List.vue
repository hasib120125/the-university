<template>
    <div>
        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ trans('admin.form.bulk_upload.audio_list') }}</div>
                    </div>
                    <div class="card-body">
                        <button class="btn btn_md btn_success" @click.prevent="checkFtp">Check FTP</button>

                        <table-component api-url="/api/admin/bulk-audio"
                                         :fields="fields"
                                         ref="tableComponent"
                                         :sort-order="sortOrder"
                                         @delete="deleteItem"
                                         @assign="openModal">
                        </table-component>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL CONTENT -->
        <div class="modal" :class="{'open_modal': open_modal === true}" data-modal="modal">
            <div class="modal_overlay" data-modal-close="modal" @click="closeModal"></div>
            <div class="modal_inner">
                <div class="modal_header">
                    <span data-modal-close="modal" class="close_icon close_icon_sm" @click="closeModal">×</span>
                    <h2>{{ trans('admin.form.bulk_upload.assign_audio_to_lecture') }}</h2>
                </div>
                <div class="modal_wrapper ">
                    <div class="modal_content modal_1080p">
                        <div class="container">
                            <div class="row">
                                <div class="col_4">
                                        <div class="form-group ">
                                            <label>{{ trans('admin.form.bulk_upload.subject') }}</label>
                                            <select class="form_global" v-model="form.subject_id" @change="loadLecture">
                                                <option value="">{{ trans('admin.form.bulk_upload.select_subject') }}</option>
                                                <option v-for="(subject, i) in subjects" :key="'subject_'+i" :value="subject.id">
                                                    {{ subject.name ? subject.name : '' }}
                                                </option>
                                            </select>
                                            <v-errors :errors="errorFor('subject_id')"></v-errors>
                                        </div>
                                    </div>
                                <div class="col_4">
                                        <div class="form-group ">
                                            <label>{{ trans('admin.form.bulk_upload.semester') }}</label>
                                            <select class="form_global" v-model="form.semester_id" @change="loadLecture">
                                                <option value="">{{ trans('admin.form.bulk_upload.select_semester') }}</option>
                                                <option v-for="(semester, i) in semesters" :key="'semester_'+i" :value="semester.id">
                                                    {{ semester.year }} - {{ semester.season_name }}
                                                </option>
                                            </select>
                                            <v-errors :errors="errorFor('semester_id')"></v-errors>
                                        </div>
                                    </div>
                                <div class="col_4">
                                        <div class="form-group ">
                                            <label>{{ trans('admin.form.bulk_upload.lecture') }}</label>
                                            <select class="form_global" v-model="form.lecture_id">
                                                <option value="">{{ trans('admin.form.bulk_upload.select_lecture') }}</option>
                                                <option v-for="(lecture, i) in lectures" :key="'lecture_'+i" :value="lecture.id">
                                                    {{ lecture.name ? lecture.name : '' }}
                                                </option>
                                            </select>
                                            <v-errors :errors="errorFor('lecture_id')"></v-errors>
                                        </div>
                                    </div>
                            </div>
                            <div class="d_flex_end">
                                    <button class="btn btn_secondary mr_5" @click="closeModal">{{ trans('admin.label.cancel') }}</button>
                                    <button class="btn btn_md btn_success" @click.prevent="assignAudioToLecture">{{ trans('admin.label.save') }}</button>
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
import validationErrors from "../../mixins/validationErrors";

export default {
    name: 'bulk-upload-list',
    mixins: [validationErrors],
    components: {
        TableComponent
    },
    data() {
        return {
            fields: [
                {
                    name: 'original_filename',
                    title: this.trans('admin.form.bulk_upload.file_name'),
                    searchable: true
                },
                {
                    name: 'action-slot',
                    title: this.trans('admin.label.action'),
                    searchable: false,
                    data: [
                        {
                            class: 'btn btn_sm btn_success mr_5',
                            title: '<i class="fas fa-link"></i>',
                            tooltip: this.trans('admin.label.assign'),
                            action: 'assign',
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
                    field: 'created_at',
                    direction: 'desc'
                }
            ],
            open_modal: false,
            subjects: [],
            semesters: [],
            lectures: [],
            bulkAudioId: null,
            form: {
                subject_id: '',
                semester_id: '',
                lecture_id: '',
            }
        }
    },
    methods: {
        checkFtp() {
            this.$swal({
                title: 'Check FTP',
                text: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: this.trans('admin.label.no_cancel'),
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/api/admin/check/ftp');
                }
            });
        },
        assignAudioToLecture(){
            axios.post(`/api/admin/bulk-audio/${this.bulkAudioId}/assign-audio-to-lecture`, this.form)
                    .then((response) => {
                        this.$refs.tableComponent.refresh();
                        this.$swal.fire(
                            this.trans('admin.label.success'),
                            this.trans('admin.label.successfully_assigned'),
                            'success'
                        )
                        this.closeModal()
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);
        },
        loadLecture(){
            this.lectures = [];
            this.form.lecture_id = '';

            if (this.form.subject_id && this.form.semester_id) {
                let subjectId = this.form.subject_id;
                let semesterId = this.form.semester_id;
                axios.get('/api/admin/load-lectures/', {params: {subjectId, semesterId}})
                    .then((response) => this.lectures = response.data.data);
            }
        },
        openModal(bulkAudio){
            this.form= {
                subject_id: '',
                semester_id: '',
                lecture_id: ''
            }

            axios.get('/api/admin/subjects')
                .then((response) => {
                    this.subjects = response.data.data
                })

            axios.get('/api/admin/semesters')
                .then((response) => {
                    this.semesters = response.data.data
                })

            this.open_modal = true
            this.bulkAudioId = bulkAudio.id
        },
        closeModal(){
            this.open_modal = false
            this.bulkAudioId = null
            this.subjects= []
            this.semesters= []
            this.lectures= []
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
                    axios.delete('/api/admin/bulk-audio/'+item.id).then(() => {
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

