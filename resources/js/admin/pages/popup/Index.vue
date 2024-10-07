<template>
    <div>
        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-body">
                        <router-link :to="{ name: 'popup_add' }" class="btn btn_info">{{ trans('admin.form.popup.popup_add') }}</router-link>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ trans('admin.form.popup.popup') }}</div>
                    </div>
                    <div class="card-body">
                        <table-component api-url="/api/admin/popup"
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
                    name: 'title',
                    title: this.trans('admin.form.popup.title'),
                    sortField: 'title',
                    searchable: true
                },
                {
                    name: 'top',
                    title: this.trans('admin.form.popup.top'),
                    sortField: 'top',
                    searchable: true
                },
                {
                    name: 'left',
                    title: this.trans('admin.form.popup.left'),
                    sortField: 'left',
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
                            route: 'popup_edit',
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
                    axios.delete('/api/admin/popup/'+item.id).then(() => {
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

