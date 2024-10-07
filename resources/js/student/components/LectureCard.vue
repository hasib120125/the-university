<template>
    <div>
        <div class="row">
            <div :class="className" v-for="(lecture, i) in lectures" :key="'lecture'+i">
                <div class="l_apply_content">
                    <div class="img">
                        <router-link v-if="pendingLecture !== true" :to="{name: 'lecture_overview', params:{id:lecture.id}}">
                            <img :src="lecture.professor.photo" alt="" class="width_full">
                        </router-link>
                        <img v-else :src="lecture.professor.photo" alt="" class="width_full">
                    </div>
                    <div class="inner_text">
                        <h2 class="name"> 
                            <router-link v-if="pendingLecture !== true" :to="{name: 'lecture_overview', params:{id:lecture.id}}">
                                {{ lecture.professor.name }}
                            </router-link>
                            <template v-else>
                                {{ lecture.professor.name }}
                            </template>
                        </h2>
                        <ul>
                            <li><span>{{ trans('student.form.lecture_apply.start_time') }}:</span><span>{{ time[lecture.start_time - 1] }}</span></li>
                            <li><span>{{ trans('student.form.lecture_apply.end_time') }}:</span><span>{{ time[lecture.end_time - 1] }}</span></li>
                            <li><span>{{ trans('student.form.lecture_apply.start_period') }}:</span><span>{{ lecture.start_period }}</span></li>
                            <li><span>{{ trans('student.form.lecture_apply.end_period') }}:</span><span>{{ lecture.end_period }}</span></li>
                            <li><span>{{ trans('student.form.lecture_apply.subject_name') }}:</span><span>{{ lecture.subject ? lecture.subject.name : '' }}</span></li>
                            <li><span>{{ trans('student.form.lecture.lecture_room') }}:</span><span>{{ lecture.room }}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    props: {
        lectures: {
            type: Array,
            required: false,
            default: []
        },
        className: {
            type: String,
            required: false,
            default: ''
        },
        pendingLecture: {
            type: Boolean,
            required: false,
            default: false
        },
    },
    components: {
        
    },
    data() {
        return {
            time: [
                this.trans('common.index.1st_period'),
                this.trans('common.index.2nd_period'),
            ]
        }
    },
    created() {
        
    },
    methods: {
        
    }
}
</script>
