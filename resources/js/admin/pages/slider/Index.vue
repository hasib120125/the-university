<template>
    <div>
        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-body">
                        <router-link :to="{ name: 'sliders_add' }" class="btn btn_info">{{ trans('admin.form.sliders.add_new_slider') }}</router-link>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ trans('admin.form.sliders.sliders') }}</div>
                    </div>
                    <div class="card-body">
                        <table class="table table_bordered table_center table_fixed">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('admin.form.sliders.heading') }}</th>
                                <th>{{ trans('admin.form.sliders.text') }}</th>
                                <th>{{ trans('admin.form.sliders.url') }}</th>
                                <th>{{ trans('admin.form.sliders.image') }}</th>
                                <th>{{ trans('admin.label.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(slider, i) in sliders" :key="'career_'+i">
                                <td>{{ i+1 }}</td>
                                <td>{{ slider.heading }}</td>
                                <td>{{ slider.text }}</td>
                                <td>{{ slider.url }}</td>
                                <td><img width="150px" :src="slider.image" alt=""></td>
                                <td>
                                    <router-link class="btn btn_blue" :to="{name:'sliders_edit', params:{id: slider.id}}"><i class="bx bx-edit-alt"></i></router-link>
                                    <button class="btn btn_danger" @click.prevent="deleteItem(slider)"><i class='bx bxs-trash'></i></button>
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
            sliders:[]
        }
    },
    created() {
        this.getSliders();
    },
    methods: {
        getSliders(){
            axios.get('/api/admin/sliders') .then((response) => { this.sliders = response.data.data; })
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
                    axios.delete('/api/admin/sliders/'+item.id).then(() => {
                        this.getSliders();
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
