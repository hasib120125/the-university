<template>
    <div>
        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ trans('admin.form.payment.approved_payments') }}</div>
                    </div>
                    <div class="card-body">
                        <table-component api-url="/api/admin/payments/approved"
                                         :fields="fields"
                                         ref="tableComponent"
                                         :sort-order="sortOrder">
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
                    name: 'payment.payment_id',
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
                    name: this.locale === 'en' ? 'student.name_english' : 'student.name_hangul',
                    title: this.trans('admin.form.payment.student_name'),
                    sortField: this.locale === 'en' ? 'student.name_english' : 'student.name_hangul',
                    searchable: true
                },
                {
                    name: 'payment.amount',
                    title: this.trans('admin.form.payment.amount'),
                    sortField: 'payment.amount',
                    searchable: true
                },
                {
                    name: 'per_credit_rate',
                    title: this.trans('admin.form.payment.per_credit_rate'),
                    sortField: 'per_credit_rate',
                    searchable: true
                },
                {
                    name: 'credit',
                    title: this.trans('admin.form.payment.credit'),
                    sortField: 'credit',
                    searchable: true
                },
                {
                    name: 'created_at',
                    title: this.trans('admin.form.payment.created_at'),
                    sortField: 'created_at',
                    searchable: true
                }
            ],
            sortOrder: [
                {
                    field: 'created_at',
                    direction: 'desc'
                }
            ]
        }
    }
}
</script>

