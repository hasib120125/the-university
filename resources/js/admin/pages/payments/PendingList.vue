<template>
    <div>
        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ trans('admin.form.payment.pending_payments') }}</div>
                    </div>
                    <div class="card-body">
                        <table-component api-url="/api/admin/payments/pending"
                                         :fields="fields"
                                         ref="tableComponent"
                                         :sort-order="sortOrder" @approve="approve">
                        </table-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TableComponent from "./../../components/TableComponent";
import {mapGetters} from "vuex";

export default {
    components: {
        TableComponent
    },
    computed: {
        ...mapGetters({
            locale: 'getLocale'
        }),
    },
    data() {
        return {
            fields: [
                {
                    name: 'payment_id',
                    title: this.trans('admin.form.payment.payment_id'),
                    sortField: 'payment_id',
                    searchable: true
                },
                {
                    name: 'student.student_no',
                    title: this.trans('admin.form.payment.student_id'),
                    sortField: 'student.student_no',
                    searchable: true
                },
                {
                    name: 'student.name',
                    title: this.trans('admin.form.payment.student_name'),
                    sortField: 'student.name',
                    searchable: true
                },
                {
                    name: 'amount',
                    title: this.trans('admin.form.payment.amount'),
                    sortField: 'amount',
                    searchable: true
                },
                {
                    name: 'note',
                    title: this.trans('admin.form.payment.note'),
                    sortField: 'note',
                    searchable: true
                },
                {
                    name: 'attachment',
                    title: this.trans('admin.form.payment.attachment'),
                    sortField: 'attachment',
                    searchable: false,
                    formatter (value) {
                        return value ? '<a href="'+value+'" download><i class="ti-download"></i></a>' : ''
                    }
                },
                {
                    name: 'created_at',
                    title: this.trans('admin.form.payment.created_at'),
                    sortField: 'created_at',
                    searchable: true
                },
                {
                    name: 'action-slot',
                    title: this.trans('admin.label.action'),
                    searchable: false,
                    data: [
                        {
                            class: 'btn btn_sm btn_success',
                            title: '<i class="fas fa-check"></i>',
                            tooltip: this.trans('admin.label.approve'),
                            action: 'approve'
                        }
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
    methods: {
        approve(item) {
            this.$swal({
                title: 'Approve',
                text: 'Are you sure want to approve?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Approve',
                cancelButtonText: this.trans('admin.label.no_cancel'),
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/api/admin/payments/approve/'+item.id).then(() => {
                        this.$refs.tableComponent.refresh();
                        this.$swal.fire(
                            'Approved',
                            'Payment has been approved.',
                            'success'
                        )
                    });
                }
            });
        }
    }
}
</script>

