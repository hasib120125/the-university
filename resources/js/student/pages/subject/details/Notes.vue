<template>
    <div class="inner notes">
        <div class="create_note" v-if="!creating && currentContent">
            <div class="inner" @click="createNote">
                {{ trans('student.form.notes.create_new_note') }} <span> {{ this.playTime }} </span>
                <span class="plus"><i class="lni lni-plus"></i></span>
            </div>
        </div>

        <div v-if="creating">
            <div class="with_duration">
                <span class="duration">{{ formatTime(form.time.toString()) }}</span>
                <textarea class="form-control" rows="3" v-model="form.note"></textarea>
                <v-errors :errors="errorFor('note')"></v-errors>
            </div>
            <div class="btn_content">
                <button class="btn cancel" @click.prevent="creating = false">{{ trans('student.label.cancel') }}</button>
                <button class="btn" @click.prevent="saveNote">{{ trans('student.form.notes.save_note') }}</button>
            </div>
        </div>

        <div class="filter_content" v-if="notes.length > 0">
            <select class="form-control" v-model="queryParams.lecture" @change="loadData">
                <option value="">{{ trans('student.form.notes.all_lecture') }}</option>
                <option :value="content.id" v-for="(content, index) in contents" :key="'content_'+index">{{ content.name }}</option>
            </select>
            <select class="form-control" v-model="queryParams.sort" @change="loadData">
                <option value="1">{{ trans('student.form.notes.Sort_by_most_recent') }}</option>
                <option value="2">{{ trans('student.form.notes.Sort_by_oldest') }}</option>
            </select>
        </div>
        <div class="with_duration pt_20" v-for="(note, index) in notes" :key="'note_'+index">
            <span class="duration">{{ note.time }}</span>
            <h2><i class="lni lni-empty-file mr_5"></i>{{ note.lecture.name }}</h2>
            <div class="action_btn">
                <span @click="edit(note)"><i class="far fa-edit"></i></span>
                <span @click="deleteNote(note)"><i class="lni lni-trash"></i></span>
            </div>
            <div class="text_content">
                <p>{{ note.note }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import validationErrors from "../../../mixins/validationErrors";

export default {
    props: ['currentPlayTime', 'currentContent', 'contents'],
    mixins: [validationErrors],
    data() {
        return {
            creating: false,
            notes: [],
            queryParams: {
                lecture: '',
                sort: '1'
            },
            form: {
                time: 0,
                lecture_id: null,
                note: ''
            }
        }
    },
    created() {
        this.loadData();
    },
    computed: {
        playTime() {
            return this.formatTime(this.currentPlayTime);
        }
    },
    methods: {
        loadData() {
            axios.get('/api/student/subjects/'+this.$route.params.id+'/notes', {params: this.queryParams})
                .then((response) => this.notes = response.data.data);
        },
        createNote() {
            delete this.form.id;
            this.form.time = this.currentPlayTime;
            this.form.note = '';
            this.form.lecture_id = this.currentContent.id;
            this.creating = true;
        },
        edit(note) {
            this.form.note = note.note;
            this.form.id = note.id;
            this.form.time = note.time_sec;

            this.creating = true;
        },
        formatTime(sec) {
            let sec_num = parseInt(sec.toString()); // don't forget the second param
            let minutes = Math.floor(sec_num / 60);
            let seconds = sec_num - (minutes * 60);

            if (minutes < 10) {minutes = "0"+minutes;}
            if (seconds < 10) {seconds = "0"+seconds;}

            return minutes+':'+seconds;
        },
        deleteNote(note) {
            this.$swal({
                title: this.trans('student.label.delete'),
                text: this.trans('student.label.delete_confirmation'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: this.trans('student.label.yes_delete'),
                cancelButtonText: this.trans('student.label.no_cancel'),
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/api/student/subjects/'+this.$route.params.id+'/notes/'+note.id)
                        .then(() => {
                            this.notes = this.notes.filter((i) => i.id !== note.id);
                        })
                }
            });
        },
        saveNote() {
            this.errors = null;

            if (this.form.id) {
                axios.patch('/api/student/subjects/'+this.$route.params.id+'/notes/'+this.form.id, this.form)
                    .then((response) => {
                        this.loadData();
                        this.creating = false;
                    })
                    .catch((err) => this.errors = err.response.data.errors)
            } else {
                axios.post('/api/student/subjects/'+this.$route.params.id+'/notes', this.form)
                    .then((response) => {
                        this.loadData();
                        this.creating = false;
                    })
                    .catch((err) => this.errors = err.response.data.errors)
            }
        }
    }
}
</script>

