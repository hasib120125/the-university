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
        login(context, payload) {
            return new Promise((resolve, reject) => {
                axios.post('/api/login', payload).then((response) => {
                    let user = response.data.data;
                    context.commit('setUser', user);
                    localStorage.setItem('user', JSON.stringify(user));

                    axios.defaults.headers.common['Authorization'] = `Bearer ${user.token}`;

                    resolve(user);
                }).catch((error) => {
                    reject(error.response.data)
                });
            });
        },
        setNewUser(context, payload) {
            context.commit('setUser', payload);
            localStorage.setItem('user', JSON.stringify(payload));
            axios.defaults.headers.common['Authorization'] = `Bearer ${payload.token}`;
        },
    },
    getters: {
        getUser: (state) => state.user,
        getLocale: (state) => state.locale,
    },
})

export default store;
