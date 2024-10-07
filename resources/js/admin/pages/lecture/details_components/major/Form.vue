<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ pageName }}</div>
                </div>
                <div :class="['card-body', {'loading_overlay': loading}]">
                    <div class="row">
                        <div class="col_4">
                            <div class="form-group">
                                <label>{{ trans('admin.form.lecture.course_title') }}</label>
                                <p>{{ lecture.subject ? lecture.subject.name : '' }}</p>
                            </div>
                        </div>
                        <div class="col_4">
                            <div class="form-group">
                                <label>{{ trans('admin.form.majors.department') }}</label>
                                <select class="form_global" id="curriculum_id" v-model="form.curriculum_id">
                                    <option value="">{{ trans('admin.form.majors.please_select') }}</option>
                                    <option v-for="(curriculum, i) in curriculums" :key="'curriculum_'+i" :value="curriculum.id">
                                        {{ curriculum.name }}</option>
                                </select>
                                <v-errors :errors="errorFor('curriculum_id')"></v-errors>
                            </div>
                        </div>
                        <div class="col_4">
                            <div class="form-group">
                                <label>{{ trans('admin.form.majors.grades') }}</label>
                                <div class="d_flex_inline">
                                    <input type="text" class="form_global" v-model="form.grade">
                                    <span class="ml_5">{{ trans('admin.form.majors.points') }}</span>
                                </div>
                                <v-errors :errors="errorFor('grade')"></v-errors>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col_5">
                            <div class="form-group mb_5">
                                <label class="pb_0">{{ trans('admin.form.majors.major_category') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" id="major_category_1"  v-model="form.major_category" value="1">
                                <label for="major_category_1">{{ trans('admin.form.majors.common_essentials') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" id="major_category_2"  v-model="form.major_category" value="2">
                                <label for="major_category_2">{{ trans('admin.form.majors.major_required') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" id="major_category_3"  v-model="form.major_category" value="3">
                                <label for="major_category_3">{{ trans('admin.form.majors.selection') }}</label>
                            </div>
                            <v-errors :errors="errorFor('status')"></v-errors>
                        </div>
                        <div class="col_5">
                            <div class="form_row">
                                <div class="form-group mb_5">
                                    <label class="pr_0">{{ trans('common.index.course_target') }}</label>
                                </div>
                                <div class="form_checkbox">
                                    <input type="checkbox" id="Checkme1" v-model="form.grade_year_1" value="1">
                                    <label for="Checkme1">{{ trans('common.index.grade1') }}</label>
                                    <v-errors :errors="errorFor('grade_year_1')"></v-errors>
                                </div>
                                <div class="form_checkbox">
                                    <input type="checkbox" id="Checkme2" v-model="form.grade_year_2" value="1">
                                    <label for="Checkme2">{{ trans('common.index.grade2') }}</label>
                                    <v-errors :errors="errorFor('grade_year_2')"></v-errors>
                                </div>
                                <div class="form_checkbox">
                                    <input type="checkbox" id="Checkme3" v-model="form.grade_year_3" value="1">
                                    <label for="Checkme3">{{ trans('common.index.year3') }}</label>
                                    <v-errors :errors="errorFor('grade_year_3')"></v-errors>
                                </div>
                                <div class="form_checkbox">
                                    <input type="checkbox" id="Checkme4" v-model="form.grade_year_4" value="1">
                                    <label for="Checkme4">{{ trans('common.index.grade4') }}</label>
                                    <v-errors :errors="errorFor('grade_year_4')"></v-errors>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d_flex_end">
                        <router-link class="btn btn_secondary mr_5" :to="{name: 'lecture_majors'}">{{ trans('admin.label.cancel') }}</router-link>
                        <button class="btn btn_md btn_success" @click.prevent="submitForm">{{ trans('admin.label.save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import validationErrors from "../../../../mixins/validationErrors"

export default {
    name: 'lecture-major-form',
    mixins: [validationErrors],
    data(){
        return {
            form: {
                grade: null,
                major_category: null,
                curriculum_id: '',
                grade_year_1: 0,
                grade_year_2: 0,
                grade_year_3: 0,
                grade_year_4: 0
            },
            pageName: this.trans('admin.form.majors.add'),
            curriculums: [],
            lecture: {},
        }
    },
    created() {
        axios.get('/api/admin/curriculums')
            .then((response) => {
                this.curriculums = response.data.data
            })

        axios.get('/api/admin/lectures/'+ this.$route.params.id)
            .then((response) => {
                this.lecture = response.data.data
            });

        if (this.$route.name === 'lecture_major_update') {
            this.loading = true;
            this.pageName = this.trans('admin.form.majors.edit') ;
            axios.get('/api/admin/lectures/' + this.$route.params.id + '/majors/' + this.$route.params.major_id)
                .then((response) => {
                    this.form = response.data.data
                    this.form.curriculum_id = response.data.data.id
                }).finally(() => this.loading = false);
        }
    },
    methods: {
        submitForm(){
            this.loading = true;
            this.errors = null;

            let formData = this.form;

            if (this.$route.name === 'lecture_major_update') {
                axios.patch('/api/admin/lectures/' + this.$route.params.id + '/majors/'+ this.$route.params.major_id, formData)
                    .then((response) => {
                        this.$router.push({name: 'lecture_majors'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            }else{
                axios.post('/api/admin/lectures/' + this.$route.params.id + '/majors', formData)
                    .then((response) => {
                        this.$router.push({name: 'lecture_majors'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            }
        }
    },
}
</script>


