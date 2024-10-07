<template>
    <div class="common_tab" v-if="academicRegulations">
        <div>
			<ul class="nav nav-tabs" id="myTab" role="tablist" >
				<li class="nav-item" role="presentation" v-for="(academicRegulation , academicRegulationIndex) in academicRegulations" :key="'academic-regulation' + academicRegulationIndex">
					<a class="nav-link" :class="{' active' : academicRegulationIndex == 0}" :id="'bellow_' + academicRegulationIndex" data-toggle="tab" 
						:href="'#bellow_' + academicRegulationIndex +'-tab'" role="tab" :aria-controls="'bellow_' + academicRegulationIndex"
						aria-selected="true">{{ academicRegulation.title }}</a>
				</li>
			</ul>
			<div class="tab-content" id="myTabContent">
				<template v-for="(academicRegulation , academicRegulationIndex) in academicRegulations">
					<div class="tab-pane fade show" :class="{' active' : academicRegulationIndex == 0}" :id="'bellow_' + academicRegulationIndex + '-tab'" role="tabpanel"
					 :aria-labelledby="'bellow_' + academicRegulationIndex"  :key="'academic-regulation' + academicRegulationIndex">
						<div class="inner" v-html="academicRegulation.content"></div>
					</div>
				</template>
			</div>
		</div>
    </div>
</template>
<script>
	export default {
		data() {
			return {
				academicRegulations: null,
			};
		},
		mounted() {
			this.getData();
		},
		methods: {
			getData() {
				axios
					.get("/api/academic-regulation")
					.then((response) => {
						this.academicRegulations = response.data.data;
					})
					.finally(() => (this.loading = false));
			},
		},
	};
</script>
