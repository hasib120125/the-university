<template>
    <div class="container">
        <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card_title">
                        <div class="d_flex_btwn">
                            <div>{{ trans('new.index.add_payment') }}</div>
                            <div>
                                {{ trans('new.index.per_credit_fee') }} - {{ perCreditCost }}₩ ~~~
                                {{ trans('new.index.due_payments') }} - {{ duePayments }}₩
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('student.form.payment.type') }}</label>
                                <select class="form_global" id="department" v-model="form.type">
                                    <option value="1">{{ trans('student.form.payment.full_payment') }}</option>
                                    <option value="2">{{ trans('student.form.payment.partial_payment') }}</option>
                                    <option value="3">{{ trans('student.form.payment.due_payment') }}</option>
                                </select>
                                <v-errors :errors="errorFor('type')"></v-errors>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('new.index.amount') }}</label>
                                <input type="number" min="0" class="form_global" :placeholder=" trans('new.index.amount')" v-model="form.amount">
                                <v-errors :errors="errorFor('amount')"></v-errors>
                            </div>
                        </div>
                        <div class="col-md-6" v-if="form.type == 2">
                            <div class="form-group">
                                <label>{{ trans('new.index.credit') }}</label>
                                <input type="number" min="0" class="form_global" v-model="form.credit">
                                <v-errors :errors="errorFor('credit')"></v-errors>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('new.index.note') }}</label>
                                <input type="text" class="form_global" :placeholder=" trans('new.index.note')" v-model="form.note">
                                <v-errors :errors="errorFor('note')"></v-errors>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('new.index.attachment') }}</label>
                                <input type="file" class="form_global" :placeholder=" trans('new.index.attachment')" @change="attachmentUpload($event)">
                                <v-errors :errors="errorFor('attachment')"></v-errors>
                            </div>
                        </div>
                    </div>

                    <div class="d_flex_end">
                        <router-link class="btn btn_secondary mr_5" :to="{name: 'payments'}">{{ trans('admin.label.cancel') }}</router-link>
                        <button class="btn btn_md btn_success" @click.prevent="submitForm">{{ trans('admin.label.save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</template>

<script>
import validationErrors from "../../mixins/validationErrors";
export default {
    mixins: [validationErrors],
    data(){
        return {
            form: {
                type: 1,
                amount: 0,
                note: '',
                attachment: null,
                credit: 0,
            },
            perCreditCost: 0,
            duePayments : 0
        }
    },
    created(){
        axios.get('/api/student/payments/creditCost')
                .then((response) => {
                    this.perCreditCost = response.data.data.credit_rate
                })

        axios.get('/api/student/profile')
                .then((response) => {
                    this.duePayments = response.data.data.due_payments
                })
    },
    methods: {
        attachmentUpload(e) {
            this.form.attachment = e.target.files[0];
        },
        submitForm(){
            this.errors = null;
            this.loading = true;

            if(this.form.type == 2){
                let needToPay = this.perCreditCost * this.form.credit
                let duePayments = needToPay -  this.form.amount

                if(duePayments < 0){
                    this.$swal.fire(
                            this.trans('common.message.error'),
                            this.trans('common.message.check_amount'),
                            'error'
                        )
                    return
                } 
            }

            let formData = new FormData();
            Object.keys(this.form).forEach(key => {
                formData.append(key, this.form[key]);
            });

            axios.post('/api/student/payments', formData)
                .then(() => {
                    this.$router.push({name: 'payments'});
                })
                .catch((err) => this.errors = err.response.data.errors)
                .finally(() => this.loading = false);
        }
    },
}
</script>


