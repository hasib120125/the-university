<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title d_flex_btwn width_full">
                        <span>{{ trans('admin.form.application.pending_applications') }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <table-component api-url="/api/admin/applications/pending"
                                    :fields="fields"
                                    ref="tableComponent"
                                    :sort-order="sortOrder"
                                    @confirm="confirm"
                                    @reject="reject"
                                    >
                    </table-component>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TableComponent from "../../components/TableComponent.vue";

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
                },
                {
                    name: 'action-slot',
                    title: this.trans('admin.label.action'),
                    searchable: false,
                    data: [
                        {
                            class: 'btn btn_sm btn_info mr_5',
                            title: '<i class="fas fa-check"></i>',
                            tooltip: this.trans('admin.label.confirm'),
                            action: 'confirm',
                            condition: ["status", 1],
                        },
                        {
                            class: 'btn btn_sm btn_warning',
                            title: '<i class="fas fa-times"></i>',
                            tooltip: this.trans('admin.label.reject'),
                            action: 'reject',
                            condition: ["status", 1],
                        }
                    ]
                }
            ],
            sortOrder: [

            ]
        }
    },
    methods: {
        confirm(application){
            this.$swal({
                title: this.trans('admin.label.approve_confirmation'),
                text: this.trans('admin.label.warning'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: this.trans('admin.label.yes_approve'),
                cancelButtonText: this.trans('admin.label.no_cancel'),
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post(`/api/admin/applications/${application.id}/toggle-status`,{status: 2}).then(() => {
                        this.$refs.tableComponent.refresh();
                        this.$swal.fire(
                            this.trans('common.message.approved'),
                            this.trans('common.message.approve_message'),
                            'success'
                        )
                    });
                }
            });
        },
        reject(application){
            this.$swal({
                title: this.trans('admin.label.reject_confirmation'),
                text: this.trans('admin.label.warning'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: this.trans('admin.label.yes_reject'),
                cancelButtonText: this.trans('admin.label.no_cancel'),
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post(`/api/admin/applications/${application.id}/toggle-status`,{status: 3}).then(() => {
                        this.$refs.tableComponent.refresh();
                        this.$swal.fire(
                            this.trans('common.message.rejected'),
                            this.trans('common.message.reject_message'),
                            'success'
                        )
                    });
                }
            });
        },
        attachmentFormatter(attachments){
            let attachmentLink = ''
            let i = 1
            attachments.forEach(attachment => {
                attachmentLink += `<a href="${attachment.file}" download>${this.trans('common.index.attachment')} - ${i}</a> <br>`
                i++
            })

            return attachmentLink
        }
    }
}
</script>
