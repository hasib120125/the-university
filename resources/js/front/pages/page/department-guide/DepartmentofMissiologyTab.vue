<template>
	<div>
		<p v-html="page.description"></p>
		<div class="common_tab" v-if="departmentOfMissiologys">
			<div>
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li
						class="nav-item"
						role="presentation"
						v-for="(
							departmentOfMissiology, departmentOfMissiologyIndex
						) in departmentOfMissiologys"
						:key="'key' + departmentOfMissiologyIndex"
					>
						<a
							class="nav-link"
							:class="{ ' active': departmentOfMissiologyIndex == 0 }"
							:id="'bellow_' + departmentOfMissiologyIndex"
							data-toggle="tab"
							:href="'#bellow_' + departmentOfMissiologyIndex + '-tab'"
							role="tab"
							:aria-controls="'bellow_' + departmentOfMissiologyIndex"
							aria-selected="true"
							>{{ departmentOfMissiology.title }}</a
						>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent">
					<template
						v-for="(
							departmentOfMissiology, departmentOfMissiologyIndex
						) in departmentOfMissiologys"
					>
						<div
							class="tab-pane fade show"
							:class="{ ' active': departmentOfMissiologyIndex == 0 }"
							:id="'bellow_' + departmentOfMissiologyIndex + '-tab'"
							role="tabpanel"
							:aria-labelledby="
								'bellow_' + departmentOfMissiologyIndex
							"
							:key="
								'key' + departmentOfMissiologyIndex
							"
						>
							<div
								class="inner"
								v-html="departmentOfMissiology.content"
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
				departmentOfMissiologys: null,
			};
		},
		mounted() {
			this.getData();
		},
		methods: {
			getData() {
				axios
					.get("/api/department-of-missiology")
					.then((response) => {
						this.departmentOfMissiologys = response.data.data;
					})
					.finally(() => (this.loading = false));
			},
		},
	};
</script>
