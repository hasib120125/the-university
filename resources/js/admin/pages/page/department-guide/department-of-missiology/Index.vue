<template>
	<div>
		<div class="row">
			<div class="col_12">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col_12">
								<div class="form-group">
									<label>{{
										trans(
											"admin.form.pages.page_content_en"
										)
									}}</label>
									<froala-text-editor
										:model.sync="page.description_en"
									/>
									<v-errors
										:errors="errorFor('description_en')"
									></v-errors>
								</div>
							</div>

							<div class="col_12">
								<div class="form-group">
									<label>{{
										trans(
											"admin.form.pages.page_content_ko"
										)
									}}</label>
									<froala-text-editor
										:model.sync="page.description_ko"
									/>
									<v-errors
										:errors="errorFor('description_ko')"
									></v-errors>
								</div>
							</div>
						</div>
						<div class="d_flex_end">
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
		<div class="row">
			<div class="col_12">
				<div class="card">
					<div class="card-body">
						<router-link
							:to="{ name: 'department_of_missiology_add' }"
							class="btn btn_info"
							>{{
								trans("admin.form.department_of_missiology.add_new")
							}}</router-link
						>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col_12">
				<div class="card">
					<div class="card-header">
						<div class="card-title">
							{{
								trans(
									"admin.form.department_of_missiology.department_of_missiology"
								)
							}}
						</div>
					</div>
					<div class="card-body">
						<table-component
							api-url="/api/admin/department-of-missiology"
							:fields="fields"
							ref="tableComponent"
							:sort-order="sortOrder"
							@delete="deleteItem"
						>
						</table-component>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import TableComponent from "./../../../../components/TableComponent";
	import validationErrors from "../../../../mixins/validationErrors";
	import FroalaTextEditor from "./../../../../components/FroalaTextEditor";
	export default {
		mixins: [validationErrors],
		components: {
			TableComponent,
			FroalaTextEditor,
		},
		data() {
			return {
				fields: [
					{
						name: "title_en",
						title: this.trans(
							"admin.form.department_of_missiology.title_en"
						),
						sortField: "title_en",
						searchable: true,
					},
					{
						name: "title_ko",
						title: this.trans(
							"admin.form.department_of_missiology.title_ko"
						),
						sortField: "title_ko",
						searchable: true,
					},
					{
						name: "action-slot",
						title: this.trans("admin.label.action"),
						searchable: false,
						data: [
							{
								class: "btn btn_sm btn_info mr_5",
								title: this.trans("admin.label.edit"),
								route: "department_of_missiology_edit",
								params: { id: "id" },
							},
							{
								class: "btn btn_sm btn_danger",
								title: this.trans("admin.label.delete"),
								action: "delete",
							},
						],
					},
				],
				sortOrder: [],
				page: {
					description_en: "",
					description_ko: "",
				},
			};
		},
		created() {
			axios
				.get("/api/admin/pages/" + this.$route.params.page_id)
				.then((response) => {
					this.page = response.data.data;
				})
				.finally(() => (this.loading = false));
		},
		methods: {
			deleteItem(item) {
				this.$swal({
					title: this.trans("admin.label.delete_confirmation"),
					text: this.trans("admin.label.warning"),
					icon: "warning",
					showCancelButton: true,
					confirmButtonText: this.trans("admin.label.yes_delete"),
					cancelButtonText: this.trans("admin.label.no_cancel"),
					reverseButtons: true,
				}).then((result) => {
					if (result.isConfirmed) {
						axios
							.delete("/api/admin/department-of-missiology/" + item.id)
							.then(() => {
								this.$refs.tableComponent.refresh();
								this.$swal.fire(
									this.trans("common.message.deleted"),
									this.trans("common.message.delete_message"),
									"success"
								);
							});
					}
				});
			},
			submitForm() {
				this.loading = true;
				this.errors = null;
				axios
					.patch(
						"/api/admin/pages/" + this.$route.params.page_id,
						this.page
					)
					.then((response) => {
						this.$refs.tableComponent.refresh();
						this.$swal.fire(
							this.trans("common.message.updated"),
							this.trans("common.message.update_message"),
							"success"
						);
					})
					.catch((err) => (this.errors = err.response.data.errors))
					.finally(() => (this.loading = false));
			},
		},
	};
</script>

