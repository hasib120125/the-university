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
										"admin.form.department_of_pastoral_music.title_en"
									)
								}}</label>
								<input
									type="text"
									id="title_en"
									class="form_global"
									:placeholder="
										trans(
											'admin.form.department_of_pastoral_music.title_en'
										)
									"
									v-model="form.title_en"
								/>
								<v-errors
									:errors="errorFor('title_en')"
								></v-errors>
							</div>
						</div>
						<div class="col_6">
							<div class="form-group">
								<label>{{
									trans(
										"admin.form.department_of_pastoral_music.title_ko"
									)
								}}</label>
								<input
									type="text"
									id="title_ko"
									class="form_global"
									:placeholder="
										trans(
											'admin.form.department_of_pastoral_music.title_ko'
										)
									"
									v-model="form.title_ko"
								/>
								<v-errors
									:errors="errorFor('title_ko')"
								></v-errors>
							</div>
						</div>
						<div class="col_12">
							<div class="form-group">
								<label>{{
									trans(
										"admin.form.department_of_pastoral_music.content_en"
									)
								}}</label>
								<froala-text-editor
									:model.sync="form.content_en"
								/>
								<v-errors
									:errors="errorFor('content_en')"
								></v-errors>
							</div>
						</div>
						<div class="col_12">
							<div class="form-group">
								<label>{{
									trans(
										"admin.form.department_of_pastoral_music.content_ko"
									)
								}}</label>
								<froala-text-editor
									:model.sync="form.content_ko"
								/>
								<v-errors
									:errors="errorFor('content_ko')"
								></v-errors>
							</div>
						</div>
					</div>

					<div class="d_flex_end">
						<router-link
							class="btn btn_secondary mr_5"
							:to="{ name: 'department_of_pastoral_music_list' }"
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
	import validationErrors from "../../../../mixins/validationErrors";
	import FroalaTextEditor from "./../../../../components/FroalaTextEditor";

	export default {
		mixins: [validationErrors],
		components: { FroalaTextEditor },
		data() {
			return {
				form: {
					title_en: "",
					title_ko: "",
					content_en: "",
					content_ko: "",
				},

				pageName: this.trans(
					"admin.form.department_of_pastoral_music.add_new"
				),
			};
		},
		created() {
			if (this.$route.name === "department_of_pastoral_music_edit") {
				this.loading = true;
				this.pageName = this.trans(
					"admin.form.department_of_pastoral_music.edit"
				);
				axios
					.get(
						"/api/admin/department-of-pastoral-music/" +
							this.$route.params.id
					)
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

				if (this.$route.name === "department_of_pastoral_music_edit") {
					axios
						.patch(
							"/api/admin/department-of-pastoral-music/" +
								this.$route.params.id,
							this.form
						)
						.then((response) => {
							this.$router.push({
								name: "department_of_pastoral_music_list",
							});
						})
						.catch((err) => (this.errors = err.response.data.errors))
						.finally(() => (this.loading = false));
				} else {
					axios
						.post("/api/admin/department-of-pastoral-music", this.form)
						.then((response) => {
							this.$router.push({
								name: "department_of_pastoral_music_list",
							});
						})
						.catch((err) => (this.errors = err.response.data.errors))
						.finally(() => (this.loading = false));
				}
			},
		},
	};
</script>


