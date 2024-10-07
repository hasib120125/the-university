<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-body">
                    <table-component :api-url="'/api/admin/applications/' + $route.params.id"
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
import TableComponent from "./../../../components/TableComponent.vue";

export default {
    components: {
        TableComponent
    },
    data() {
        return {
            fields: [
                {
                    name: 'subject',
                    title: this.trans('admin.form.application.subject'),
                    sortField: 'subject',
                    searchable: true
                },
                {
                    name: 'attachments',
                    title: this.trans('admin.form.application.attachments'),
                    searchable: false,
                    formatter: this.attachmentFormatter
                },
                {
                    name: 'status_name',
                    title: this.trans('admin.form.application.status'),
                    searchable: false
                }
            ],
            sortOrder: [
                
            ]
        }
    },
    methods: {
        attachmentFormatter(attachments){
            let attachmentLink = ''
            let i = 1
            attachments.forEach(attachment => {
                attachmentLink += `<a href="${ attachment.file }" download="${ attachment.file_name }"> <i class="fas fa-download"></i> ${ attachment.file_name }</a> <br>`
                i++
            })

            return attachmentLink
        }
    }
}
</script>
