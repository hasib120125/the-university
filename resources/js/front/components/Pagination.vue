<template>
    <div v-if="paginateData.total > 0">
        <div class="row">
			<div class="col-12">
				<div class="pagination_global mb_20">
                    <ul>
                        <li :class="{'disabled': paginateData.current_page == 1}">
                            <template v-if="paginateData.current_page == 1">
                                <i class="las la-arrow-left"></i>
                            </template>
                            <a href="javascript:void(0)" v-else @click="changePage(Number(paginateData.current_page) - 1)">
                                <i class="las la-arrow-left"></i>
                            </a>
                        </li>
                        <li class="disabled" v-if="paginateData.last_page > 3 && paginateData.current_page > 2 && paginateData.current_page <= paginateData.last_page">...</li>

                        <li v-for="page in pagesNumber" :class="{'active' : (page == paginateData.current_page) || (pagesNumber.length == 1)}" :key="'pagination-' + page">
                            <a v-if="(page == paginateData.current_page) || (pagesNumber.length == 1)">
                                {{ page }}
                            </a>
                            <a href="javascript:void(0)" v-else @click="changePage(page)">
                                {{ page }}
                            </a>
                        </li>
                        
                        <li class="disabled" v-if="paginateData.last_page > 3 && paginateData.current_page <= paginateData.last_page-2">...</li>

                        <li :class="{'disabled': paginateData.current_page == paginateData.last_page}">
                            <template v-if="paginateData.current_page == paginateData.last_page">
                                <i class="las la-arrow-right"></i>
                            </template>
                            <a href="javascript:void(0)" v-else  @click="changePage(Number(paginateData.current_page) + 1)">
                                <i class="las la-arrow-right"></i>
                            </a>
                        </li>
                    </ul>
				</div>
			</div>
		</div>
    </div>
</template>

<script>
export default {
    name: 'pagination-component',
    props: {
        paginateData: {
            type: Object,
            required: true
        }
    },
    computed: {
        pagesNumber() {
            var pagesArray = [];
            
            var start = Math.max(1, this.paginateData.current_page - 1);
            var end = Math.min(this.paginateData.current_page + 1, this.paginateData.last_page);            

            if (this.paginateData.current_page == 1) {
                start = 1;
                end = Math.min(3, this.paginateData.last_page);
            }
            if (this.paginateData.current_page == 2) {
                start = 1;
                end = Math.min(3, this.paginateData.last_page);
            }
            if (this.paginateData.current_page >= 2  && this.paginateData.current_page <= this.paginateData.last_page-1) {
                start = Number(this.paginateData.current_page) - 1;
                end = Number(this.paginateData.current_page) + 1;
            }
            if (this.paginateData.current_page == this.paginateData.last_page - 1) {
                start = Math.max((this.paginateData.last_page - 2), 1);
                end = this.paginateData.last_page;
            }
            if (this.paginateData.current_page >= this.paginateData.last_page) {
                start = Math.max((this.paginateData.last_page - 2), 1);
                end = this.paginateData.last_page;
            }
            for (var i = start; i <= end; i++) {
                pagesArray.push(i);
            }
            return pagesArray;
        },
    },
    methods: {
        changePage(page) {
            this.$emit('paginate' , page)
        }
    }
}
</script>