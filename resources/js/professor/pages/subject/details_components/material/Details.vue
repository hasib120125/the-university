<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-body" v-if="material">
                    <div class="row">
                        <div class="col_10">
                            <h3 class="mb_15">{{ material.title }}</h3>
                        </div>
                        <div class="col_2">
                            <div class="d_flex_end">
                                <router-link class="btn btn_sm btn_secondary mr_5" :to="{name: 'subject_materials'}"> {{ this.trans('common.index.back') }} </router-link>
                            </div>
                        </div>
                    </div>

                    <div class="mt_10 mb_10" v-html="material.description"></div>
                    <div class="mt_10">
                        <a class="color_info" :href="material.attachment1" target="_blank" :download="material.id + '_attachment_1'" v-if="material.attachment1"> {{ trans('professor.form.materials.attachment_1') }}</a>
                        <br>
                        <a class="color_info" :href="material.attachment2" target="_blank" :download="material.id + '_attachment_2'" v-if="material.attachment2"> {{ trans('professor.form.materials.attachment_2') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            material: null,
        }
    },
    created() {
        axios.get(`/api/professor/subjects/${this.$route.params.id}/materials/${this.$route.params.material_id}`)
            .then((response) => { this.material = response.data.data })
    },
    methods: {

    },
}
</script>
<style scoped>
.color_info{
    color: blue;
}
</style>
