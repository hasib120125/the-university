<template>
    <div>
        <div class="row" v-if="questions.added < questions.totalQuestion">
            <div class="col_12">
                <div class="card">
                    <div class="card-body">
                        <router-link :to="{ name: 'lecture_exam_question_add' }" class="btn btn_info"> {{  trans('admin.form.exam.question.add_question') }}</router-link>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-header">
                        <div class="col_10">
                            <div class="card-title">{{ trans('common.index.queations')}} (<span class="color_success">{{ trans('admin.form.exam.question.added')}} - {{ questions.added }} </span>, 
                            <span class="color_warning">{{ trans('admin.form.exam.question.remaining')}} - {{ questions.totalQuestion - questions.added }}</span> )</div>
                        </div>
                        <div class="col_2">
                            <div class="d_flex_end">
                                <router-link class="btn btn_sm btn_secondary mr_5" :to="{name: 'lecture_exams'}"> {{  trans('common.index.back') }} </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table-component :api-url="`/api/admin/lecture-exams/${$route.params.exam_id}/questions`"
                                         :fields="fields"
                                         ref="tableComponent"
                                         :sort-order="sortOrder" @delete="deleteItem">
                        </table-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TableComponent from "./../../../../../components/TableComponent";

export default {
    components: {
        TableComponent
    },
    data() {
        return {
            fields: [
                {
                    name: 'exam_title',
                    title: this.trans('admin.form.exam.exams'),
                    sortField: 'exam_title',
                    searchable: true
                },
                {
                    name: 'question_type',
                    title: this.trans('admin.form.exam.question.add_question'),
                    searchable: false,
                    sortable:false,
                    formatter (value) {
                        let question_type = ['OX type', 'Multiple choice', 'Short answer', 'Narrative']
                        return question_type[value - 1]
                    }
                },
                {
                    name: 'action-slot',
                    title: this.trans('admin.label.action'),
                    searchable: false,
                    data: [
                        {
                            class: 'btn btn_sm btn_info mr_5',
                            title: '<i class="far fa-edit"></i>',
                            tooltip: this.trans('admin.label.edit'),
                            route: 'lecture_exam_question_update',
                            params: {question_id: 'id'}
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
            sortOrder: [],
            questions:{
                added: 0,
                totalQuestion: 0
            }
        }
    },
    created() {
        this.questionStatistics()
    },
    methods: {
        questionStatistics(){
            axios.get(`/api/admin/exams/${this.$route.params.exam_id}/questionStatistics`)
            .then((response) => {
                this.questions = response.data
            })
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
                    axios.delete(`/api/admin/lecture-exams/${this.$route.params.exam_id}/questions/${item.id}`).then(() => {
                        this.$refs.tableComponent.refresh();
                        this.questionStatistics()
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
