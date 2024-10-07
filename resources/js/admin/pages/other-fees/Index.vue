<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ pageName }}</div>
                </div>
                <div :class="['card-body', {'loading_overlay': loading}]">
                    <div class="row">
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.other_fees.entrance') }}</label>
                                <input type="number" min="0" class="form_global"   v-model="form.entrance">
                                <v-errors :errors="errorFor('entrance')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.other_fees.seminar_fees') }}</label>
                                <input type="number" min="0" class="form_global"   v-model="form.seminar_fees">
                                <v-errors :errors="errorFor('subject_fee')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.other_fees.student_union') }}</label>
                                <input type="number" min="0" class="form_global"   v-model="form.student_union">
                                <v-errors :errors="errorFor('student_union')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.other_fees.orientation') }}</label>
                                <input type="number" min="0" class="form_global"   v-model="form.orientation">
                                <v-errors :errors="errorFor('orientation')"></v-errors>
                            </div>
                        </div>

                    </div>

                    <div class="d_flex_end">
                        <button class="btn btn_md btn_success" @click.prevent="submitForm">{{ trans('admin.label.save') }}</button>
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
                entrance: 0,
                seminar_fees: 0,
                student_union: 0,
                orientation: 0
            },
            pageName: this.trans('admin.form.other_fees.other_fees'),
        }
    },
    created() {
        this.otherFees()
    },
    methods: {
        otherFees(){
            axios.get('/api/admin/other-fees')
            .then((response) => {
                this.form = response.data.data;
            })
        },
        submitForm(){
            this.$swal({
                title: this.trans('admin.label.update_confirmation'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: this.trans('admin.label.yes_update'),
                cancelButtonText: this.trans('admin.label.no_cancel'),
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    this.loading = true
                    this.errors = null
                    axios.patch('/api/admin/other-fees/'+ this.form.id, this.form).then((response) => {
                        this.$swal.fire(
                            this.trans('common.message.updated'),
                            this.trans('common.message.update_message'),
                            'success'
                        )
                        this.otherFees()
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false)
                }
            })
        }
    },
}
</script>





