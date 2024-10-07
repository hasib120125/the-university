<template>
    <div class="navbar">
        <div class="brand">
            <router-link :to="{name: 'dashboard'}"><img src="/images/logo.png"></router-link>
        </div>
        <ul class="left_nav_list">
            <li>
                <div data-toggle="accordion" data-target="#Admistrative" class="left_f_list">
                    <a href="javascript:void(0)"> <i class='ti-agenda'></i><span>{{ trans('admin.form.admistrative.admistrative') }}</span></a>
                </div>
                <ul class="sub_accordion first_level" id="Admistrative">
                    <!-- <li><router-link :to="{name: 'faculties'}">{{ trans('admin.form.faculty.faculty') }}</router-link></li> -->
                    <li><router-link :to="{name: 'semesters'}">{{ trans('admin.form.semester.semester') }}</router-link></li>
                    <li><router-link :to="{name: 'departments'}">{{ trans('admin.form.department.department') }}</router-link></li>
                    <!-- <li><router-link :to="{name: 'tuition_fees'}">{{ trans('admin.form.student_tuition_fees.student_tuition_fees') }}</router-link></li>
                    <li><router-link :to="{name: 'curriculum_fees'}">{{ trans('admin.form.curriculum_fees.curriculum_fees') }}</router-link></li>
                    <li><router-link :to="{name: 'other_fees'}">{{ trans('admin.form.other_fees.other_fees') }}</router-link></li> -->
                    <li><router-link :to="{name: 'registration_open'}">{{ trans('common.index.reg_open') }}</router-link></li>
                </ul>
            </li>
            <li>
                <div data-toggle="accordion" data-target="#Academic" class="left_f_list">
                    <a href="javascript:void(0)"> <i class='ti-book'></i><span>{{ trans('admin.form.academic.academic') }}</span></a>
                </div>
                <ul class="sub_accordion first_level" id="Academic">
                    <li><router-link :to="{name: 'subjects'}">{{ trans('admin.form.subject.subject') }}</router-link></li>
                    <!-- <li><router-link :to="{name: 'lectures'}">{{ trans('admin.form.lecture.lecture') }}</router-link></li> -->
                    <li class="left_nav_level2">
                        <div data-toggle="accordion_level2" data-target="#students" class="left_f_list_level2">
                            <a href="#"> <span>{{ trans('admin.form.student.student') }}</span></a>
                        </div>
                        <ul class="sub_accordion sub_accordion2 second_level" id="students" style="display: none;">
                            <li><router-link :to="{name: 'students'}">{{ trans('common.index.active') }}</router-link></li>
                            <li><router-link :to="{name: 'in_active_students'}">{{ trans('common.index.pending') }}</router-link></li>
                            <li><router-link :to="{name: 'grade_input'}">{{ trans('admin.form.grade_input.grade_input') }}</router-link></li>
                            <li><router-link :to="{name: 'all_students'}">{{ trans('admin.form.student.all_students') }}</router-link></li>
                        </ul>
                    </li>
                    <li><router-link :to="{name: 'professors'}">{{ trans('admin.form.professors.professors') }}</router-link></li>
                    <li><router-link :to="{name: 'pending_applications'}">{{ trans('admin.form.application.pending_applications') }}</router-link></li>
                </ul>
            </li>
            <li>
                <div data-toggle="accordion" data-target="#official" class="left_f_list">
                    <a href="javascript:void(0)"> <i class='ti-briefcase'></i><span>{{ trans('admin.label.official') }}</span></a>
                </div>
                <ul class="sub_accordion first_level" id="official">
                    <li><router-link :to="{name: 'notices'}">{{ trans('admin.form.notices.notices') }}</router-link></li>
                    <li><router-link :to="{name: 'news'}">{{ trans('admin.form.news.news') }}</router-link></li>
                </ul>
            </li>
            <li>
                <div data-toggle="accordion" data-target="#Settings" class="left_f_list">
                    <a href="javascript:void(0)"> <i class='ti-settings'></i><span>{{ trans('admin.form.settings.settings') }}</span></a>
                </div>
                <ul class="sub_accordion first_level" id="Settings">
                    <li><router-link :to="{name: 'menus'}">{{ trans('admin.form.menu.menu') }}</router-link></li>
