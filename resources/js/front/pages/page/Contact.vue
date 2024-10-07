<template>
    <div id="page_content">
        <section class="faq_area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page_title">
                            <h1>{{ trans('front.contact.contact_details') }}</h1>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="contact_left">
                            <h2>{{ trans('front.contact.address.city') }}</h2>
                            <ul>
                                <li>{{ trans('front.contact.address.street') }} <br>
                                    {{ trans('front.contact.address.city') }} {{ trans('front.contact.address.postal') }}
                                </li>
                                <li>{{ trans('front.contact.email') }}: kathryn-92@example.com <br>
                                    {{ trans('front.contact.address.phone') }}: (849) 490 4283
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="faq_right">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group ">
                                        <label>{{ trans('front.contact.name') }}</label>
                                        <input type="text" class="form_global" v-model="form.name">
                                        <v-errors :errors="errorFor('name')"></v-errors>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>{{ trans('front.contact.email') }}</label>
                                        <input type="email" class="form_global" v-model="form.email">
                                        <v-errors :errors="errorFor('email')"></v-errors>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>{{ trans('front.contact.message') }}</label>
                                <textarea rows="8" class="form_global" v-model="form.message"></textarea>
                                <v-errors :errors="errorFor('message')"></v-errors>
                            </div>

                            <div class="form-group">
                                <vue-recaptcha
                                    :sitekey="recaptchaKey"
                                    :loadRecaptchaScript="true"
                                    ref="recaptcha"
                                    @verify="onCaptchaVerified"
                                    type="invisible">
                                </vue-recaptcha>
                            </div>

                            <button class="common_btn"  @click.prevent="submitForm">{{ trans('front.contact.send_message') }} <i class="lni lni-arrow-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import validationErrors from "../../mixins/validationErrors";
import VueRecaptcha from 'vue-recaptcha';

export default {
    name: "Contact",
    mixins: [validationErrors],
    components: { VueRecaptcha },
    data(){
        return {
            recaptchaKey: process.env.MIX_RECAPTCHA_SITE_KEY,
            form: {
                name: null,
                email: null,
                message: null,
                recaptcha: null,
            },
            loading: false,
        }
    },

    methods: {
        onCaptchaVerified: function (recaptchaToken) {
            this.form.recaptcha = recaptchaToken
        },
        resetRecaptcha() {
            this.$refs.recaptcha.reset() // Direct call reset method
        },
        submitForm(){
            this.errors = null;
            this.loading = true;
            this.message = null;

            axios.post('/api/contact/us', this.form)
                .then((response) => {
                    this.name = null;
                    this.email = null;
                    this. message = null;
                    this.resetRecaptcha();

                    this.$swal.fire(
                        this.trans('common.message.success'),
                        this.trans('common.message.mail_message'),
                        'success'
                    )
                })
                .catch((err) => this.errors = err.response.data.errors)
                .finally(() => this.loading = false);

        }
    },
}
</script>
