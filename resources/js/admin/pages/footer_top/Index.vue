<template>
    <div>
        <div class="row mb_15" v-if="showForm">
            <div class="col_12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col_6">
                                <div class="form-group ">
                                    <label>{{ this.trans('admin.form.footer_top.link') }}</label>
                                    <input type="text" class="form_global" v-model="form.link">
                                    <v-errors :errors="errorFor('link')"></v-errors>
                                </div>
                            </div>

                            <div class="col_6">
                                <div class="form-group ">
                                    <label>{{ this.trans('admin.form.footer_top.image') }}</label>
                                    <input type="file" class="form_global" ref="image" @change="uploadFile($event, 'image')">
                                    <v-errors :errors="errorFor('image')"></v-errors>
                                </div>
                            </div>

                            <div class="col_12">
                                <div class="d_flex_end">
                                    <button class="btn btn_secondary mr_5" @click.prevent="showForm = false">
                                        {{ trans('admin.label.cancel') }}
                                    </button>
                                    <button class="btn btn_md btn_success" @click.prevent="submitForm">
                                        {{ trans('admin.label.save') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-if="footerTops.length < 3">
            <div class="col_12">
                <div class="card">
                    <div class="card-body">
                        <button class="btn btn_info" @click.prevent="showForm = true; resetForm()">{{ this.trans('admin.form.footer_top.add_new_image') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-if="footerTops.length">
            <div class="col_12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ this.trans('admin.form.footer_top.footer_top_images') }}</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col_12">
                                <table class="table has_border">
                                    <tr>
                                        <th>{{ this.trans('admin.form.footer_top.image') }}</th>
                                        <th>{{ this.trans('admin.form.footer_top.link') }}</th>
                                        <th>{{ this.trans('admin.label.action') }}</th>
                                    </tr>
                                    <tr v-for="(footerTop, index) in footerTops" :key="'footerTop_' + index">
                                        <td>
                                            <img :src="footerTop.image">
                                        </td>
                                        <td>{{ footerTop.link }}</td>
                                        <td>
                                            <button class="btn btn_sm btn_info mr_5" @click.prevent="editData(footerTop)"><i class="far fa-edit"></i></button>
                                            <button class="btn btn_sm btn_danger" @click.prevent="deleteItem(footerTop)"><i class="far fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
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
    data() {
        return {
            showForm: false,
            form: {
                link: '',
                image: '',
                id: null,
            },
            footerTops: []
        }
    },
    created() {
        this.loadData()
    },
    methods: {
        editData(footerTop){
            this.resetForm()
            this.form.link = footerTop.link
            this.form.id = footerTop.id
            this.showForm = true
        },
        resetForm(){
            if(this.form.image){
                this.$refs.image.value = ''
            }

            this.form = {
                link: '',
                image: '',
                id: null,
            }
        },
        loadData(){
            this.resetForm()
            axios.get('/api/admin/footer-top').then((response) => this.footerTops = response.data.data)
        },
        submitForm() {
            this.loading = true;
            this.errors = null;

            let formData = new FormData();
            Object.keys(this.form).forEach(key => {
                formData.append(key, this.form[key]);
            });

            if (this.form.id) {
                formData.append('_method', 'PUT');

                axios.post('/api/admin/footer-top/' + this.form.id, formData)
                    .then((response) => {
                        this.loadData()
                        this.showForm = false
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            } else {
                axios.post('/api/admin/footer-top', formData)
                    .then((response) => {
                        this.loadData()
                        this.showForm = false
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);
            }

        },
        uploadFile(e, callFrom) {
            this.$set(this.form, callFrom, e.target.files[0])
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
                    axios.delete('/api/admin/footer-top/' + item.id).then(() => {
                        this.loadData()
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


