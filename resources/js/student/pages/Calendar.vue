<template>
	<div class="overflow_auto">
		<vc-calendar
			class="common_calender col-lg-5"
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

		<!-- mobile calendar -->
		<!-- <vc-calendar
			class="common_calender col-lg-5 desktop_none"
			:masks="masks"
			:attributes="attributes" is-expanded
		>
			<template v-slot:day-content="{ day, attributes }">
				<div style="z-index: 1; position: relative; height:100%" v-if="attributes && attributes.length > 0" >
					<span>{{ day.day }}</span>
					<p style="z-index: 2; position: relative;" class="mt_5" @click="showMobileData($event, attributes)">...</p>
				</div>
			</template>
		</vc-calendar> -->

		<div class="modal " :class="{ 'open_modal': showModal}"  data-modal="modal">
            <div class="modal_overlay" data-modal-close="modal" @click="closeModal"></div>
            <div class="modal_inner">
                <div class="modal_wrapper modal_500p">
					<div class="card mb_0">
						<div class="card-header">
							<div>{{ this.form.label }}</div>
						</div>
						<div class="card-body mb_0 p_5">
							<div class="modal_content">
								<div class="container">
									<div class="row">
										<div class="col-12">
											<p><span class="fw_500">{{ trans('student.form.calendar.title') }}</span> - {{ form.title }}</p>
											<p><span class="fw_500">{{ trans('student.form.calendar.description') }}</span> - {{ form.description }}</p>
										</div>
									</div>
								</div>
								
								<div class="d_flex_end">
									<button class="btn btn_md btn_secondary" @click.prevent="closeModal">{{ trans('student.label.close') }}</button>
								</div>
							</div>
						</div>
					</div>
                </div>
            </div>
        </div>

		<!-- <div class="modal " :class="{ 'open_modal': showMobileModal}"  data-modal="modal">
            <div class="modal_overlay" data-modal-close="modal" @click="closeMobileModal"></div>
            <div class="modal_inner">
                <div class="modal_wrapper modal_500p">
					<div class="card mb_0">
						<div class="card-header">
							<div v-if="mobileForm.length > 0">{{ mobileForm[0].label }}</div>
						</div>
						<div class="card-body mb_0 p_5">
							<div class="modal_content">
								<div class="container">
									<div class="row" v-for="(item, index) in mobileForm" :key="'data' + index">
										<div class="col-12" v-if="index !== 0">
											<hr>
										</div>
										<div class="col-12">
											<p><span class="fw_500">{{ trans('student.form.calendar.title') }}</span> - {{ item.title }}</p>
											<p><span class="fw_500">{{ trans('student.form.calendar.description') }}</span> - {{ item.description }}</p>
										</div>
									</div>
								</div>

								<div class="d_flex_end">
									<button class="btn btn_md btn_secondary" @click.prevent="closeMobileModal">{{ trans('student.label.close') }}</button>
								</div>
							</div>
						</div>
					</div>
                </div>
            </div>
        </div> -->
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
            showMobileModal: false,
			attributes: [],
			form: {},
			mobileForm: [],
			title: '',
		};
	},
	created(){
		this.loadData()
	},
	methods: {
		loadData(){
			axios.get('/api/student/calendars')
			.then((response) => {
				this.attributes = response.data.data;
			})
		},
		showData(e, data) {
			this.form = {...data}
			this.showModal = true
		},
		showMobileData(e, datas) {
			this.mobileForm = _.map(datas, (data)=> data.customData );
			this.showMobileModal = true
		},
        closeModal(){
            this.showModal = false
        },
        closeMobileModal(){
            this.showMobileModal = false
        },
	},
};
</script>

