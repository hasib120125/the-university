<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ trans('admin.form.lecture.lecture_plan') }}</div>
                </div>
                <div :class="['card-body', {'loading_overlay': loading}]" >
                    <table class="table table_bordered table_fixed" v-if="lecture">
                        <tbody>
                            <tr>
                                <th rowspan="2">{{ trans('admin.form.lecture.division') }}</th>
                                <th colspan="2">{{ trans('admin.form.lecture.course_title') }}</th>
                                <th>{{ trans('admin.form.lecture.professor_in_charge') }}</th>
                            </tr>
                            <tr>
                                <td colspan="2">{{ lecture.subject ? lecture.subject.name : '-' }}</td>
                                <td>{{ lecture.professor ? lecture.professor.name : '-' }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('admin.form.lecture.lecture_time') }}</td>
                                <td colspan="3"> {{ lecture.day_name }} {{ periods[lecture.start_time - 1] }} - {{ periods[lecture.end_time - 1] }} </td>
                            </tr>
                            <tr>
                                <td>{{ trans('admin.form.lecture.lecture_room') }}</td>
                                <td colspan="3">{{ lecture.room }}</td>
                            </tr>
                            <tr>
                                <td>{{ trans('admin.form.lecture.course_objectives') }}</td>
                                <td colspan="3"><input type="text" class="form_global" v-model="lecture.course_objective"></td>
                            </tr>
                            <tr>
                                <td>{{ trans('admin.form.lecture.lecture_outline') }}</td>
                                <td colspan="3"><input type="text" class="form_global" v-model="lecture.lecture_outline"></td>
                            </tr>
                            <tr>
                                <td>{{ trans('admin.form.lecture.textbook') }}</td>
                                <td colspan="3"><input type="text" class="form_global" v-model="lecture.textbook"></td>
                            </tr>
                            <tr>
                                <td>{{ trans('admin.form.lecture.reference_books') }}</td>
                                <td colspan="3"><input type="text" class="form_global" v-model="lecture.reference_book"></td>
                            </tr>
                            <tr>
                                <td>{{ trans('admin.form.lecture.evaluation_standard') }}</td>
                                <td colspan="3"><input type="text" class="form_global" v-model="lecture.evaluation_standard"></td>
                            </tr>
                            <tr>
                                <td>{{ trans('admin.form.lecture.grade_evaluation') }}</td>
                                <td colspan="3">
                                    <div class="row">
                                        <div class="col_4">
                                            <div class="form_row_inline">
                                                <label>{{ trans('admin.form.lecture.attendance') }}</label>
                                                <input min="0" type="number" class="form_global" v-model="lecture.attendance">
                                                <v-errors :errors="errorFor('attendance')"></v-errors>
                                            </div>
                                        </div>
                                        <div class="col_4">
                                            <div class="form_row_inline">
                                                <label>{{ trans('admin.form.lecture.mid') }}</label>
                                                <input min="0" type="number" class="form_global" v-model="lecture.middle">
                                                <v-errors :errors="errorFor('middle')"></v-errors>
                                            </div>
                                        </div>
                                        <div class="col_4">
                                            <div class="form_row_inline">
                                                <label>{{ trans('admin.form.lecture.final') }}</label>
                                                <input min="0" type="number" class="form_global" v-model="lecture.ending">
                                                <v-errors :errors="errorFor('ending')"></v-errors>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt_10">
                                        <div class="col_4">
                                            <div class="form_row_inline">
                                                <label>{{ trans('admin.form.lecture.others') }}</label>
                                                <input min="0" type="number" class="form_global" v-model="lecture.etc">
                                                <v-errors :errors="errorFor('etc')"></v-errors>
                                            </div>
                                        </div>
                                        <div class="col_4">
                                            <div class="form_row_inline">
                                                <p>{{ trans('admin.form.lecture.total') }}: <span :class="totalMark > 100 || totalMark < 100 ? 'color_danger' : ''">{{ totalMark > 0 ? totalMark: 0 }} %</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <v-errors :errors="errorFor('total_mark')"></v-errors>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ trans('admin.form.lecture.parking') }}</th>
                                <th>{{ trans('admin.form.lecture.main_topic') }}</th>
                                <th>{{ trans('admin.form.lecture.lecture_content') }}</th>
                                <th>{{ trans('admin.form.lecture.remark') }}</th>
                            </tr>
                            <tr v-for="(lecture_week, lecture_week_index) in lecture.lecture_weeks" :key="lecture_week_index">
                                <td>{{ trans('admin.form.lecture.week') }} {{ lecture_week.week }}</td>
                                <td><input type="text" class="form_global" v-model="lecture.lecture_weeks[lecture_week_index].topic"></td>
                                <td><input type="text" class="form_global" v-model="lecture.lecture_weeks[lecture_week_index].lecture_content"></td>
                                <td><input type="text" class="form_global" v-model="lecture.lecture_weeks[lecture_week_index].remark"></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="d_flex_end">
                        <router-link class="btn btn_secondary mr_5" :to="{name: 'lecture_plan'}">{{ trans('admin.label.cancel') }}</router-link>
                        <button class="btn btn_md btn_success" @click.prevent="submitForm">{{ trans('admin.label.save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import validationErrors from "../../../../mixins/validationErrors";

export default {
    mixins: [validationErrors],
    data() {
        return {
            lecture: null,
            periods: ['1st Period', '2nd Period']
        }
    },
    created() {
        this.loading = true;
        axios.get('/api/admin/lectures/' + this.$route.params.id + '?week=true')
            .then((response) => { this.lecture = response.data.data }).finally(() => this.loading = false);
    },
    computed:{
        totalMark(){
            let lecture = this.lecture
            return Number(lecture.attendance) + Number(lecture.middle) + Number(lecture.ending) + Number(lecture.etc)
        }
    },
    methods: {
        submitForm(){
            this.loading = true;
            let formData = this.lecture
            formData.subject_id = formData.subject.id
            formData.professor_id = formData.professor.id
            formData.total_mark = this.totalMark

            axios.patch('/api/admin/lectures/'+ this.$route.params.id, this.lecture)
                    .then((response) => {
                        this.$router.push({name: 'lecture_plan'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);
        },
    },
}
</script>
