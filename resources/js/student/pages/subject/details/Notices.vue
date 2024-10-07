<template>
    <div class="inner announcements">
        <div class="inner_wrap" v-for="(notice , noticeIndex) in notices" :key="'notice ' + noticeIndex ">
            <div class="author_name">
                <img :src="'/images/logo.png'">
                <a href="#">관리자</a>
                <p> {{ notice.created_at }}</p>
            </div>

            <div class="announcement_content" >
                <h2>{{ notice.title }}</h2>
                <div class="mt_10 overflow_hidden" v-html="notice.description"></div>
                <div class="mt_10">
                    <a class="color_info" :href="notice.attachment1"  :download="notice.attachment1_original_filename" v-if="notice.attachment1"><i class="fas fa-download"></i> {{ notice.attachment1_original_filename }}1</a>
                    <br>
                    <a class="color_info" :href="notice.attachment2"  :download="notice.attachment2_original_filename" v-if="notice.attachment2"><i class="fas fa-download"></i> {{ notice.attachment2_original_filename }}2</a>
                </div>
            </div>
            <!-- <div class="post_comment">
                <img :src="user.photo">
                <input type="text" class="form-control" v-model="commentForm.comment[noticeIndex]" :placeholder="trans('common.index.comment_placeholder')">
                <button class="btn btn_secondary" @click="sendComment(notice.id, noticeIndex)">{{ trans('common.index.send') }}</button>
                <v-errors :errors="errorFor('comment.'+noticeIndex)"></v-errors>
            </div>

            <div class="all_comment" v-for="(comment, commentIndex) in notice.comments" :key="'comment' + commentIndex">
                <div class="all_comment_inner">
                    <img :src="comment.avatar" alt="">
                    <div class="text">
                        <p><a href="#">{{ comment.name }}</a> <span class="time">{{ comment.created_at }}</span> </p>
                        <p>{{ comment.comment }}</p>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import validationErrors from "../../../mixins/validationErrors";

export default {
    mixins: [validationErrors],
    computed: {
        ...mapGetters({
            user: 'getUser',
        }),
    },
    data() {
        return {
            notices: [],
            commentForm: {
                comment: []
            },
        }
    },
    created() {
        axios.get(`/api/student/subjects/${this.$route.params.id}/notices`)
            .then((response) => this.notices = response.data.data)
    },
    methods: {
        sendComment(notice_id, noticeIndex) {
            this.errors = null;

            axios.post('/api/student/subjects/notices/'+ notice_id +'/comments', {
                    comment: this.commentForm.comment[noticeIndex]
                })
                .then((response) => {
                    this.commentForm.comment = []
                    this.notices[noticeIndex].comments = response.data.data
                })
                .catch((err) => {
                    this.errors = err.response.data.errors;
                    this.errors['comment.'+noticeIndex] = err.response.data.errors.comment;
                });
        }
    }
}
</script>
