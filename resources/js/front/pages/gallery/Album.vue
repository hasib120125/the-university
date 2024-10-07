<template>
    <div id="page_content">
        <div class="breadcrumbs above_ipad">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="page-breadcrumbs">
                            <li><router-link :to="{name: 'home'}">{{ trans('common.index.home') }}</router-link></li>
                            <li>{{ trans('front.header.gallery') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <section class="gallery_area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="main_title_v2">
                            <h2>{{ trans('front.header.gallery') }}</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="gallery_wrap">
                            <div class="gallery_inner" v-for="(gallery, index) in galleries" :key="'gallery_'+index">
                                <div class="img">
                                    <router-link :to="{name: 'gallery_details', params: {id: gallery.id}}">
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
    </div>
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
