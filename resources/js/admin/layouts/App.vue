<template>
    <div id="wrapper" v-if="loaded">
        <header-component></header-component>
        <nav-bar></nav-bar>
        <div id="content_wrap">
            <div class="container">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>
import HeaderComponent from './../components/Header';
import NavBar from './../components/NavBar';

export default {
    components: { HeaderComponent, NavBar },
    data() {
        return {
            loaded: false,
        }
    },
    async created() {
        await axios.get('/api/admin/user')
            .then(() => this.loaded = true)
            .catch((err) => {
                this.$store.dispatch('logout')
                window.location.href = "/login"
            })


        axios.get('/api/current/locale').then((response) => {
            this.$store.commit('setLocale', response.data);
        })
    }
}
</script>
