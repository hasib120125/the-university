<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ trans('admin.form.setting.other_settings') }}</div>
                </div>
                <div :class="['card-body', {'loading_overlay': loading}]">
                    <div class="row">
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.setting.credit_rate') }}</label>
                                <input type="number" min="0" class="form_global" v-model="form.credit_rate">
                                <v-errors :errors="errorFor('credit_rate')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.setting.university_name') }}</label>
                                <input type="text" class="form_global" v-model="form.university_name">
                                <v-errors :errors="errorFor('university_name')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.setting.current_semester') }}</label>
                                <select class="form_global" id="current_semester_id" v-model="form.current_semester_id">
                                    <option value="">{{ trans('admin.form.setting.select_current_semester') }}</option>
                                    <option v-for="(semester, i) in semesters" :key="'semester_'+i" :value="semester.id">
                                        {{ semester.year }} - {{ semester.season_name }}
                                    </option>
                                </select>
                                <v-errors :errors="errorFor('current_semester_id')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.setting.university_address') }}</label>
                                <input type="text" class="form_global" v-model="form.university_address">
                                <v-errors :errors="errorFor('university_address')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.setting.phone_number') }}</label>
                                <input type="text" class="form_global" v-model="form.phone_number">
                                <v-errors :errors="errorFor('phone_number')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.setting.home_video') }}</label>
                                <input type="file" class="form_global" @change="uploadFile($event, 'home_video')">
                                <v-errors :errors="errorFor('home_video')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.setting.audio_image') }}</label>
                                <input type="file" class="form_global" @change="uploadFile($event, 'audio_image')">
                                <v-errors :errors="errorFor('audio_image')"></v-errors>
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
                id: '',
                credit_rate: 0,
                current_semester_id: '',
                home_video: '',
                university_name:'',
                university_address:'',
                phone_number:'',
                audio_image:'',
            },

            semesters : []
        }
    },
    created() {
        axios.get('/api/admin/semesters')
            .then((response) => {
                this.semesters = response.data.data;
            })

        this.loading = true;
        this.loadData()
    },
    methods: {
        uploadFile(e, callFrom) {
            this.$set(this.form, callFrom, e.target.files[0])
        },
        loadData(){
            axios.get('/api/admin/setting')
                .then((response) => {
                    this.form.id = response.data.data[0].id;
                    this.form.credit_rate = response.data.data[0].credit_rate;
                    this.form.current_semester_id = response.data.data[0].current_semester_id.id;
                    this.form.university_name = response.data.data[0].university_name;
                    this.form.university_address = response.data.data[0].university_address;
                    this.form.phone_number = response.data.data[0].phone_number;
                }).finally(() => this.loading = false);
        },
        submitForm(){
            this.errors = null;
            this.loading = true;
            let formData = new FormData();

            Object.keys(this.form).forEach(key => {
                formData.append(key, this.form[key]);
            });
            formData.append('_method', 'PATCH');
            axios.post('/api/admin/setting/' + this.form.id, formData)
                .then((response) => {
                    this.$swal.fire(
                        this.trans('common.message.success'),
                        this.trans('common.message.setting_update_message'),
                        'success'
                    )
                    this.loadData()
                })
                .catch((err) => this.errors = err.response.data.errors)
                .finally(() => this.loading = false);
        },
    },
}
</script>


