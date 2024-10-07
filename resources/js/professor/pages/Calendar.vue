<template>
	<div>
		<vc-calendar
			class="common_calender col_12 pb_15"
			:masks="masks"
			:attributes="attributes" is-expanded
		>
			<template v-slot:day-content="{ day, attributes }">
				<div style="z-index: 1; position: relative; height:100%">
					<span>{{ day.day }}</span>
					<p
					style="z-index: 2; position: relative;"
						v-for="(attr, index) in attributes"
						:key="index"
						class="mt_5"
						@click="showData($event, attr.customData)"
					>
						{{ attr.customData.title }}
					</p>
				</div>
			</template>
		</vc-calendar>

		<div class="modal " :class="{ 'open_modal': showModal}"  data-modal="modal">
            <div class="modal_overlay" data-modal-close="modal" @click="closeModal"></div>
            <div class="modal_inner">
                <div class="modal_wrapper modal_500p">
					<div class="card mb_0">
						<div class="card-header">
							<div class="card-title">{{ this.form.label }}</div>
						</div>
						<div class="card-body mb_0">
							<div class="modal_content">
								<div class="row">
									<div class="col_12">
										<p><span class="fw_500">{{ trans('professor.form.calendar.title') }}</span> - {{ form.title }}</p>
										<p><span class="fw_500">{{ trans('professor.form.calendar.description') }}</span> - {{ form.description }}</p>
									</div>
								</div>

								<div class="d_flex_end">
									<button class="btn btn_md btn_secondary" @click.prevent="closeModal">{{ trans('professor.label.close') }}</button>
								</div>
							</div>
						</div>
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
			masks: {
				weekdays: "WWW",
			},
            showModal: false,
			attributes: [],
			form: {},
			title: '',
		};
	},
	created(){
		this.loadData()
	},
	methods: {
		loadData(){
			axios.get('/api/professor/calendars')
			.then((response) => {
				this.attributes = response.data.data;
			})
		},
		showData(e, data) {
			this.form = {...data}
			this.showModal = true
		},
        closeModal(){
			this.form = {}
            this.showModal = false
        },
	},
};
</script>

