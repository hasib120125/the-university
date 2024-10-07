<template>
    <div class="row">
        <div class="col_12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ pageName }}</div>
                </div>
                <div :class="['card-body', {'loading_overlay': loading}]">
                    <div class="row">
                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.pages.menu') }}</label>
                                <select class="form_global" id="menu" v-model="form.menu_id" @change="selectSubmenu">
                                    <option value="">{{ trans('admin.form.pages.select_menu') }}</option>
                                    <option v-for="(menu, i) in menus" :key="'professor_'+i" :value="menu.id">
                                        {{ menu.name }}
                                    </option>
                                </select>
                                <v-errors :errors="errorFor('menu_id')"></v-errors>
                            </div>
                        </div>
                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.pages.sub_menu') }}</label>
                                <select class="form_global" id="submenu" v-model="form.sub_id">
                                    <option value="">{{ trans('admin.form.pages.select_sub_menu') }}</option>
                                    <option v-for="(submenu, i) in submenus" :key="'professor_'+i" :value="submenu.id">
                                        {{ submenu.name }}</option>
                                </select>
                                <v-errors :errors="errorFor('sub_id')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.pages.page_title_en') }}</label>
                                <input type="text" id="title"   class="form_global" :placeholder="trans('admin.form.pages.page_title_en')" v-model="form.title_en">
                                <v-errors :errors="errorFor('title_en')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.pages.page_title_ko') }}</label>
                                <input type="text" id="title_ko"   class="form_global" :placeholder="trans('admin.form.pages.page_title_ko')" v-model="form.title_ko">
                                <v-errors :errors="errorFor('title_ko')"></v-errors>
                            </div>
                        </div>

                        <div class="col_12">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.pages.page_content_en') }}</label>
                                <froala-text-editor :model.sync="form.description_en" :deleteImages.sync="deleteImages"/>
                                <v-errors :errors="errorFor('description_en')"></v-errors>
                            </div>
                        </div>

                        <div class="col_12">
                            <div class="form-group ">
                                <label>{{ trans('admin.form.pages.page_content_ko') }}</label>
                                <froala-text-editor :model.sync="form.description_ko" :deleteImages.sync="deleteImages"/>
                                <v-errors :errors="errorFor('description_ko')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.pages.meta_title') }}</label>
                                <input type="text" id="meta_title"   class="form_global" :placeholder="trans('admin.form.pages.meta_title')" v-model="form.meta_title">
                                <v-errors :errors="errorFor('meta_title')"></v-errors>
                            </div>
                        </div>

                        <div class="col_6">
                            <div class="form-group">
                                <label>{{ trans('admin.form.pages.meta_description') }}</label>
                                <input type="text" id="meta_description"   class="form_global" :placeholder="trans('admin.form.pages.meta_description')" v-model="form.meta_description">
                                <v-errors :errors="errorFor('meta_description')"></v-errors>
                            </div>
                        </div>
                        <div class="col_4">
                            <div class="form-group mb_5 mt_15 "><label class="pb_0"> {{ trans('admin.form.pages.status') }} </label> </div>
                            <div class="form_radio">
                                <input type="radio" id="active"  v-model="form.status" value="1">
                                <label for="active">{{ trans('admin.form.pages.active') }}</label>
                            </div>
                            <div class="form_radio">
                                <input type="radio" id="inactive"  v-model="form.status" value="0">
                                <label for="inactive">{{ trans('admin.form.pages.inactive') }}</label>
                            </div>
                            <v-errors :errors="errorFor('status')"></v-errors>
                        </div>
                    </div>

                    <div class="d_flex_end">
                        <router-link class="btn btn_secondary mr_5" :to="{name: 'pages'}">{{ trans('admin.label.cancel') }}</router-link>
                        <button class="btn btn_md btn_success" @click.prevent="submitForm">{{ trans('admin.label.save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import validationErrors from "../../mixins/validationErrors";
import FroalaTextEditor from "./../../components/FroalaTextEditor";

export default {
    mixins: [validationErrors],
    components: {FroalaTextEditor},
    data(){
        return {
            deleteImages: [],
            form: {
                menu_id: '',
                sub_id: '',
                title_en: null,
                title_ko: null,
                description_en: '',
                description_ko: '',
                meta_title: '',
                meta_description: '',
                status: '',
                confirm_updte: 0,
            },
            
            pageName: this.trans('admin.form.pages.add_new_page'),
            menus:[],
            submenus:[],

        }
    },
    created() {
        axios.get('/api/admin/menus').then((response) => { this.menus = response.data.data;})
        if (this.$route.name === 'pages_edit') {
            this.loading = true;
            this.pageName = this.trans('admin.form.pages.edit_page');
            axios.get('/api/admin/pages/'+ this.$route.params.id)
                .then((response) => {
                    this.form = response.data.data;
                    this.form.menu_id = response.data.data.menu.id;
                    this.form.sub_id = response.data.data.submenu ? response.data.data.submenu.id : '';
                    this.selectSubmenu();
                }).finally(() => this.loading = false);
        }
    },
    methods: {
        submitForm(){
            this.loading = true;
            this.errors = null;
            if (this.$route.name === 'pages_edit') {
                axios.patch('/api/admin/pages/'+ this.$route.params.id, this.form)
                    .then((response) => {
                        this.$router.push({name: 'pages'});
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);

            }else{
                axios.post('/api/admin/pages', this.form)
                    .then((response) => {
                        if(response.data.success == false){
                            this.$swal({
                                text: response.data.message,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: this.trans('admin.label.yes_delete'),
                                cancelButtonText: this.trans('admin.label.no_cancel'),
                                reverseButtons: true
                            }).then((result) => {
                                this.form.confirm_updte = 1;
                                 this.submitForm();
                            });

                        }else{
                            this.$router.push({name: 'pages'});
                        }
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);
            }

            axios.post('/api/admin/delete/image', {images: this.deleteImages});
        },
        selectSubmenu(){
            let searOutMenu = this.menus.find(element => element.id === this.form.menu_id)
            this.submenus = searOutMenu.sub_menus;
        },
        
    },
}
</script>


