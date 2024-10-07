<template>
    <div class="lecture_area custom_p_40">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 mb_15">
                    <div class="card">
                        <div class="card_header">
                            <div class="card_title width_full">
                                <div class="d_flex_btwn">
                                    <div>{{ trans('new.index.per_credit_fee') }} - {{ perCreditCost }}₩</div>
                                    <router-link class="btn btn_info" :to="{name: 'add_payments'}">{{ trans('new.index.add_new_payment') }}</router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb_15">
                    <div class="card">
                        <div class="card_body">
                            <table-component :api-url="'/api/student/payments'"
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
import TableComponent from "../../components/TableComponent";

export default {
    components: { TableComponent },
    data() {
        return {
            subjects: [],
            fields: [
                {
                    name: 'amount',
                    title: this. trans('new.index.amount'),
                    sortField: 'amount',
                    sortable: true,
                    searchable: true
                },
                {
                    name: 'note',
                    title: this. trans('new.index.note'),
                    sortField: 'note',
                    sortable: true,
                    searchable: true
                },
                {
                    name: 'created_at',
                    title: this. trans('new.index.created_at'),
                    sortField: 'created_at',
                    sortable: true,
                    searchable: true
                },
                {
                    name: 'status_text',
                    title: this. trans('new.index.status'),
                    sortField: 'status_text',
                    sortable: true,
                    searchable: true
                },
            ],
            sortOrder: [],
            perCreditCost: 0
        }
    },
    created(){
        axios.get('/api/student/payments/creditCost')
                .then((response) => {
                    this.perCreditCost = response.data.data.credit_rate
                })
    }
}
</script>
