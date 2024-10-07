<template>
    <div>
        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-body">
                        <router-link :to="{ name: 'lectures_add', params:{semester_id: $route.params.semester_id} }" class="btn btn_info">{{ trans('professor.form.lecture.add_new_lecture') }}</router-link>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ trans('professor.form.lecture.lecture') }}</div>
                    </div>
                    <div class="card-body">
                        <table-component :api-url="'/api/professor/subjects/' + $route.params.id +'/lectures/' + $route.params.semester_id "
                                         :fields="fields"
                                         ref="tableComponent"
                                         :sort-order="sortOrder"
                                         @delete="deleteItem"
                                         @lectureView="lectureView">
                        </table-component>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal " :class="{ 'open_modal': showModal}"  data-modal="modal">
            <div class="modal_overlay" data-modal-close="modal" @click="closeModal"></div>
            <div class="modal_inner">
                <div class="modal_wrapper modal_1080p">
                    <div class="modal_content">
                        <div id="player"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TableComponent from "./../../../../components/TableComponent";

export default {
    components: {
        TableComponent
    },
    data() {
        return {
            showModal: false,
            fields: [
                {
                    name: 'name',
                    title: this.trans('professor.form.lecture.name'),
                    sortField: 'name',
                    searchable: true
                },
                {
                    name: this.locale === 'en' ? 'professor.name_english' : 'professor.name_hangul',
                    title: this.trans('professor.form.lecture.professor'),
                    sortField: this.locale === 'en' ? 'professor.name_english' : 'professor.name_hangul',
                    searchable: true
                },
                {
                    name: 'start_period',
                    title: this.trans('professor.form.lecture.start_period'),
                    sortField: 'start_period',
                    searchable: true
                },
                {
                    name: 'end_period',
                    title: this.trans('professor.form.lecture.end_period'),
                    sortField: 'end_period',
                    searchable: true
                },
                {
                    name: 'convert_status',
                    title: this.trans('professor.form.lecture.convert_status'),
                    sortField: 'convert_status',
                    searchable: true
                },
                {
                    name: 'action-slot',
                    title: this.trans('professor.label.action'),
                    searchable: false,
                    data: [
                        {
                            class: 'btn btn_sm btn_success mr_5',
                            title: this.trans('professor.label.view'),
                            action: 'lectureView',
                            condition: ['convert_status','convert_status' ]
                        },
                        {
                            class: 'btn btn_sm btn_info mr_5',
                            title: '<i class="far fa-edit"></i>',
                            tooltip: this.trans('admin.label.edit'),
                            route: 'lectures_edit',
                            params: {lecture_id: 'id', semister_id: this.$route.params.semester_id}
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
            sortOrder: []
        }
    },
    methods: {
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
                    axios.delete('/api/professor/lectures/'+item.id).then(() => {
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
        lectureView(item) {
            this.showModal = true
            setTimeout(() => {
                jwplayer("player").setup({
                    sources: [{
                        file: item.smil,
                    }],
                });
            }, 200);
        },
        closeModal(){
            setTimeout(() => {
                jwplayer("player").stop()
            }, 100);
            this.showModal = false
        }
    }
}
</script>