<!--                    <li><router-link :to="{name: 'sliders'}">{{ trans('admin.form.sliders.sliders') }}</router-link></li>-->
                    <li><router-link :to="{name: 'pages'}">{{ trans('admin.form.pages.pages') }}</router-link></li>
                    <li><router-link :to="{name: 'faqs'}">{{ trans('admin.form.faq.faq') }}</router-link></li>
                    <li><router-link :to="{name: 'socials'}">{{ trans('admin.form.socials.socials') }}</router-link></li>
                    <li><router-link :to="{name: 'features'}">{{ trans('admin.form.features.features') }}</router-link></li>
                    <li><router-link :to="{name: 'static_pages'}">{{ trans('admin.form.static_pages.static_pages') }}</router-link></li>
                    <li><router-link :to="{name: 'settings'}">{{ trans('admin.form.setting.other_settings') }}</router-link></li>
                    <li><router-link :to="{name: 'galleries'}">{{ trans('admin.form.setting.gallery') }}</router-link></li>
                    <li><router-link :to="{name: 'popup'}">{{ trans('admin.form.setting.popup') }}</router-link></li>
                    <li><router-link :to="{name: 'grade_system'}">{{ trans('admin.form.setting.grade_system') }}</router-link></li>
                    <li><router-link :to="{name: 'sample_lectures'}">{{ trans('admin.form.sample_lecture.title') }}</router-link></li>
                    <li><router-link :to="{name: 'footer_top'}">{{ trans('admin.form.footer_top.title') }}</router-link></li>
                </ul>
            </li>

            <li>
                <div data-toggle="accordion" data-target="#BulkUpload" class="left_f_list">
                    <a href="javascript:void(0)">
                        <i class='ti-upload'></i><span>{{ trans('admin.form.bulk_upload.bulk_upload') }}</span>
                    </a>
                </div>
                <ul class="sub_accordion first_level" id="BulkUpload">
                    <li><router-link :to="{name: 'bulk_video_upload'}">{{ trans('admin.form.bulk_upload.video_upload') }}</router-link></li>
                    <li><router-link :to="{name: 'bulk_video_list'}">{{ trans('admin.form.bulk_upload.video_list') }}</router-link></li>
                    <li><router-link :to="{name: 'bulk_audio_upload'}">{{ trans('admin.form.bulk_upload.audio_upload') }}</router-link></li>
                    <li><router-link :to="{name: 'bulk_audio_list'}">{{ trans('admin.form.bulk_upload.audio_list') }}</router-link></li>
                    <li><router-link :to="{name: 'bulk_subtitle_upload'}">{{ trans('admin.form.bulk_upload.subtitle_upload') }}</router-link></li>
                    <li><router-link :to="{name: 'bulk_subtitle_list'}">{{ trans('admin.form.bulk_upload.subtitle_list') }}</router-link></li>
                </ul>
            </li>

            <li>
                <div data-toggle="accordion" data-target="#Payments" class="left_f_list">
                    <a href="javascript:void(0)">
                        <i class='ti-money'></i><span>{{ trans('admin.form.payment.payments') }}</span>
                    </a>
                </div>
                <ul class="sub_accordion first_level" id="Payments">
                    <li><router-link :to="{name: 'payments_pending'}">{{ trans('admin.form.payment.pending') }}</router-link></li>
                    <li><router-link :to="{name: 'payments_approved'}">{{ trans('admin.form.payment.approved') }}</router-link></li>
                </ul>
            </li>
        </ul>
    </div>
</template>
