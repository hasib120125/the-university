<template>
	<div>
		<div class="common_tab" v-if="subjects">
			<div>
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li
						class="nav-item"
						role="presentation"
						v-for="(subject, subjectIndex) in subjects"
						:key="'key' + subjectIndex"
						@click="tabChange"
					>
						<a
							class="nav-link"
							:class="{
								' active':
									Object.keys(subjects)[0] ==
									subjectIndex,
							}"
							:id="'above_' + subjectIndex"
							data-toggle="tab"
							:href="'#above_' + formatString(subjectIndex) + '-tab'"
							role="tab"
							:aria-controls="'above_' + subjectIndex"
							aria-selected="true"
							>{{ subjectIndex }}</a
						>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent">
					<template
						v-for="(subject, subjectIndex) in subjects"
					>
						<div
							class="tab-pane fade show"
							:class="{
								' active':
									Object.keys(subjects)[0] ==
									subjectIndex,
							}"
							:id="'above_' + formatString(subjectIndex) + '-tab'"
							role="tabpanel"
							:aria-labelledby="'above_' + subjectIndex"
							:key="'key' + subjectIndex"
						>
							<div class="inner">
								<div class="hover_tab">
									<ul class="heading">
										<li v-for="(professor, professorIndex) in subject"
										@mouseover="toggleProfessor('professor' + professorIndex + subjectIndex)" :key="'tab-li' + professorIndex" >
											{{ professor.name }}
										</li>
									</ul>
									<div class="hover_content">
										<div class="short_info prefessor_intro" v-show="professorIndex == 0" :id="'professor' + professorIndex + subjectIndex"
												v-for="(professor, professorIndex) in subject" :key="professorIndex + subjectIndex">
											<div class="inner ">
												<div class="img">
													<img :src="professor.photo" alt="" class="img-fluid">
													<span>
														{{ professor.name }}
													</span>
												</div>
												<div class="short_desc" v-html="professor.details"></div>

											</div>
											<div class="loadDetails">
												<button @click="lodaMore(professor)" class="btn common_btn width_auto">Load More</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</template>
				</div>
			</div>
		</div>
		<div :class="['modal', {'open_modal': showModal}]">
			<div class="modal_overlay" data-modal-close="modal" @click="closeLoadMore"></div>
			<div class="modal_inner">
				<!-- <span data-modal-close="modal" class="close_icon close_icon_sm" @click="closeLoadMore"></span> -->
				<div class="modal_wrapper modal_1080p">
					<div class="modal_content">
						<img :src="professorDetailsImage" alt="">
					</div>
				</div>
			</div>
		</div>

	</div>
</template>

<script>
	export default {
		data() {
			return {
				currentId: null,
				subjects: null,
				showModal: false,
				professorDetailsImage: false,
			};
		},
		created() {
			this.getData();
		},
		methods: {
			lodaMore(professor){
				this.showModal = true
				this.professorDetailsImage = professor.details_image
			},
			closeLoadMore(){
				this.showModal = false
			},
			getData() {
				axios
					.get("/api/professors")
					.then((response) => {
						this.subjects = response.data;
					})
					.finally(() => (this.loading = false));
			},
			formatString(subjectIndex){
				return subjectIndex.replace(/\//g, '')
			},
			tabChange() {
				let commonAccordions =
					document.getElementsByClassName("hover_content");

				for (var i = 0; i < commonAccordions.length; i++) {
					commonAccordions[i].firstElementChild.style.display = "flex";
				}
			},
			toggleProfessor(id) {
				if (this.currentId && this.currentId !== id) {
					var element = document.querySelector(
						`[aria-labelledby="${id}"]`
					);
					// element.classList.remove("show");
				}

				let allCards = document.getElementsByClassName("short_info");
				for (var i = 0; i < allCards.length; i++) {
					allCards[i].style.display = "none";
				}
				this.currentId = id;
				document.getElementById(id).style.display = "flex";
			},
		},
	};
</script>
