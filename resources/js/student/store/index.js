import Vue from 'vue';
import Vuex from 'vuex'

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        user: JSON.parse(localStorage.getItem('user')) || null,
        locale: process.env.MIX_APP_LOCALE || 'en',
    },
    mutations: {
        setUser(state, payload) {
            state.user = payload;
        },
        setLocale(state, payload) {
            state.locale = payload;
        }
    },
    actions: {
        logout(context) {
            context.commit('setUser', null);
            localStorage.removeItem('user');
            axios.defaults.headers.common['Authorization'] = null;
        }
    },
    getters: {
        getUser: (state) => state.user,
        getLocale: (state) => state.locale,
    },
});

export default store;
