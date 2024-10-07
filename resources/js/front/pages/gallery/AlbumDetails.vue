<template>
    <div>
        <div class="breadcrumbs above_ipad">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="page-breadcrumbs">
                            <li><router-link :to="{name: 'home'}">{{ trans('common.index.home') }}</router-link></li>
                            <li><router-link :to="{name: 'gallery'}">{{ trans('front.header.gallery') }}</router-link></li>
                            <li v-if="gallery">{{ gallery.name }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

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
                            <a :href="image.image" data-fancybox="gallery" v-for="(image, index) in gallery.images" :key="'image_'+index">
                                <div class="img">
                                    <img :src="image.image" alt="" class="img-fluid">
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
        axios.get('/api/galleries/'+this.$route.params.id)
            .then((response) => {
                this.gallery = response.data.data;
                setTimeout(() => {
                   //mobile_menu $('[data-fancybox="gallery"]').fancybox();
                }, 200)
            })
    }
}
</script>
