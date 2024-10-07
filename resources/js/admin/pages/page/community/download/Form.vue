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
										"admin.form.download.title_en"
									)
								}}</label>
								<input
									type="text"
									id="title_en"
									class="form_global"
									:placeholder="
										trans(
											'admin.form.download.title_en'
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
										"admin.form.download.title_ko"
									)
								}}</label>
								<input
									type="text"
									id="title_ko"
									class="form_global"
									:placeholder="
										trans(
											'admin.form.download.title_ko'
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
										"admin.form.download.content_en"
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
										"admin.form.download.content_ko"
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

                        <div class="col_6">
							<div class="form-group">
								<label>{{ trans("admin.form.download.file")}}</label>
                                <div class="file_input">
                                    <input type="file" class="form_global" :placeholder="trans('admin.form.download.file')" @change="imageUpload($event)">
                                    <v-errors :errors="errorFor('file')"></v-errors>
                                </div>
							</div>
						</div>
					</div>

					<div class="d_flex_end">
						<router-link
							class="btn btn_secondary mr_5"
							:to="{ name: 'download_list' }"
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
                    file:''
				},

				pageName: this.trans(
					"admin.form.download.add_download"
				),
			};
		},
		created() {
			if (this.$route.name === "download_edit") {
				this.loading = true;
				this.pageName = this.trans(
					"admin.form.download.edit_download"
				);
				axios
					.get("/api/admin/downloads/" + this.$route.params.id)
					.then((response) => {
						this.form = response.data.data;
                        this.form.file = '';
					})
					.finally(() => (this.loading = false));
			}
		},
		methods: {
			submitForm() {
				this.loading = true;
				this.errors = null;

                let formData = new FormData();

                Object.keys(this.form).forEach(key => {
                    formData.append(key, this.form[key]);
                });

				if (this.$route.name === "download_edit") {
                    formData.append('_method', 'PATCH');
					axios.post("/api/admin/downloads/" + this.$route.params.id,formData)
						.then((response) => {
							this.$router.push({ name: "download_list" });
						})
						.catch((err) => (this.errors = err.response.data.errors))
						.finally(() => (this.loading = false));
				} else {
					axios.post("/api/admin/downloads", formData)
						.then((response) => {
							this.$router.push({ name: "download_list" });
						})
						.catch((err) => (this.errors = err.response.data.errors))
						.finally(() => (this.loading = false));
				}
			},

            imageUpload(e) {
                this.form.file = e.target.files[0];
            },
		},
	};
</script>


