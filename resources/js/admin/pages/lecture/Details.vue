<template>
    <div>
        <div class="row">
            <div class="col_2">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ trans('admin.form.lecture.lecture_menu') }}</div>
                    </div>
                    <div class="card-body">
                        <ul class="inside_custom_menu">
                            <li><router-link :to="{name: 'lecture_overview'}">{{ trans('admin.form.lecture.overview') }}</router-link></li>
                            <li><router-link :to="{name: 'lecture_notices'}">{{ trans('admin.form.lecture.notices') }}</router-link></li>
                            <li><router-link :to="{name: 'lecture_plan', params:{notice_id: $route.params.id}}">{{ trans('admin.form.lecture.lecture_plan') }}</router-link></li>
                            <li><router-link :to="{name: 'lecture_managements'}">{{ trans('admin.form.lecture_management.lecture_management') }}</router-link></li>
                            <li><router-link :to="{name: 'lecture_materials'}">{{ trans('admin.form.lecture_material.lecture_material') }}</router-link></li>
                            <li><router-link :to="{name: 'lecture_assignments'}">{{ trans('admin.form.assignment.assignment_board') }}</router-link></li>
                            <li><router-link :to="{name: 'lecture_exams'}">{{ trans('admin.form.exam.exam') }}</router-link></li>
                            <li><router-link :to="{name: 'lecture_majors'}">{{ trans('admin.form.majors.majors') }}</router-link></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col_10">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    components: {

    },
    data() {
        return {

        }
    },
    methods: {

    }
}
</script>
