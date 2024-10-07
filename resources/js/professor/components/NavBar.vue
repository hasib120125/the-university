<template>
    <div class="navbar">
        <div class="brand">
            <router-link :to="{name: 'home'}"><img src="/images/logo.png" alt=""></router-link>
        </div>
        <ul class="left_nav_list">
            <li>
                <div class="left_f_list">
                    <router-link :to="{name: 'profile'}"> <i class='ti-settings'></i><span>{{ trans('professor.form.profile.profile') }}</span></router-link>
                </div>
            </li>
            <li>
                <div class="left_f_list">
                    <router-link :to="{name: 'subjects'}"> <i class='ti-book'></i><span>{{ trans('professor.form.subject.subject') }}</span></router-link>
                </div>
            </li>
            <li>
                <div class="left_f_list">
                    <router-link :to="{name: 'grade_input'}"> <i class='ti-briefcase'></i><span>{{ trans('professor.form.grade_input.grade_input') }}</span></router-link>
                </div>
            </li>
            <!-- <li>
                <div data-toggle="accordion" data-target="#WIP" class="left_f_list open"><a href="#"> <i class='ti-settings'></i><span>{{ trans('professor.form.dashboard.dashboard') }}</span></a></div>
                <ul class="sub_accordion first_level" id="WIP">
                    <li><router-link :to="{name: 'profile'}">{{ trans('professor.form.profile.profile') }}</router-link></li>
                </ul>
            </li>
            <li>
                <div data-toggle="accordion" data-target="#Academic" class="left_f_list">
                    <a href="javascript:void(0)"> <i class='ti-book'></i><span>{{ trans('professor.form.academic.academic') }}</span></a>
                </div>
                <ul class="sub_accordion first_level" id="Academic">
                    <li><router-link :to="{name: 'subjects'}">{{ trans('professor.form.subject.subject') }}</router-link></li>
                    <li><router-link :to="{name: 'grade_input'}">{{ trans('professor.form.grade_input.grade_input') }}</router-link></li>
                </ul>
            </li> -->
        </ul>
    </div>
</template>
