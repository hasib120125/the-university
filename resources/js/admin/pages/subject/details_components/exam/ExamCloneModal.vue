<template>
    <div class="modal " :class="{ 'open_modal': showModal}" data-modal="modal">
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
                            <div class="col_12">
                                <div class="form_row_inline">
                                    <label>{{ trans('admin.form.bulk_upload.semester') }}</label>
                                    <select class="form_global" v-model="semester_id">
                                        <option value="">{{ trans('admin.form.bulk_upload.select_semester') }}</option>
                                        <option v-for="(semester, i) in semesters" :key="'semester_'+i" :value="semester.id">
                                            {{ semester.year }} - {{ semester.season_name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col_12 d_flex_end mt_10">
                                <button class="btn btn_md btn_success" :disabled="semester_id == ''" @click.prevent="submitForm">{{ this.trans('admin.label.clone') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    props: {
        examId: {
            type: Number,
            required: true
        },
    },
    components: {
        
    },
    data() {
        return {
            semesters: [],
            showModal: false,
            semester_id: ''
        }
    },
    mounted(){
        
    },
    methods: {
        loadData(){
            this.semester_id = ''
            axios.get(`/api/admin/semesters`)
                .then((response) => this.semesters = response.data.data)
        },
        closeModal(val = false){
            this.showModal = false
            this.$emit('valueChanged', val)
        },
        show() {
            this.loadData()
            this.showModal = true
        },
        submitForm(){
            axios.post(`/api/admin/subject-exams/${this.examId}/semesters/${this.semester_id}`)
                    .then((response) => {
                        this.closeModal(true)
                        this.$swal.fire(
                            this.trans('common.message.cloned'),
                            this.trans('common.message.clone_message'),
                            'success'
                        )
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);
        },
    }
}
</script>