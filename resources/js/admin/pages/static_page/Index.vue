<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ trans('admin.form.static_pages.static_pages') }}</div>
                </div>
                <div class="card-body">
                    <table-component api-url="/api/admin/static-pages"
                                     :fields="fields"
                                     ref="tableComponent"
                                     :sort-order="sortOrder">
                    </table-component>
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
                    name: 'title_en',
                    title: this.trans('admin.form.pages.title_en'),
                    sortField: 'title_en',
                    searchable: true
                },
                {
                    name: 'title_ko',
                    title: this.trans('admin.form.pages.title_ko'),
                    sortField: 'title_ko',
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
                            route: 'static_pages_edit',
                            params: {id: 'id'}
                        },
                    ]
                }
            ],
            sortOrder: []
        }
    }
}
</script>

