<template>
    <div>
        <header-component v-if="!$route.name.includes(withOutHeader)"></header-component>
        <div class="common_margin"></div>
        <nav-bar v-if="!$route.name.includes(withOutNav)"></nav-bar>
        <router-view></router-view>
        <FooterTop v-if="!$route.name.includes(withOutFooter)"></FooterTop>
        <Footer v-if="!$route.name.includes(withOutFooter)"></Footer>
    </div>
</template>

<script>
import HeaderComponent from '../components/shared/Header';
import NavBar from '../components/shared/NavBar';
import Footer from '../components/shared/Footer';
import FooterTop from '../components/shared/FooterTop';

export default {
    components: { HeaderComponent, NavBar, Footer , FooterTop},
    data() {
        return {
            withOutHeader: ['login'],
            withOutNav: ['login'],
            withOutFooter: ['login']
        }
    },
    created() {
        axios.get('/api/current/locale').then((response) => {
            this.$store.commit('setLocale', response.data);
        })
    },
    mounted() {

    },
    methods: {

    }
}
</script>
