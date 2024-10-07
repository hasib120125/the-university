<template>
    <div>
        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-body">
                        <router-link :to="{ name: 'faqs_add' }" class="btn btn_info">{{ trans('admin.form.faq.add_new_question') }}</router-link>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ trans('admin.form.faq.faq') }}</div>
                    </div>
                    <div class="card-body">
                        <table-component api-url="/api/admin/faqs"
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
import TableComponent from "./../../components/TableComponent";
export default {
    components: {
        TableComponent
    },
    data() {
        return {
            fields: [
                {
                    name: 'question',
                    title: this.trans('admin.form.faq.question'),
                    sortField: 'question',
                    searchable: true
                },
                {
                    name: 'answer',
                    title: this.trans('admin.form.faq.answer'),
                    sortField: 'answer',
                    searchable: true
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
                            route: 'faqs_edit',
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
                    axios.delete('/api/admin/faqs/'+item.id).then(() => {
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

