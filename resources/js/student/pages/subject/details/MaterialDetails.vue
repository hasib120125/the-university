<template>
    <div class="inner  announcements" v-if="material">
        <div class="inner_wrap">
            <div class="row">
                <div class="col-md-10">
                    <h3>{{ material.title }}</h3>
                    <p>{{ material.created_at }} </p>
                </div>
                <div class="col-md-2">
                    <div class="d_flex_end">
                        <router-link class="btn btn_sm btn_secondary mr_5" :to="{name: 'subject_materials'}"> {{ this.trans('common.index.back') }} </router-link>
                    </div>
                </div>
            </div>
            <div class="announcement_content" >
                <div class="mt_10 overflow_hidden" v-html="material.description"></div>
                <div class="mt_10">
                    <a class="color_info" :href="material.attachment1"  :download="material.attachment1_original_filename" v-if="material.attachment1"> <i class="fas fa-download"></i> {{ material.attachment1_original_filename }}</a>
                    <br>
                    <a class="color_info" :href="material.attachment2"  :download="material.attachment2_original_filename" v-if="material.attachment2"> <i class="fas fa-download"></i> {{ material.attachment2_original_filename }}</a>
                </div>
            </div>

            <!-- <div class="post_comment">
                <img :src="user.photo" alt="">
                <input type="text" class="form-control" v-model="commentForm.comment" :placeholder="trans('common.index.comment_placeholder')">
                <button class="btn btn_secondary" @click="sendComment(material.id)">{{ trans('common.index.send') }}</button>
                <v-errors :errors="errorFor('comment')"></v-errors>
            </div>

            <div class="all_comment" v-for="(comment, commentIndex) in material.comments" :key="'comment' + commentIndex">
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
import validationErrors from "../../../mixins/validationErrors";
import {mapGetters} from "vuex";

export default {
    mixins: [validationErrors],
    computed: {
        ...mapGetters({
            user: 'getUser',
        }),
    },
    data() {
        return {
            material: null,
            commentForm: {
                comment: null
            }
        }
    },
    created() {
        this.loadData();
    },
    watch: {
        $route() {
            this.loadData();
        }
    },
    methods: {
        loadData() {
            this.material = null;
            axios.get(`/api/student/subjects/${this.$route.params.id}/materials/${this.$route.params.material_id}`)
                .then((response) => this.material = response.data.data)
        },
        sendComment(){
            this.errors = null;

            axios.post('/api/student/subjects/materials/'+this.$route.params.material_id+'/comments', this.commentForm)
                .then((response) => {
                    this.commentForm.comment = null;
                    this.material.comments = response.data.data
                })
                .catch((err) => this.errors = err.response.data.errors);
        }
    },
}
</script>

<style scoped>
.color_info{
    color: blue;
}
</style>
