<template>
    <section class="gallery_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="gallery_wrap">
                        <div class="gallery_inner" v-for="(gallery, index) in galleries" :key="'gallery_'+index">
                            <div class="img">
                                <router-link :to="'/community/gallery/'+gallery.id">
                                    <img :src="gallery.images[0].thumbs" alt="" class="img-fluid">
                                </router-link>
                            </div>
                            <div class="text">
                                <h2>{{ gallery.name }}</h2>
                                <p>{{ gallery.images.length }} {{ trans('common.index.photos') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    data() {
        return {
            galleries: []
        }
    },
    created() {
        axios.get('/api/galleries').then((response) => this.galleries = response.data.data);
    }
}
</script>
