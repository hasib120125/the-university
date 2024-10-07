<template>
	<div class="row">
		<div class="col_12">
			<div class="card">
				<div class="card-header">
					<div class="card-title">{{ pageName }}</div>
				</div>
				<div :class="['card-body', { loading_overlay: loading }]">
					<div class="row">
						<div class="col_6">
							<div class="form-group">
								<label>{{
									trans(
										"admin.form.admission_counselling.question_en"
									)
								}}</label>
								<input
									type="text"
									id="question_en"
									class="form_global"
									:placeholder="
										trans(
											'admin.form.admission_counselling.question_en'
										)
									"
									v-model="form.question_en"
								/>
								<v-errors
									:errors="errorFor('question_en')"
								></v-errors>
							</div>
						</div>
						<div class="col_6">
							<div class="form-group">
								<label>{{
									trans(
										"admin.form.admission_counselling.question_ko"
									)
								}}</label>
								<input
									type="text"
									id="question_ko"
									class="form_global"
									:placeholder="
										trans(
											'admin.form.admission_counselling.question_ko'
										)
									"
									v-model="form.question_ko"
								/>
								<v-errors
									:errors="errorFor('question_ko')"
								></v-errors>
							</div>
						</div>
						<div class="col_12">
							<div class="form-group">
								<label>{{
									trans(
										"admin.form.admission_counselling.answer_en"
									)
								}}</label>
								<froala-text-editor
									:model.sync="form.answer_en"
								/>
								<v-errors
									:errors="errorFor('answer_en')"
								></v-errors>
							</div>
						</div>
						<div class="col_12">
							<div class="form-group">
								<label>{{
									trans(
										"admin.form.admission_counselling.answer_ko"
									)
								}}</label>
								<froala-text-editor
									:model.sync="form.answer_ko"
								/>
								<v-errors
									:errors="errorFor('answer_ko')"
								></v-errors>
							</div>
						</div>
					</div>

					<div class="d_flex_end">
						<router-link
							class="btn btn_secondary mr_5"
							:to="{ name: 'admission_counselling_list' }"
							>{{ trans("admin.label.cancel") }}</router-link
						>
						<button
							class="btn btn_md btn_success"
							@click.prevent="submitForm"
						>
							{{ trans("admin.label.save") }}
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import validationErrors from "../../../mixins/validationErrors";
	import FroalaTextEditor from "./../../../components/FroalaTextEditor";

	export default {
		mixins: [validationErrors],
		components: { FroalaTextEditor },
		data() {
			return {
				form: {
					question_en: "",
					question_ko: "",
					answer_en: "",
					answer_ko: "",
				},

				pageName: this.trans(
					"admin.form.admission_counselling.add_new_question"
				),
			};
		},
		created() {
			if (this.$route.name === "admission_counselling_edit") {
				this.loading = true;
				this.pageName = this.trans(
					"admin.form.admission_counselling.edit"
				);
				axios
					.get("/api/admin/admission-counselling/" + this.$route.params.id)
					.then((response) => {
						this.form = response.data.data;
					})
					.finally(() => (this.loading = false));
			}
		},
		methods: {
			submitForm() {
				this.loading = true;
				this.errors = null;

				if (this.$route.name === "admission_counselling_edit") {
					axios
						.patch(
							"/api/admin/admission-counselling/" + this.$route.params.id,
							this.form
						)
						.then((response) => {
							this.$router.push({ name: "admission_counselling_list" });
						})
						.catch((err) => (this.errors = err.response.data.errors))
						.finally(() => (this.loading = false));
				} else {
					axios
						.post("/api/admin/admission-counselling", this.form)
						.then((response) => {
							this.$router.push({ name: "admission_counselling_list" });
						})
						.catch((err) => (this.errors = err.response.data.errors))
						.finally(() => (this.loading = false));
				}
			},
		},
	};
</script>


