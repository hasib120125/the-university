<template>
    <div class="common_accordion" id="main_acc">
        <div class="table_responsive">
            <table class="custom_table">
                <thead>
                    <tr>
                        <!-- <th width="5%">{{ trans('front.static_pages.community.articles_publications.no') }}</th>
                        <th width="10%">{{ trans('front.static_pages.community.articles_publications.preview') }}</th>
                        <th>{{ trans('front.static_pages.community.articles_publications.read_more') }}</th> -->
                        <th width="5%"></th>
                        <th width="10%"></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody v-for="(article, articleIndex) in articles" :key="articleIndex">
                        <tr class="collapsed" data-toggle="collapse" :data-target="'#acc' + articleIndex" aria-expanded="true" :aria-controls="'#acc' + articleIndex">
                            <td>{{ articleIndex + 1}}</td>
                            <td><img src="/images/community/text_ico.gif" alt=""></td>
                            <td>{{ article.title }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="p_0">
                                <div :id="'acc' + articleIndex" class="collapse" data-parent="#main_acc">
                                    <div class="card-body">
                                        <div v-html="article.content"></div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                </tbody>
            </table>
        </div>
        
        <Pagination
			:paginateData="paginateData"
			v-if="paginateData"
			@paginate="changePage"
		/>

    </div>
</template>

<script>
    import Pagination from '../../../components/Pagination'
	export default {
        components: {
            Pagination
        },
		data() {
			return {
				articles: null,
                paginateData: null,
				page: 1,
			};
		},
        mounted() {
            this.getData()
        },
		methods: {
			getData() {
				axios
					.get("/api/article-publications?page=" + this.page)
					.then((response) => {
						this.articles = response.data.data;
						this.paginateData = response.data.meta;
					})
					.finally(() => (this.loading = false));
			},
            changePage(page){
                this.page = page
                this.getData()
            }
		}
	};
</script>
<style scoped>
    thead tr{
        height: 33px;
    }
</style>

