<template>
	<div>
		<div class="row">
			<div class="col_12">
				<div class="card">
					<div class="card-body">
						<router-link
							:to="{ name: 'pages_add' }"
							class="btn btn_info"
							>{{
								trans("admin.form.pages.add_new_page")
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
							{{ trans("admin.form.pages.pages") }}
						</div>
					</div>
					<div class="card-body">
						<table-component
							api-url="/api/admin/pages"
							:fields="fields"
							ref="tableComponent"
							:sort-order="sortOrder"
							@delete="deleteItem"
							@details="details"
						>
						</table-component>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>


<script>
	import TableComponent from "./../../components/TableComponent";
	export default {
		components: {
			TableComponent,
		},
		data() {
			return {
				fields: [
					{
						name: "title",
						title: this.trans("admin.form.pages.title_en"),
						sortField: "title",
						searchable: true,
					},
					{
						name: "title_ko",
						title: this.trans("admin.form.pages.title_ko"),
						sortField: "title_ko",
						searchable: true,
					},
					{
						name: "menu.name",
						title: this.trans("admin.form.pages.menu"),
						sortField: "menu.name",
						searchable: true,
					},
					{
						name: "submenu.name",
						title: this.trans("admin.form.pages.sub_menu"),
						sortField: "submenu.name",
						searchable: true,
					},
					{
						name: "action-slot",
						title: this.trans("admin.label.action"),
						searchable: false,
						data: [
							{
								class: "btn btn_sm btn_success mr_5",
								title: '<i class="fas fa-eye"></i>',
								tooltip: this.trans("admin.label.details"),
								condition: ["can_delete", 0],
								action: "details",
							},
							{
								class: "btn btn_sm btn_info mr_5",
								title: '<i class="far fa-edit"></i>',
                                tooltip: this.trans("admin.label.edit"),
								route: "pages_edit",
								condition: ["can_delete", 1],
								params: { id: "id" },
							},
							{
								class: "btn btn_sm btn_danger",
								title: '<i class="far fa-trash-alt"></i>',
                                tooltip: this.trans("admin.label.delete"),
								action: "delete",
								condition: ["can_delete", 1],
							},
						],
					},
				],
				sortOrder: [],
			};
		},
		methods: {
            details(item){
                let slug = `${item.menu.slug}/${item.id}/${item.submenu.slug}`
                this.$router.push(slug)
            },
			deleteItem(item) {
				if (!item.can_delete) {
					this.$swal.fire(
								this.trans("common.message.error"),
								this.trans("common.message.page_delete_error_message"),
								"success"
							);

					return;
				}

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
						axios.delete("/api/admin/pages/" + item.id).then(() => {
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
		},
	};
</script>

