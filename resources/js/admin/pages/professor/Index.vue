<template>
    <div>
        <div class="row">
            <div class="col_12">
                <div class="card">
                    <div class="card-body">
                        <router-link :to="{ name: 'professors_add' }" class="btn btn_info">{{ trans('admin.form.professors.add_new_professor') }}</router-link>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col_12">
                <div :class="['card', {'loading_overlay': loading}]">
                    <div class="card-header d_flex_btwn width_full">
                        <div class="card-title">{{ trans('admin.form.professors.professors') }}</div>
                        <div class="custom_upload">
                            <button class="btn btn_success"><span class="mr_5"><i class="fas fa-file-import"></i></span> {{ trans('admin.form.professors.import_professor') }}</button>
                            <input type="file" name="upload_file" id="importProfesors" accept=".xlsx, .csv,text/csv, application/excel, application/vnd.ms-excel, application/vnd.msexce" @change="importProfesors" />
                        </div>
                    </div>
                    <div class="card-body">
                        <table-component api-url="/api/admin/professors"
                                         :fields="fields"
                                         ref="tableComponent"
                                         :sort-order="sortOrder" @delete="deleteItem">
                        </table-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import TableComponent from "./../../components/TableComponent";
import XLSX from 'xlsx'

export default {
    components: {
        TableComponent
    },
    data() {
        return {
            fields: [
                {
                    name: 'name',
                    title: this.trans('common.index.name'),
                    sortField: this.locale === 'en' ? 'name_english' : 'name_hangul',
                    searchable: true
                },
                {
                    name: 'customSubject.name',
                    title: this.trans('admin.form.professors.subject'),
                    sortField: 'customSubject.name',
                    searchable: true
                },
                {
                    name: 'email',
                    title: this.trans('admin.form.professors.email'),
                    sortField: 'email',
                    searchable: true
                },
                {
                    name: 'mobile',
                    title: this.trans('admin.form.professors.contact'),
                    sortField: 'mobile',
                    searchable: true
                },


                {
                    name: 'action-slot',
                    title: this.trans('admin.label.action'),
                    searchable: false,
                    data: [
                        {
                            class: 'btn btn_sm btn_info mr_5',
                            title: '<i class="far fa-edit"></i>',
                            tooltip: this.trans('admin.label.edit'),
                            route: 'professors_edit',
                            params: {id: 'id'}
                        },
                        {
                            class: 'btn btn_sm btn_danger',
                            title: '<i class="far fa-trash-alt"></i>',
                            tooltip: this.trans('admin.label.delete'),
                            action: 'delete'
                        }
                    ]
                }
            ],
            sortOrder: [],
            loading: false,
        }
    },
    methods: {
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
                    axios.delete('/api/admin/professors/'+item.id).then(() => {
                        this.$refs.tableComponent.refresh();
                        this.$swal.fire(
                            this.trans('common.message.deleted'),
                            this.trans('common.message.delete_message'),
                            'success'
                        )
                    });
                }
            });
        },
        async importProfesors(e) {
            if (await this.checkFileTypeExcel() == false) {
                document.getElementById("importProfesors").value = null;
                return
            }

            if (await this.takeConfirmation() == false) {
                document.getElementById("importProfesors").value = null;
                return
            }

            var file = e.target.files[0]

            this.loading = true
            let formData = new FormData()

            formData.append('file', e.target.files[0]);
            axios.post('/api/admin/professors/import', formData).then((response) => {
                    this.$refs.tableComponent.refresh();
                    this.$swal.fire(
                        this.trans('common.message.success'),
                        response.data.message,
                        'success'
                    )

                })
                .catch((err) => {
                    this.$swal.fire(
                        this.trans('common.message.error'),
                        this.trans('common.message.something_wrong'),
                        'error'
                    )
                })
                .finally(() => this.loading = false);

            document.getElementById("importProfesors").value = null;
            return
        },
        async takeConfirmation(){
            let confirm = false
            await this.$swal({
                title: this.trans('admin.label.import_confirmation'),
                text: this.trans('admin.label.warning'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: this.trans('admin.label.yes_import'),
                cancelButtonText: this.trans('admin.label.no_cancel'),
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    confirm = true
                }
            })

            return confirm
        },
        checkFileTypeExcel() {
            let validExts = new Array(".xlsx", ".xls", ".csv")
            let fileExt = document.getElementById("importProfesors").value

            fileExt = fileExt.substring(fileExt.lastIndexOf('.'))
            if (validExts.indexOf(fileExt) < 0) {
                toast.fire({
                    icon: 'error',
                    title: "Invalid file selected, valid files are of " + validExts.toString() + " types."
                })
                return false;
            }
            else return true;
        },
    }
}
</script>

