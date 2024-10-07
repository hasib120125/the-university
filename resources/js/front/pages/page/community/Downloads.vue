<template>
    <div class="common_accordion" id="main_acc">
        <div class="table_responsive">
            <table class="custom_table">
                <thead>
                    <tr>
                        <!-- <th width="5%">{{ trans('front.static_pages.community.download.no') }}</th>
                        <th width="10%">{{ trans('front.static_pages.community.download.file') }}</th>
                        <th>{{ trans('front.static_pages.community.download.read_more') }}</th> -->
                        <th width="5%"></th>
                        <th width="10%"></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody v-for="(download, downloadIndex) in downloads" :key="downloadIndex">
                        <tr class="collapsed" data-toggle="collapse" :data-target="'#acc' + downloadIndex" aria-expanded="true" :aria-controls="'#acc' + downloadIndex">
                            <td>{{ downloadIndex + 1}}</td>
                            <td><img src="/images/community/ic_attach.gif" alt=""></td>
                            <td>{{ download.title }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="p_0">
                                <div :id="'acc' + downloadIndex" class="collapse" data-parent="#main_acc">
                                    <div class="card-body">
                                        <table class="custom_table table_bordered" style="width: 100%;">
                                            <tr>
                                                <th style="width: 33.3333%;">{{ trans('front.static_pages.community.download.title') }}<br></th>
                                                <td style="width: 33.3333%;">{{ download.title }}<br></td>
                                            </tr>
                                            <tr>
                                                <th style="width: 33.3333%;">{{ trans('front.static_pages.community.download.attachments') }}<br></th>
                                                <td style="width: 33.3333%;">
                                                    <a :href="download.file_path" download>{{ trans('front.static_pages.community.download.download') }}</a>
                                                </td>
                                            </tr>
                                        </table>
                                        <div v-html="download.content"></div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                </tbody>
            </table>
        </div>
        <Pagination
            :paginateData="paginateData"
            v-if="paginateData && paginateData.total > paginateData.per_page"
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
				downloads: null,
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
					.get("/api/downloads?page=" + this.page)
					.then((response) => {
						this.downloads = response.data.data;
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
