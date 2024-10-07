<template>
    <div>
        <section class="gallery_area" v-if="gallery">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="main_title_v2">
                            <h2>{{ gallery.name }}</h2>
                            <p>{{ gallery.description }}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="gallery_details_wrap">
                            <a :data-src="image.image" data-fancybox="gallery" v-for="(image, index) in gallery.images" :key="'image_'+index">
                                <div class="img">
                                    <img :src="image.thumbs" alt="" class="img-fluid">
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    data() {
        return {
            gallery: null,
        }
    },
    mounted() {
        axios.get('/api/galleries/'+this.$route.params.slug)
            .then((response) => {
                this.gallery = response.data.data;
                setTimeout(() => {
                    Fancybox.bind("[data-fancybox]", {
                        infinite: false
                    });
                }, 200)
            })
    }
}
</script>
