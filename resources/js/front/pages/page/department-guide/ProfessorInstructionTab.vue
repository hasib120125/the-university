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
							:id="'bellow_' + subjectIndex"
							data-toggle="tab"
							:href="'#bellow_' + subjectIndex + '-tab'"
							role="tab"
							:aria-controls="'bellow_' + subjectIndex"
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
							:id="'bellow_' + subjectIndex + '-tab'"
							role="tabpanel"
							:aria-labelledby="'bellow_' + subjectIndex"
							:key="'key' + subjectIndex"
						>
							<div class="inner">
								<div class="hover_tab">
									<ul class="heading">
										<li v-for="(professor, professorIndex) in subject" 
										@click="toggleProfessor('professor_bellow' + professorIndex + subjectIndex)" :key="'tab-li' + professorIndex" >
											{{ professor.name }}
										</li>
									</ul>
									<div class="hover_content">
										<div class="short_info" v-show="professorIndex == 0" :id="'professor_bellow' + professorIndex + subjectIndex"
												v-for="(professor, professorIndex) in subject" :key="professorIndex + subjectIndex">
											<div class="img">
												<img :src="professor.photo" alt="" class="img-fluid">
											</div>
											<div class="short_desc">
												<ul>
													<li><span>{{ trans('admin.form.professors.name') }} : </span> {{ professor.name }}</li>
													<!-- <li><span>{{ trans('admin.form.professors.email') }} : </span> {{ professor.email }}</li>
													<li><span>{{ trans('admin.form.professors.mobile') }} : </span> {{ professor.mobile }}</li>
													<li><span>{{ trans('admin.form.professors.date_of_birth') }} : </span> {{ professor.dob }}</li> -->
													<li><span>{{ trans('admin.form.professors.address') }} : </span> {{ professor.address }}</li>
													<li><span>{{ trans('admin.form.professors.subject') }} : </span> {{ professor.subject ? professor.subject.name : '' }}</li>
												</ul>
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
	</div>
</template>

<script>
	export default {
		data() {
			return {
				currentId: null,
				subjects: null,
			};
		},
		created() {
			this.getData();
		},
		methods: {
			getData() {
				axios
					.get("/api/professors")
					.then((response) => {
						this.subjects = response.data;
					})
					.finally(() => (this.loading = false));
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
