<template>
	<div class="common_accordion" v-if="counsellings">
		<div
			class="card"
			v-for="(counselling, counsellingIndex) in counsellings"
			:key="counsellingIndex"
		>
			<div class="card-header" :id="'h' + counsellingIndex">
				<button
					class="btn btn-link collapsed"
					data-toggle="collapse"
					:data-target="'#acc' + counsellingIndex"
					aria-expanded="false"
					:aria-controls="'collapse' + counsellingIndex"
				>
					<span class="fw_600">Q.</span> {{ counselling.id }}
					{{ counselling.question }}
				</button>
			</div>

			<div
				:id="'acc' + counsellingIndex"
				class="collapse"
				:aria-labelledby="'h' + counsellingIndex"
			>
				<div class="card-body">
					<div v-html="counselling.answer"></div>
				</div>
			</div>
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
				counsellings: null,
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
					.get("/api/admission-counselling?page=" + this.page)
					.then((response) => {
						this.counsellings = response.data.data;
						this.paginateData = response.data.meta;
					})
					.finally(() => (this.loading = false));
			},
            changePage(page){
                this.page = page
                this.getData()
            }
		},
	};
</script>
