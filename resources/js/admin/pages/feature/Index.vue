<template>
    <div>
        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-body">
                        <router-link :to="{ name: 'features_add' }" class="btn btn_info">{{ trans('admin.form.features.add_new_feature') }}</router-link>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ trans('admin.form.features.feature') }}</div>
                    </div>
                    <div class="card-body">
                        <table class="table table_bordered table_center table_fixed">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('admin.form.features.name_en') }}</th>
                                <th>{{ trans('admin.form.features.name_ko') }}</th>
                                <th>{{ trans('admin.form.sliders.image') }}</th>
                                <th>{{ trans('admin.label.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(feature, i) in features" :key="'career_'+i">
                                <td>{{ i+1 }}</td>
                                <td>{{ feature.name }}</td>
                                <td>{{ feature.name_ko }}</td>
                                <td><img width="150px" :src="feature.image" alt=""></td>
                                <td>
                                    <router-link class="btn btn_blue" :to="{name:'features_edit', params:{id: feature.id}}"><i class="bx bx-edit-alt"></i></router-link>
                                    <button class="btn btn_danger" @click.prevent="deleteItem(feature)"><i class='bx bxs-trash'></i></button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
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
            features:[]
        }
    },
    created() {
        this.getFeatures();
    },
    methods: {
        getFeatures(){
            axios.get('/api/admin/features') .then((response) => { this.features = response.data.data; })
        },
        deleteItem(item) {
            this.$swal({
                title: this.trans('admin.label.delete_confirmation'),
                text: this.trans('admin.label.warning'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: this.trans('admin.label.yes_delete'),
                cancelButtonText: this.trans('admin.label.no_cancel'),
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/api/admin/features/'+item.id).then(() => {
                        this.getFeatures();
                        this.$swal.fire(
                            this.trans('common.message.deleted'),
                            this.trans('common.message.delete_message'),
                            'success'
                        )
                    });
                }
            });
        }
    }
}
</script>
