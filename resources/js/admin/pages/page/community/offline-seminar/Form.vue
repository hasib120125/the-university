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
								<label>{{trans("admin.form.offline_seminar.title_en")}}</label>
								<input type="text" id="title_en" class="form_global" :placeholder="trans('admin.form.offline_seminar.title_en')" v-model="form.title_en"/>
								<v-errors :errors="errorFor('title_en')"></v-errors>
							</div>
						</div>
						<div class="col_6">
							<div class="form-group">
								<label>{{trans("admin.form.offline_seminar.title_ko")}}</label>
								<input type="text" id="title_ko" class="form_global" :placeholder="trans('admin.form.offline_seminar.title_ko')" v-model="form.title_ko"/>
								<v-errors :errors="errorFor('title_ko')"></v-errors>
							</div>
						</div>
						<div class="col_12">
							<div class="form-group">
								<label>{{ trans("admin.form.offline_seminar.content_en") }}</label>
								<froala-text-editor :model.sync="form.content_en" />
								<v-errors :errors="errorFor('content_en')"></v-errors>
							</div>
						</div>
						<div class="col_12">
							<div class="form-group">
								<label>{{ trans( "admin.form.offline_seminar.content_ko") }}</label>
								<froala-text-editor :model.sync="form.content_ko" />
								<v-errors :errors="errorFor('content_ko')" ></v-errors>
							</div>
						</div>
						<div class="col_12">
							<div class="form-group">
								<label>{{ trans( "admin.form.offline_seminar.preview_image") }}</label>
                                <input type="file" class="form_global" @change="selectImage" accept="image/png, image/gif, image/jpeg"/>
								<v-errors :errors="errorFor('preview_image')" ></v-errors>
							</div>
						</div>
					</div>

					<div class="d_flex_end">
						<router-link class="btn btn_secondary mr_5" :to="{ name: 'offline_seminar_list' }" >{{ trans("admin.label.cancel") }}</router-link>
						<button class="btn btn_md btn_success" @click.prevent="submitForm">{{ trans("admin.label.save") }}</button>
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
					preview_image: "",
				},

				pageName: this.trans(
					"admin.form.offline_seminar.add_offline_seminar"
				),
			};
		},
		created() {
			if (this.$route.name === "offline_seminar_edit") {
				this.loading = true;
				this.pageName = this.trans(
					"admin.form.offline_seminar.edit_offline_seminar"
				);
				axios
					.get("/api/admin/offline-seminars/" + this.$route.params.id, {params: {content_en: true, content_ko: true}})
					.then((response) => {
						this.form = response.data.data;
						this.form.preview_image = '';
					})
					.finally(() => (this.loading = false));
			}
		},
		methods: {
			selectImage(e){
				this.form.preview_image = e.target.files[0];
			},
			submitForm() {
				this.loading = true;
				this.errors = null;

				let formData = new FormData();
				
				Object.keys(this.form).forEach(key => {
					formData.append(key, this.form[key]);
				});

				if (this.$route.name === "offline_seminar_edit") {
					formData.append('_method', 'patch')
					axios.post("/api/admin/offline-seminars/" + this.$route.params.id, formData)
						.then((response) => {
							this.$router.push({ name: "offline_seminar_list" });
						})
						.catch((err) => (this.errors = err.response.data.errors))
						.finally(() => (this.loading = false));
				} else {
					axios.post("/api/admin/offline-seminars", formData)
						.then((response) => {
							this.$router.push({ name: "offline_seminar_list" });
						})
						.catch((err) => (this.errors = err.response.data.errors))
						.finally(() => (this.loading = false));
				}
			},
		},
	};
</script>


