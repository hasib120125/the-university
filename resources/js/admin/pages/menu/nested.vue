<template>
    <draggable
        v-bind="dragOptions"
        tag="ul"
        :class="'inside_custom_menu'"
        :list="list"
        :value="value"
        @input="emitter"
    >
        <li :key="menu.id" v-for="menu in menus">
            <div class="d_flex_btwn">
                <a href="#">{{ menu.name }} </a>
                <button class="btn btn_blue" @click.prevent="updateMenu(menu)"><i class='bx bxs-edit'></i></button>
                <button class="btn btn_danger ml_5" @click.prevent="deleteMenu(menu)"><i class='bx bxs-trash'></i></button>
            </div>
            <nested :list="menu.submenu" />
        </li>
    </draggable>
</template>

<script>
import draggable from 'vuedraggable'
export default {
    name: "nested",
    data() {
        return {
            sortMenus: []
        }
    },
    methods: {
        emitter(value) {
            axios.post('/api/admin/menus/sort', {menu: value}).then(() => {
                // this.$emit('update-sort', null);
            })
        },
        updateMenu(data){
            this.$emit('edit-menu', data);
        },
        deleteMenu(data){
            this.$emit('delete-menu', data);
        },
    },
    components: {
        draggable
    },
    computed: {
        dragOptions() {
            return {
                animation: 0,
                group: "description",
                disabled: false,
                ghostClass: "ghost"
            };
        },

        menus() {
            return this.value ? this.value : this.list;
        }
    },
    props: {
        value: {
            required: false,
            type: Array,
            default: null
        },
        list: {
            required: false,
            type: Array,
            default: null
        }
    }
};
</script>

<style scoped>
    .inside_custom_menu li ul {
        margin-left: 30px;
    }
</style>
