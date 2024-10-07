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
                                <label>{{ trans('admin.form.profile.name') }}</label>
                                <input type="text" class="form_global" v-model="form.name">
                                <v-errors :errors="errorFor('name')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.profile.email') }}</label>
                                <input type="text" class="form_global" v-model="form.email">
                                <v-errors :errors="errorFor('email')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.profile.password') }}</label>
                                <input type="password" class="form_global" v-model="form.password">
                                <v-errors :errors="errorFor('password')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.profile.photo') }} {{ form.temp_photo ? '('+ form.temp_photo + ')' : '' }}</label>
                                <div class="file_input">
                                    <span>{{ trans('common.index.browse') }}</span>
                                    <input type="file" class="form_global" @change="attachmentUpload($event, 'photo')" accept="image/png, image/gif, image/jpeg"  :placeholder="trans('admin.form.student.photo')">
                                </div>
                                <v-errors :errors="errorFor('photo')"></v-errors>
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
import {mapGetters} from "vuex";


export default {
    mixins: [validationErrors],
    data(){
        return {
            form: {
                name: '',
                email: '',
                photo: null,
                password: ''
            },
            pageName: this.trans('admin.form.profile.title'),
        }
    },
     computed: {
        ...mapGetters({
            user: 'getUser',
        }),
    },
    created(){
        this.form = JSON.parse(JSON.stringify(this.user));
        this.form.photo = null
    },
    methods: {
        attachmentUpload(e, callFrom) {
            this.$set(this.form, callFrom, e.target.files[0])
        },
        submitForm(){
            this.loading = true;
            this.errors = null;
            let formData = new FormData()

            Object.keys(this.form).forEach(key => {
                formData.append(key, this.form[key] ? this.form[key] : '');
            })

            formData.append('_method','PATCH')
            axios.post('/api/admin/profile-update/'+ this.form.id, formData)
                .then((response) => {
                    let user = response.data.data;
                    user.token = this.$store.state.user.token;
                    user.type = "admin";

                    if (user) {
                        localStorage.setItem('user', JSON.stringify(user));
                        axios.defaults.headers.common['Authorization'] = `Bearer ${user.token}`;

                        this.$store.commit('setUser', user)
                    }

                    this.$swal.fire(
                            this.trans('common.message.success'),
                            this.trans('common.index.profile_update'),
                            'success'
                        )
                })
                .catch((err) => this.errors = err.response.data.errors)
                .finally(() => this.loading = false);
        },
    },
}
</script>


