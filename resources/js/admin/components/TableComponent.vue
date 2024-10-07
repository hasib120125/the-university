<template>
    <div>
        <div class="d_flex_end" v-if="showSearch">
            <div class="datable_search mb_15">
                <input class="form_global width_200p " type="text" v-model="search">
            </div>
        </div>
        <vuetable ref="vuetable"
                  :api-url="apiUrl"
                  :fields="fields"
                  :css="css.table"
                  :sort-order="sortOrder"
                  pagination-path="meta"
                  :per-page="perPage"
                  :query-params="makeQueryParams"
                  :http-options="httpOptions"
                  :no-data-template="trans('common.index.no_data')"
                  @vuetable:pagination-data="onPaginationData">

            <div slot="file_attachment1" slot-scope="props">
                <span class="attachment">
                    <a v-if="props.rowData.attachment1" class="color_info"
                               :href="props.rowData.attachment1"
                               :download="props.rowData.attachment1_original_filename"><i class="fas fa-download"></i> {{ props.rowData.attachment1_original_filename }}</a>
                </span>
            </div>
            <div slot="file_attachment2" slot-scope="props">
                <span class="attachment">
                    <a v-if="props.rowData.attachment2" class="color_info"
                               :href="props.rowData.attachment2"
                               :download="props.rowData.attachment2_original_filename"><i class="fas fa-download"></i> {{ props.rowData.attachment2_original_filename }}</a>
                </span>
            </div>

            <template slot="action-slot" slot-scope="props">
                <template v-for="(item, i) in fields.find(x => x.name === 'action-slot').data">
                    <a :class="item.class" v-if="(item.customLink && item.path)" :href="generateLink(props.rowData, item.path , item.params)" :key="'action_'+i" v-html="item.title" :title="item.tooltip"></a>
                    <router-link :class="item.class"
                                 v-else-if="(item.route && !item.condition) || (item.route && item.condition && props.rowData[item.condition[0]] === item.condition[1])"
                                 :to="{name: item.route, params: generateParams(props.rowData, item.params)}"
                                 :key="'action_'+i" v-html="item.title" :title="item.tooltip">
                    </router-link>

                    <button v-else-if="!item.condition || (item.condition && props.rowData[item.condition[0]] === item.condition[1])"
                            :class="item.class"
                            :key="'action_'+i"
                            @click.prevent="$emit(item.action, props.rowData)"
                            v-html="item.title"
                            :title="item.tooltip">
                    </button>
                </template>
            </template>
        </vuetable>

        <div class="row" v-show="showPaginate">
            <div class="col_6">
                <vuetable-pagination-info ref="paginationInfo" :info-template="infoTemplate" :no-data-template="noDataTemplate"></vuetable-pagination-info>
            </div>

            <div class="col_6 d_flex_end">
                <vuetable-pagination-dropdown ref="pagination"
                                              :css="css.pagination"
                                              :page-text="pageText"
                                              @vuetable-pagination:change-page="onChangePage">
                </vuetable-pagination-dropdown>
            </div>
        </div>
    </div>
</template>

<script>
import Vuetable from 'vuetable-2'
import VuetablePaginationDropdown  from 'vuetable-2/src/components/VuetablePaginationDropdown'
import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo';
import VuetableFieldMixin from 'vuetable-2/src/components/VuetableFieldMixin';

export default {
    components: {
        Vuetable,
        VuetableFieldMixin,
        VuetablePaginationDropdown,
        VuetablePaginationInfo
    },
    props: {
        fields: {
            type: Array,
            required: false,
            default: []
        },
        sortOrder: {
            type: Array,
            required: false,
            default: []
        },
        apiUrl: {
            type: String,
            required: true,
        },
        perPage: {
            type: Number,
            required: false,
            default: 10
        },
        showSearch: {
            type: Boolean,
            required: false,
            default: true
        },
        showPaginate: {
            type: Boolean,
            required: false,
            default: true
        },
    },
    data() {
        return {
            search: '',
            infoTemplate: this.trans('common.index.total_data'),
            noDataTemplate: this.trans('common.index.no_relevant_data'),
            pageText: this.trans('common.index.page'),
            httpOptions: {
                headers: {
                    'Authorization': `Bearer ${this.$store.state.user.token}`
                }
            },
            css: {
                table: {
                    loadingClass: 'loading',
                    tableBodyClass: 'table table_bordered table_fixed table_center',
                    ascendingIcon: 'fas fa-sort-amount-up-alt',
                    descendingIcon: 'fas fa-sort-amount-down',
                    ascendingClass: 'sorted-asc',
                    descendingClass: 'sorted-desc',
                    sortableIcon: 'fas fa-sort',
                },
                pagination: {
                    wrapperClass: 'ui right floated pagination menu d_flex_center',
                    activeClass: 'active large',
                    disabledClass: 'disabled',
                    pageClass: 'item',
                    linkClass: 'icon item',
                    paginationClass: 'ui bottom attached segment grid',
                    paginationInfoClass: 'left floated left aligned six wide column',
                    dropdownClass: 'form_global',
                    icons: {
                        prev: 'lni lni-chevron-left',
                        next: 'lni lni-chevron-right',
                    }
                },
            }
        }
    },
    watch: {
        search() {
            this.$refs.vuetable.refresh();
        }
    },
    methods: {
        refresh() {
            this.$refs.vuetable.refresh();
        },
        onPaginationData(paginationData) {
            this.$refs.pagination.setPaginationData(paginationData);
            this.$refs.paginationInfo.setPaginationData(paginationData);
        },
        onChangePage(page) {
            this.$refs.vuetable.changePage(page);
        },
        makeQueryParams (sortOrder, currentPage, perPage) {
            let searchColumns = [];

            this.fields.forEach(item => {
                if (item.searchable)
                    searchColumns.push(item.sortField);
            });

            return {
                sort: sortOrder.length ? sortOrder[0].field : '',
                sort_order: sortOrder.length ? sortOrder[0].direction : '',
                page: currentPage,
                per_page: perPage,
                search: this.search,
                search_columns: searchColumns.join(',')
            }
        },
        generateLink(data, path ,payload) {
            let keys = Object.keys(payload);

            keys.forEach((key) => {
                path = path.replace(key, data[payload[key]]);
            });

            return path;
        },
        generateParams(data, payload) {
            let params = {};
            let keys = Object.keys(payload);

            keys.forEach((key) => {
                params[key] = data[payload[key]];
            });

            return params;
        }
    }
}
</script>

<style>
.attachment {
    width: 100%;
    display: inline-block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>
