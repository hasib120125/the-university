<template>
    <div id="wrapper">
        <header-component></header-component>
        <div id="content_wrap">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import HeaderComponent from './../components/Header';

export default {
    components: { HeaderComponent },
    async created() {
        await axios.get('/api/student/user')
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
