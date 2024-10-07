<template>
    <div>
        <div class="common_margin"></div>
        <div class="breadcrumbs above_ipad">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="page-breadcrumbs">
                            <li><router-link :to="{name:'home'}"> {{ trans('common.index.home') }} </router-link> </li>
                            <li>{{  page ? page.title : pageTitle() }}</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
        <section class="common_page_area">
            <div class="above_ipad">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-lg-3 col-xl-2">
                            <div class="common_left_sidebar">
                                <div id="accordion">
                                    <div class="card" v-for="(menu, index) in menus" :key="'menu_'+index">
                                        <div class="card-header" :id="'heading' + index">
                                            <button class="btn btn-link" :class="{ 'collapsed' : $route.params.menu !== menu.slug}" data-toggle="collapse" :data-target="'#collapse' + index" aria-expanded="true" :aria-controls="'collapse' + index">
                                                {{ menu.name }}
                                            </button>
                                        </div>

                                        <div :id="'collapse' + index" class="collapse" :class="{ 'show' : $route.params.menu === menu.slug}" :aria-labelledby="'heading' + index" data-parent="#accordion">
                                            <div class="card-body">
                                                <ul>
                                                    <li v-for="(sub, i) in menu.sub_menus" :key="'sub_'+i" :class="{ 'active' : $route.params.submenu === sub.slug || $router.currentRoute.path === sub.slug }">
                                                        <router-link :to="sub.route">
                                                            {{ sub.name }}
                                                        </router-link>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-9 col-xl-10">
                            <div class="common_page_content">
                                <h2 class="title">
                                    {{ page ? page.title : pageTitle() }}
                                </h2>
                                <AdmissionCounselling v-if=" $route.params.menu+'/'+ $route.params.submenu == 'admission-guide/admission-counselling'" />
                                <ProfessorInstruction v-else-if=" $route.params.menu+'/'+ $route.params.submenu == 'department-guide/professor-introduction'" />
                                <AcademicRegulation v-else-if=" $route.params.menu+'/'+ $route.params.submenu == 'academic-information/academic-regulation'" />
                                <MinistryofMinistry :page="page ? page : {}" v-else-if=" $route.params.menu+'/'+ $route.params.submenu == 'department-guide/ministry-of-ministry'" />
                                <DepartmentofMissiology :page="page ? page : {}" v-else-if=" $route.params.menu+'/'+ $route.params.submenu == 'department-guide/department-of-missiology'" />
                                <DepartmentofPastoralMusic :page="page ? page : {}" v-else-if=" $route.params.menu+'/'+ $route.params.submenu == 'department-guide/department-of-pastoral-music'" />
                                <IscArticles v-else-if=" $route.params.menu+'/'+ $route.params.submenu == 'community/icu-articles-public-relations'" />
                                <OfflineSeminar v-else-if=" $route.params.menu+'/'+ $route.params.submenu == 'community/offline-seminar'" />
                                <Downloads v-else-if=" $route.params.menu+'/'+ $route.params.submenu == 'community/downloads'" />
                                <NewsIndex v-else-if="$router.currentRoute.path === '/community/news'" />
                                <NewsDetails v-else-if="$router.currentRoute.path.indexOf('/community/news/') !== -1" />
                                <Gallery v-else-if="$router.currentRoute.path === '/community/gallery'" />
                                <GalleryDetails v-else-if="$router.currentRoute.path.indexOf('/community/gallery/') !== -1" />
                                <p v-html="page.description" v-else-if="page"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="below_ipad">
                <div class="container ">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="common_page_content">
                                <h2 class="title">
                                   {{ page ? page.title : pageTitle() }}
                                </h2>
                                <AdmissionCounselling v-if=" $route.params.menu+'/'+ $route.params.submenu == 'admission-guide/admission-counselling'" />
                                <ProfessorInstructionTab v-else-if=" $route.params.menu+'/'+ $route.params.submenu == 'department-guide/professor-introduction'" />
                                <AcademicRegulationTab v-else-if=" $route.params.menu+'/'+ $route.params.submenu == 'academic-information/academic-regulation'" />
                                <MinistryofMinistryTab :page="page ? page : {}" v-else-if=" $route.params.menu+'/'+ $route.params.submenu == 'department-guide/ministry-of-ministry'" />
                                <DepartmentofMissiologyTab :page="page ? page : {}" v-else-if=" $route.params.menu+'/'+ $route.params.submenu == 'department-guide/department-of-missiology'" />
                                <DepartmentofPastoralMusicTab :page="page ? page : {}" v-else-if=" $route.params.menu+'/'+ $route.params.submenu == 'department-guide/department-of-pastoral-music'" />
                                <IscArticles v-else-if=" $route.params.menu+'/'+ $route.params.submenu == 'community/icu-articles-public-relations'" />
                                <OfflineSeminar v-else-if=" $route.params.menu+'/'+ $route.params.submenu == 'community/offline-seminar'" />
                                <NewsIndex v-else-if="$router.currentRoute.path === '/community/news'" />
                                <NewsDetails v-else-if="$router.currentRoute.path.indexOf('/community/news/') !== -1" />
                                <Gallery v-else-if="$router.currentRoute.path === '/community/gallery'" />
                                <GalleryDetails v-else-if="$router.currentRoute.path.indexOf('/community/gallery/') !== -1" />
                                <p v-html="page ? page.description : ''" v-else></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
