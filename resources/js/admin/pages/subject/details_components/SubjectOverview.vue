<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ trans('admin.form.subject.subject_overview') }}</div>
                </div>
                <div class="card-body" v-if="subject">
                    <table class="table table_bordered table_center table_fixed">
                        <tr>
                            <th>{{ trans('admin.form.subject.name') }}</th>
                            <td>{{ subject.name }}</td>
                            <th>{{ trans('admin.form.subject.code') }}</th>
                            <td>{{ subject.code }}</td>
                            <th>{{ trans('admin.form.subject.credit') }}</th>
                            <td>{{ subject.credit }}</td>
                            <th>{{ trans('admin.form.subject.department') }}</th>
                            <td>{{ subject.allDepartmentsName }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    components: {
    },
    data() {
        return {
            subject: null,
            
        }
    },
    created() {
        axios.get('/api/admin/subjects/' + this.$route.params.id)
            .then((response) => { this.subject = response.data.data })
    },
    methods:{
        
    }
}
</script>
