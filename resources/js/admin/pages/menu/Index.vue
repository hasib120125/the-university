<template>
    <div class="row">
        <div class="col_3"></div>
        <div class="col_6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title width_full">
                        <div class="d_flex_btwn">
                            <div>{{ trans('admin.form.menu.menu') }}</div>
                            <button @click.prevent="addNewMenu()" class="btn btn_info">{{ trans('admin.form.menu.add_new_menu') }}</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col_12">
                            <draggable tag="ul" v-model="menuList" v-bind="dragOptions" class="width_full inside_custom_menu list-group">
                                <transition-group type="transition" :name="'flip-list'">
                                    <li :key="element.order" v-for="element in menuList" class="list-group-item">
                                        <a href="javascript:void(0)">
                                            <div class="d_flex_btwn width_full">
                                                <div>{{element.name_en}} / {{element.name_ko}}</div>
                                                <div>
                                                    <button class="btn btn_blue mr_2" @click.prevent="editMenu(element)"><i class='bx bxs-edit'></i></button>
                                                    <button class="btn btn_danger" @click.prevent="deleteItem(element)"><i class='bx bxs-trash'></i></button>
                                                    <button class="btn btn_success mr_2" @click.prevent="addNewMenu(element.id)">+</button>
                                                </div>
                                            </div>
                                        </a>

                                        <draggable v-if="element.subMenus.length > 0" tag="ul" class="inside_custom_menu mb_20 pl_20 width_full list-group" v-model="element.subMenus" v-bind="dragOptions">
                                            <transition-group type="transition" :name="'flip-list'">
                                                <li class="width_full list-group-item" v-for="sm in element.subMenus" :key="sm.order">
                                                    <a href="javascript:void(0)">
                                                        <div class="d_flex_btwn width_full">
                                                            <div>{{sm.name_en}} / {{sm.name_ko}}</div>
                                                            <div>
                                                                <button class="btn btn_blue mr_2" @click.prevent="editMenu(sm)"><i class='bx bxs-edit'></i></button>
                                                                <button class="btn btn_danger" @click.prevent="deleteItem(sm)"><i class='bx bxs-trash'></i></button>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                            </transition-group>
                                        </draggable>
                                    </li>
                                </transition-group>
                            </draggable>

                            <div class="d_flex_end mt_20">
                                <button  class="btn btn_md btn_success" @click.prevent="sortUpdate">{{ trans('admin.form.menu.sort_update') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" data-modal="modal" :class="{open_modal:modelOpen}">
            <div class="modal_overlay" data-modal-close="modal"></div>
            <div class="modal_inner">
                <div class="modal_header">
                    <span data-modal-close="modal" class="close_icon close_icon_sm" @click.prevent="closeModal">×</span>
                    <h2 v-if="modelStatus === 'add'">{{ trans('admin.form.menu.add_new_menu') }}</h2>
                    <h2 v-else>{{ trans('admin.form.menu.edit_menu') }}</h2>
                </div>
                <div class="modal_wrapper ">
                    <div class="modal_content modal_1080p">
                        <div class="container">
                            <div class="row">
                                <div class="col_6">
                                    <div class="form-group ">
                                        <label>{{ trans('admin.form.menu.name_en') }}</label>
                                        <input type="text" class="form_global"   v-model="form.name">
                                        <v-errors :errors="errorFor('name')"></v-errors>
                                    </div>
                                </div>
                                <div class="col_6">
                                    <div class="form-group ">
                                        <label>{{ trans('admin.form.menu.name_ko') }}</label>
                                        <input type="text" class="form_global"   v-model="form.name_ko">
                                        <v-errors :errors="errorFor('name_ko')"></v-errors>
                                    </div>
                                </div>

                                <div class="col_4">
                                    <div class="form-group mb_5 mt_15"><label class="pb_0">{{ trans('admin.form.menu.status') }}</label> </div>
                                    <div class="form_radio">
                                        <input type="radio" id="rest"  v-model="form.status" value="1">
                                        <label for="rest">{{ trans('admin.form.menu.active') }}</label>
                                    </div>
                                    <div class="form_radio">
                                        <input type="radio" id="go_out"  v-model="form.status" value="0">
                                        <label for="go_out">{{ trans('admin.form.menu.inactive') }}</label>
                                    </div>
                                    <v-errors :errors="errorFor('status')"></v-errors>
                                </div>
                            </div>
                            <div class="d_flex_end">
                                <button class="btn btn_secondary mr_5" @click.prevent="closeModal">{{ trans('admin.label.cancel') }}</button>
                                <button  class="btn btn_md btn_success" @click.prevent="addMenuSubmit">{{ trans('admin.label.save') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import validationErrors from "../../mixins/validationErrors";
import draggable from 'vuedraggable'

export default {
    mixins: [validationErrors],
    components: {
        draggable,
    },
    data() {
        return {
            form:{
                name: null,
                name_ko: null,
                menu_id: '',
                status: '',
            },
            menuList: [],
            modelOpen: false,
            modelStatus: null,
        }
    },
    created() {
        this.getMenus();
    },
    computed: {
        dragOptions() {
            return {
                animation: 0,
                ghostClass: "ghost"
            };
        },
    },
    methods: {
        getMenus(){
            axios.get('/api/admin/menus').then((response) => {
                this.menuList = response.data.data.map((menu, index) => {
                    let subMenus = menu.sub_menus.map((sm, index) => {
                        return { id: sm.id, name_ko:sm.name_ko, name_en:sm.name_en, status:sm.status, menu_id: sm.menu_id, name: sm.name, order: index + 1, fixed: false, can_delete:sm.can_delete };
                    });

                    return { id: menu.id, name_ko:menu.name_ko, name_en:menu.name_en, status:menu.status, name: menu.name, order: index + 1, fixed: false, can_delete: menu.can_delete ,subMenus };
                });
            })
        },
        closeModal(){
            this.modelOpen = false;
        },
        updateSort(){
            this.getMenus();
        },
        addMenuSubmit(){
            this.errors = null;
            let url = null;
            if(!this.form.menu_id)
                url = '/api/admin/menus';
            else
                url = '/api/admin/menus/'+this.form.menu_id+'/sub-menus';

            if(this.modelStatus == 'add'){
                if(!this.form.menu_id)
                    url = '/api/admin/menus';
                else
                    url = '/api/admin/menus/'+this.form.menu_id+'/sub-menus';

                axios.post(url, this.form)
                    .then((response) => {
                        this.modelOpen = false;
                        this.getMenus();
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);
            }
            if(this.modelStatus == 'edit'){
                if(!this.form.menu_id)
                    url = '/api/admin/menus/'+this.form.id;
                else
                    url = '/api/admin/menus/'+this.form.menu_id+'/sub-menus/'+this.form.id;

                axios.patch(url, this.form)
                    .then((response) => {
                        this.modelOpen = false;
                        this.getMenus();
                    })
                    .catch((err) => this.errors = err.response.data.errors)
                    .finally(() => this.loading = false);
            }
        },
        sortUpdate(){
            axios.post('/api/admin/menus/sort', {menu: this.menuList}).then(() => {
                this.$swal({
                    text: this.trans('common.message.sort_complete'),
                })
            })
        },
        addNewMenu(parent = null){
            this.form.menu_id = null;
            this.form.name = null;
            this.form.name_ko = null;
            this.form.status = null;
            if (parent)
                this.form.menu_id = parent;
            this.modelOpen = true;
            this.modelStatus = 'add';
        },
        editMenu(data){
            this.form = null;
            this.modelOpen = true;
            this.modelStatus = 'edit';
            this.form = {...data};
        },
        deleteItem(item) {

            if(!item.can_delete){
                this.$swal.fire(
                    this.trans("common.message.error"),
                    this.trans("common.message.menu_delete_error_message"),
                    "success"
                );

                return
            }
            
            let url = null;
            if(item.subMenus)
                url = '/api/admin/menus/'+item.id;
            else
                url = '/api/admin/menus/'+item.menu_id+'/sub-menus/'+item.id;
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
                    axios.delete(url).then((response) => {
                        this.getMenus();
                        this.$swal.fire(
                            this.trans('common.message.deleted'),
                            this.trans('common.message.delete_message'),
                            'success'
                        )
                    })

                }
            });
        }
    }
};
</script>

<style>
.inside_custom_menu span{
    width: 100%;
}
.flip-list-move {
    transition: transform 0.5s;
}
.no-move {
    transition: transform 0s;
}
.ghost {
    opacity: 0.5;
    background: #c8ebfb;
}
.list-group {
    min-height: 20px;
}
.list-group-item {
    cursor: move;
}
.list-group-item i {
    cursor: pointer;
}
</style>


