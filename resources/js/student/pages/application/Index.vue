<template>
    <div class="profile custom_p_40">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class=" d_flex_btwn width_full">
                                <span>{{ trans('new.index.applications') }}</span>
                                <router-link :to="{ name: 'applications_add' }" class="btn btn_info">{{ trans('new.index.add_new_application') }}</router-link>
                            </div>
                        </div>
                        <div class="card_body">
                            <table-component api-url="/api/student/applications"
                                            :fields="fields"
                                            ref="tableComponent"
                                            :sort-order="sortOrder">
                            </table-component>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TableComponent from "./../../components/TableComponent.vue";

export default {
    components: {
        TableComponent
    },
    data() {
        return {
            fields: [
                {
                    name: 'subject',
                    title: this.trans('new.index.subject'),
                    sortField: 'subject',
                    searchable: true
                },
                {
                    name: 'attachments',
                    title: this.trans('new.index.attachment'),
                    searchable: false,
                    formatter: this.attachmentFormatter
                },
                {
                    name: 'status_name',
                    title: this.trans('new.index.status'),
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
                attachmentLink += `<a href="${attachment.file}" download="${attachment.file_name}"><i class="fas fa-download"></i> ${attachment.file_name}</a> <br>`
                i++
            })

            return attachmentLink
        }
    }
}
</script>
