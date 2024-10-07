<template>
	<div>
		<p v-html="page.description"></p>
		<div class="common_tab" v-if="departmentOfPastoralMusics">
			<div>
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li
						class="nav-item"
						role="presentation"
						v-for="(
							departmentOfPastoralMusic, departmentOfPastoralMusicIndex
						) in departmentOfPastoralMusics"
						:key="'key' + departmentOfPastoralMusicIndex"
					>
						<a
							class="nav-link"
							:class="{ ' active': departmentOfPastoralMusicIndex == 0 }"
							:id="'bellow_' + departmentOfPastoralMusicIndex"
							data-toggle="tab"
							:href="'#bellow_' + departmentOfPastoralMusicIndex + '-tab'"
							role="tab"
							:aria-controls="'bellow_' + departmentOfPastoralMusicIndex"
							aria-selected="true"
							>{{ departmentOfPastoralMusic.title }}</a
						>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent">
					<template
						v-for="(
							departmentOfPastoralMusic, departmentOfPastoralMusicIndex
						) in departmentOfPastoralMusics"
					>
						<div
							class="tab-pane fade show"
							:class="{ ' active': departmentOfPastoralMusicIndex == 0 }"
							:id="'bellow_' + departmentOfPastoralMusicIndex + '-tab'"
							role="tabpanel"
							:aria-labelledby="
								'bellow_' + departmentOfPastoralMusicIndex
							"
							:key="
								'key' + departmentOfPastoralMusicIndex
							"
						>
							<div
								class="inner"
								v-html="departmentOfPastoralMusic.content"
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
				departmentOfPastoralMusics: null,
			};
		},
		mounted() {
			this.getData();
		},
		methods: {
			getData() {
				axios
					.get("/api/department-of-pastoral-music")
					.then((response) => {
						this.departmentOfPastoralMusics = response.data.data;
					})
					.finally(() => (this.loading = false));
			},
		},
	};
</script>
