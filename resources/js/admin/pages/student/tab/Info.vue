<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-body" v-if="student">
                    <div class="table_responsive">
                        <table class="table table_bordered ">
                            <colgroup>
                                <col width="25%">
                                <col width="25%">
                                <col width="25%">
                                <col width="25%">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th>{{ trans('student.form.profile.name_english') }}</th>
                                    <td><span>{{ student.name_english }}</span></td>
                                    <td rowspan="3" colspan="2">
                                        <div class="text-center">
                                            <img class="img_circle_with_100px" :src="student.photo" alt="">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ trans('student.form.profile.name_chines') }}</th>
                                    <td> <span>{{ student.name_chinese }}</span></td>
                                </tr>
                                <tr>
                                    <th>{{ trans('student.form.profile.name_hungul') }}</th>
                                    <td> <span>{{ student.name_hangul }}</span></td>
                                </tr>

                                <tr>
                                    <th>{{ trans('admin.form.student.student_no') }}</th>
                                    <td><span>{{ student.student_no }}</span></td>
                                    <th>{{ trans('student.form.profile.department_major') }}</th>
                                    <td><span v-if="student.department">{{ student.department.name }}</span></td>
                                </tr>
                                <tr>
                                    <th>{{ trans('student.form.profile.email') }}</th>
                                    <td><span>{{ student.email }}</span></td>
                                    <th>{{ trans('student.form.profile.phone') }}</th>
                                    <td>{{ student.mobile }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('student.form.profile.dob') }}</th>
                                    <td><span>{{ student.dob_formatted }}</span></td>
                                    <th>{{ trans('student.form.profile.grade') }}</th>
                                    <td><span>{{ student.grade }} {{ trans('student.form.profile.grade') }}</span></td>
                                </tr>
                                <tr>
                                    <th>{{ trans('student.form.profile.address') }}</th>
                                    <td>{{ student.address }}</td>
                                    <th>{{ trans('student.form.profile.citizenship_no') }}</th>
                                    <td><span>{{ student.citizenship_no }}</span></td>
                                </tr>
                                <tr>
                                    <th>{{ trans('student.form.profile.final_academic_background') }}</th>
                                    <td><span>{{ student.last_school_name }}</span></td>
                                    <th>{{ trans('student.form.profile.department') }}</th>
                                    <td><span>{{ student.last_education_department }}</span></td>
                                </tr>
                                <tr>
                                    <th>{{ trans('student.form.profile.motive') }}</th>
                                    <td><span>{{ student.motive }}</span></td>
                                    <th>{{ trans('student.form.profile.job_company') }}</th>
                                    <td><span>{{ student.job_company }}</span></td>
                                </tr>
                                <tr>
                                    <th>{{ trans('student.form.profile.job_position') }}</th>
                                    <td><span>{{ student.job_position }}</span></td>
                                    <th>{{ trans('student.form.profile.job_address') }}</th>
                                    <td><span>{{ student.job_address }}</span></td>
                                </tr>

                                <tr>
                                    <th>{{ trans('student.form.profile.state') }}</th>
                                    <td>
                                        <span>{{ student.status_text }}</span>
                                    </td>
                                    <th>{{ trans('student.form.profile.church_name') }}</th>
                                    <td>
                                        <span>{{ student.church_name }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ trans('student.form.profile.admission_date') }}</th>
                                    <td><span>{{ student.admission_date }}</span></td>
                                    <th>{{ trans('student.form.profile.graduation_date') }}</th>
                                    <td><span>{{ student.graduation_date }}</span></td>
                                </tr>
                                <tr>
                                    <th>{{ trans('student.form.profile.advisor') }}</th>
                                    <td><span v-if="student.professor">{{ student.professor.name }}</span></td>
                                    <th>{{ trans('admin.form.student.bible_test') }}</th>
                                    <td>
                                        <template v-if="student.bible_exam == 1">
                                            {{ trans('admin.form.student.pass') }} 
                                            <span v-if="student.point_value">( {{ student.point_value }}{{ trans('admin.form.student.point') }} )</span>
                                        </template>
                                        <template v-if="student.bible_exam == 0">
                                            {{ trans('admin.form.student.non_pass') }} 
                                            <span v-if="student.point_value">( {{ student.point_value }}{{ trans('admin.form.student.point') }} )</span>
                                        </template>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <template  v-if="student.faiths && student.faiths.length > 0" >
                        <div class="col-md-12 mt_20 mb_20">
                            <h3>{{ trans('front.student_registration.no_number_life_of_faith') }}</h3>
                        </div>
                        <table class="table table_bordered table_center table_fixed">
                            <thead>
                                <tr>
                                    <th>{{ trans('front.student_registration.church_name') }}</th>
                                    <th>{{ trans('front.student_registration.church_location') }}</th>
                                    <th>{{ trans('front.student_registration.office') }}</th>
                                    <th>{{ trans('front.student_registration.denomination') }}</th>
                                    <th>{{ trans('front.student_registration.year_of_faith') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(faith, i) in student.faiths" :key="'career_'+i">
                                    <td>{{ faith.name }}</td>
                                    <td>{{ faith.location }}</td>
                                    <td>{{ faith.office }}</td>
                                    <td>{{ faith.denomination }}</td>
                                    <td>{{ faith.year_of_faith }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

export default {
    props: {
        student: {
            type: Object,
            required: true,
            default: {}
        }
    },
    data() {
        return {

        }
    },
    methods: {

    }
}
</script>
