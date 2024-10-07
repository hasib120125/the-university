<template>
	<div>
		<p v-html="page.description"></p>
		<div class="common_tab" v-if="ministryOfMinistrys">
			<div>
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li
						class="nav-item"
						role="presentation"
						v-for="(
							ministryOfMinistry, ministryOfMinistryIndex
						) in ministryOfMinistrys"
						:key="'ministry-of-ministry' + ministryOfMinistryIndex"
					>
						<a
							class="nav-link"
							:class="{ ' active': ministryOfMinistryIndex == 0 }"
							:id="'above_' + ministryOfMinistryIndex"
							data-toggle="tab"
							:href="'#above_' + ministryOfMinistryIndex + '-tab'"
							role="tab"
							:aria-controls="'above_' + ministryOfMinistryIndex"
							aria-selected="true"
							>{{ ministryOfMinistry.title }}</a
						>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent">
					<template
						v-for="(
							ministryOfMinistry, ministryOfMinistryIndex
						) in ministryOfMinistrys"
					>
						<div
							class="tab-pane fade show"
							:class="{ ' active': ministryOfMinistryIndex == 0 }"
							:id="'above_' + ministryOfMinistryIndex + '-tab'"
							role="tabpanel"
							:aria-labelledby="
								'above_' + ministryOfMinistryIndex
							"
							:key="
								'ministry-of-ministry' + ministryOfMinistryIndex
							"
						>
							<div
								class="inner"
								v-html="ministryOfMinistry.content"
							></div>
						</div>
					</template>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
	export default {
		props: {
			page: {
				type: Object,
				required: true,
				default: {},
			},
		},
		data() {
			return {
				ministryOfMinistrys: null,
			};
		},
		mounted() {
			this.getData();
		},
		methods: {
			getData() {
				axios
					.get("/api/ministry-of-ministry")
					.then((response) => {
						this.ministryOfMinistrys = response.data.data;
					})
					.finally(() => (this.loading = false));
			},
		},
	};
</script>
