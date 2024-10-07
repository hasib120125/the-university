<template>
    <div class="inner overview" v-if="subject">
        <div class="table_responsive">
            <table class="table">
                <tr>
                    <td>{{ trans('new.index.subject_details.name') }}</td>
                    <td>{{ subject.name }}</td>
                </tr>
                <tr>
                    <td>{{ trans('new.index.subject_details.department') }}</td>
                    <td>{{ subject.allDepartmentsName }}</td>
                </tr>
                <tr>
                    <td>{{ trans('new.index.subject_details.code') }}</td>
                    <td>{{ subject.code }}</td>
                </tr>
                <tr>
                    <td>{{ trans('new.index.subject_details.credit') }}</td>
                    <td>{{ subject.credit }}</td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>

export default {
    props: ['subject'],
}
</script>
