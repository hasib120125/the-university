<template>
    <div class="footer_top" v-if="footerTops.length">
        <div class="container">
            <div class="row">
                <div class="col-md-4" v-for="footerTop in footerTops">
                    <div class="inner">
                        <a :href="footerTop.link" target="_blank"><img :src="footerTop.image" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
export default {
    data(){
        return {
            footerTops: [],
        }
    },
    created() {
        axios.get('/api/footer-top').then((response) => { this.footerTops = response.data.data });
    },
}
</script>


<style scoped lang="scss">
.footer_top {
    background: #434343;
    padding: 30px 0px;
    @media(max-width : 767px) {
        padding: 20px 0px;
    }
    .inner {
        padding: 10px 0px;
        img {
            max-width: 100%;
            margin-left: auto;
            margin-right: auto;
            display: block;
        }
    }
}
</style>