<script>
import AdmissionCounselling from './admission-guide/AdmissionCounselling'
import AcademicRegulation from './academic-information/AcademicRegulation'
import AcademicRegulationTab from './academic-information/AcademicRegulationTab'
import MinistryofMinistry from './department-guide/MinistryofMinistry'
import ProfessorInstruction from './department-guide/ProfessorInstruction'
import ProfessorInstructionTab from './department-guide/ProfessorInstructionTab'
import MinistryofMinistryTab from './department-guide/MinistryofMinistryTab'
import DepartmentofMissiology from './department-guide/DepartmentofMissiology'
import DepartmentofMissiologyTab from './department-guide/DepartmentofMissiologyTab'
import DepartmentofPastoralMusic from './department-guide/DepartmentofPastoralMusic'
import DepartmentofPastoralMusicTab from './department-guide/DepartmentofPastoralMusicTab'
import IscArticles from './community/IcsArticles'
import OfflineSeminar from './community/OfflineSeminar'
import Downloads from './community/Downloads'
import NewsIndex from './community/news/Index.vue'
import NewsDetails from './community/news/Single.vue'
import Gallery from './community/gallery/Album.vue'
import GalleryDetails from './community/gallery/AlbumDetails.vue'

export default {
    components : {
        AdmissionCounselling,
        AcademicRegulation,
        AcademicRegulationTab,
        MinistryofMinistry,
        ProfessorInstruction,
        ProfessorInstructionTab,
        MinistryofMinistryTab,
        DepartmentofMissiology,
        DepartmentofMissiologyTab,
        DepartmentofPastoralMusic,
        DepartmentofPastoralMusicTab,
        IscArticles,
        OfflineSeminar,
        Downloads,
        NewsIndex,
        NewsDetails,
        Gallery,
        GalleryDetails,
    },
    data(){
        return {
            page: null,
            menus: [],
        }
    },
    watch: {
        $route() {
            this.loadData();
        }
    },
    created() {
        axios.get('/api/menus').then((response) => this.menus = response.data.data);
        this.loadData();
    },
    methods: {
        pageTitle() {
            let title = '';

            this.menus.find(i => {
                let sub = i.sub_menus.find(j => j.slug === this.$router.currentRoute.path)

                if (sub)
                    title = sub.name;
            });

            return title;
        },
        loadData() {
            this.page = null;

            const skipPageLoad = ['/community/news', '/community/gallery'];

            if (!skipPageLoad.includes(this.$router.currentRoute.path) && !this.$route.params.slug) {
                axios.get('/api/pages/'+this.$route.params.menu+'/'+this.$route.params.submenu)
                    .then((response) => this.page = response.data.data)
            }
        },
    },
}
</script>
