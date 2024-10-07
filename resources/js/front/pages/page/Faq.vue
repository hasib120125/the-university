<template>
    <div id="page_content">
        <section class="faq_area">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="faq_left">

                            <div class="accordion" v-for="(faq, i) in faqs" :key="'faq_'+i">
                                <div class="accrodion_title_wrapper">
                                    <div class="ics_accrodion_title" data-toggle="accordion" :data-target="'#card'+i">
                                        <span>{{i+1}}. {{faq.question}}</span>
                                    </div>
                                </div>
                                <div class="accordion_body" :id="'card'+i" v-html="faq.answer"> </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="faq_right">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group ">
                                        <label>{{ trans('front.faq.name') }}</label>
                                        <input type="text" class="form_global">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>{{ trans('front.faq.email') }}</label>
                                        <input type="email" class="form_global">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>{{ trans('front.faq.message') }}</label>
                                <textarea rows="8" class="form_global"></textarea>
                            </div>
                            <button class="common_btn">{{ trans('front.faq.send_message') }} <i class="lni lni-arrow-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
</div>
</template>


<script>
export default {
    data(){
        return {
             faqs:[],
        }
    },
    created() {
        axios.get('/api/faqs/') .then((response) => { this.faqs = response.data.data; })
    },
    methods: {

    },
}
</script>

