require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router';

import router from './router'
import store from './store';

Vue.use(VueRouter)

// Validation component
import ValidationErrors from "./components/shared/ValidationErrors";
Vue.component("v-errors", ValidationErrors);

// Localization
Vue.prototype.trans = string => _.get(window.i18n, string);

import VCalendar from 'v-calendar';

// Use v-calendar & v-date-picker components
Vue.use(VCalendar, {
  componentPrefix: 'vc',  // Use <vc-calendar /> instead of <v-calendar />
});

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VueSweetalert2, {
    confirmButtonText: Vue.prototype.trans('common.index.ok')
});

import Froala from 'vue-froala-wysiwyg'
Vue.use(Froala)
Vue.config.productionTip = true

import moment from 'moment'
Vue.prototype.moment = moment

const app = new Vue({
    el: '#app',
    router,
    store
});
