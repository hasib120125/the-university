<template>
    <div>
        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title width_full">
                            <div class="d_flex_btwn">
                                <div>{{ trans('admin.form.gallery.page_heading') }}</div>
                                <router-link :to="{ name: 'galleries_add' }" class="btn btn_info">{{ trans('admin.form.gallery.add_new') }}</router-link>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table-component api-url="/api/admin/galleries"
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
            galleries: [],
            fields: [
                {
                    name: 'name_en',
                    title: this.trans('admin.form.gallery.name_en'),
                    sortField: 'name_en',
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
                            route: 'galleries_edit',
                            params: {id: 'id'}
                        },
                        {
                            class: 'btn btn_sm btn_success mr_5',
                            title: '<i class="fas fa-eye"></i>',
                            tooltip: this.trans('admin.label.view'),
                            route: 'galleries_view',
                            params: {id: 'id'}
                        },
                        {
                            class: 'btn btn_sm btn_danger',
                            title: '<i class="far fa-trash-alt"></i>',
                            tooltip: this.trans('admin.label.delete'),
                            action: 'delete'
                        },
                    ]
                }
            ],
            sortOrder: [
                {
                    field: 'created_at',
                    direction: 'desc'
                }
            ]
        }
    },
    created() {
        this.getGallery();
    },
    methods: {
        getGallery(){

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
                    axios.delete('/api/admin/galleries/'+item.id).then(() => {
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
