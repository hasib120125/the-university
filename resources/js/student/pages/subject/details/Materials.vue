<template>
    <div class="inner">
        <div class="inner_wrap">
            <div class="table_responsive">
                <table class="table table_center table_bordered">
                    <thead>
                    <tr>
                        <th class="text-left">{{trans('student.label.title')}}</th>
                        <th>{{trans('student.label.action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(material, materialIndex) in materials" :key="materialIndex">
                        <td class="text-left">{{material.title}}</td>
                        <td>
                            <router-link class="btn btn_sm btn_blue" :to="{name: 'subject_material_view', params: {id:$route.params.id ,material_id: material.id }}"> {{ trans('student.label.details') }} </router-link>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            materials: [],
        }
    },
    created(){
        axios.get(`/api/student/subjects/${this.$route.params.id}/materials`)
            .then((response) => this.materials = response.data.data);
    }
}
</script>
