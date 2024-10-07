<template>
	<div>
		<vc-calendar
			class="common_calender"
			:masks="masks"
			:attributes="attributes" is-expanded
		>
			<template v-slot:day-content="{ day, attributes }">
				<div style="z-index: 1; position: relative; height:100%"  @click="dayClicked(day)">
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
                <div class="modal_wrapper">
					<div class="modal_content modal_500p">
						<div class="card mb_0">
							<div class="card-header">
								<div class="card-title">{{ title }} - {{ this.form.label }}</div>
							</div>
							<div class="card-body mb_0">
								<div class="row">
									<div class="col_12">
										<div class="form-group">
											<label>{{ trans('admin.form.calendar.title') }}</label>
											<input type="text" class="form_global" v-model="form.title">
											<v-errors :errors="errorFor('title')"></v-errors>
										</div>
									</div>
									<div class="col_12">
										<div class="form-group mb_0">
											<label class="pb_0">{{ trans('admin.form.calendar.type') }}</label>
										</div>
										<div class="form_radio">
											<input type="radio" id="Professor"  v-model="form.type" value="Professor">
											<label for="Professor">{{ trans('admin.form.notices.professor') }}</label>
										</div>
										<div class="form_radio ml_20">
											<input type="radio" id="Student"  v-model="form.type" value="Student">
											<label for="Student">{{ trans('admin.form.notices.student') }}</label>
										</div>

										<v-errors :errors="errorFor('type')"></v-errors>
									</div>
									<div class="col_12">
										<div class="form-group">
											<label>{{ trans('admin.form.calendar.description') }}</label>
											<textarea rows="4" class="form_global" v-model="form.description"></textarea>
											<v-errors :errors="errorFor('description')"></v-errors>
										</div>
									</div>
								</div>

								<div class="d_flex_end">
									<button class="btn btn_md btn_danger mr_5" v-if="this.form.id" @click.prevent="deleteData">{{ trans('admin.label.delete') }}</button>
									<button class="btn btn_md btn_success" @click.prevent="saveDate">{{ trans('admin.label.save') }}</button>
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
import validationErrors from "./../mixins/validationErrors";
import moment from 'moment'

export default {
	mixins: [validationErrors],
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
			axios.get('/api/admin/calendars')
			.then((response) => {
				this.attributes = response.data.data;
			})
		},
		dayClicked(day) {
			this.form = {
				title : '',
				type : '',
				description : '',
				date : moment(day.date).format('YYYY-MM-DD'),
				label : moment(day.date).format('LL'),
			}
			this.title = this.trans('admin.form.calendar.add_new')
			this.showModal = true
		},
		showData(e, data) {
			e.stopPropagation()
			this.form = {...data}
			this.title = this.trans('admin.form.calendar.edit')
			this.showModal = true
		},
        closeModal(){
			this.form = {}
            this.showModal = false
        },
		saveDate(){
            this.errors = null;

            if (this.form.id) {
                axios.patch('/api/admin/calendars/'+ this.form.id, this.form)
                    .then((response) => {
                        this.loadData()
						this.closeModal()
                    })
                    .catch((err) => this.errors = err.response.data.errors)
            }else{
                axios.post('/api/admin/calendars', this.form)
                    .then((response) => {
                        this.loadData()
						this.closeModal()
                    })
                    .catch((err) => this.errors = err.response.data.errors)
            }
		},
		deleteData(){
			this.$swal({
                title: this.trans('admin.label.delete_confirmation'),
                text: this.trans('admin.label.warning'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: this.trans('admin.label.yes_delete'),
                cancelButtonText: this.trans('admin.label.no_cancel'),
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
					axios.delete('/api/admin/calendars/'+ this.form.id)
                    .then((response) => {
						this.closeModal()
						this.$swal.fire(
							this.trans('common.message.deleted'),
                            this.trans('common.message.delete_message'),
                            'success'
                        )
						this.loadData()
                    })
                }
            });
			
		}
	},
};
</script>

