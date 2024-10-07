import auth from "../middlewares/auth";
export const fixedPageRoute = [
    {
        path: "admission-guide/:page_id/admission-counselling",
        component: () =>
            import(
                /* webpackChunkName: "admin/fixedPage" */ "./../pages/page/admission-guide/Index"
            ),
        name: "admission_counselling_list",
        meta: {
            middleware: [auth]
        }
    },
    {
        path: "admission-guide/:page_id/admission-counselling/add",
        component: () =>
            import(
                /* webpackChunkName: "admin/fixedPage" */ "./../pages/page/admission-guide/Form"
            ),
        name: "admission_counselling_add",
        meta: {
            middleware: [auth]
        }
    },
    {
        path: "admission-guide/:page_id/admission-counselling/edit/:id",
        component: () =>
            import(
                /* webpackChunkName: "admin/fixedPage" */ "./../pages/page/admission-guide/Form"
            ),
        name: "admission_counselling_edit",
        meta: {
            middleware: [auth]
        }
    },
    {
        path: "academic-information/:page_id/academic-regulation",
        component: () =>
            import(
                /* webpackChunkName: "admin/fixedPage" */ "./../pages/page/academic-information/Index"
            ),
        name: "academic_regulation_list",
        meta: {
            middleware: [auth]
        }
    },
    {
        path: "academic-information/:page_id/academic-regulation/add",
        component: () =>
            import(
                /* webpackChunkName: "admin/fixedPage" */ "./../pages/page/academic-information/Form"
            ),
        name: "academic_regulation_add",
        meta: {
            middleware: [auth]
        }
    },
    {
        path: "academic-information/:page_id/academic-regulation/edit/:id",
        component: () =>
            import(
                /* webpackChunkName: "admin/fixedPage" */ "./../pages/page/academic-information/Form"
            ),
        name: "academic_regulation_edit",
        meta: {
            middleware: [auth]
        }
    },
    {
        path: "department-guide/:page_id/ministry-of-ministry",
        component: () =>
            import(
                /* webpackChunkName: "admin/fixedPage" */ "./../pages/page/department-guide/ministry-of-ministry/Index"
            ),
        name: "ministry_of_ministry_list",
        meta: {
            middleware: [auth]
        }
    },
    {
        path: "department-guide/:page_id/ministry-of-ministry/add",
        component: () =>
            import(
                /* webpackChunkName: "admin/fixedPage" */ "./../pages/page/department-guide/ministry-of-ministry/Form"
            ),
        name: "ministry_of_ministry_add",
        meta: {
            middleware: [auth]
        }
    },
    {
        path: "department-guide/:page_id/ministry-of-ministry/edit/:id",
        component: () =>
            import(
                /* webpackChunkName: "admin/fixedPage" */ "./../pages/page/department-guide/ministry-of-ministry/Form"
            ),
        name: "ministry_of_ministry_edit",
        meta: {
            middleware: [auth]
        }
    },
    {
        path: "department-guide/:page_id/department-of-missiology",
        component: () =>
            import(
                /* webpackChunkName: "admin/fixedPage" */ "./../pages/page/department-guide/department-of-missiology/Index"
            ),
        name: "department_of_missiology_list",
        meta: {
            middleware: [auth]
        }
    },
    {
        path: "department-guide/:page_id/department-of-missiology/add",
        component: () =>
            import(
                /* webpackChunkName: "admin/fixedPage" */ "./../pages/page/department-guide/department-of-missiology/Form"
            ),
        name: "department_of_missiology_add",
        meta: {
            middleware: [auth]
        }
    },
    {
        path: "department-guide/:page_id/department-of-missiology/edit/:id",
        component: () =>
            import(
                /* webpackChunkName: "admin/fixedPage" */ "./../pages/page/department-guide/department-of-missiology/Form"
            ),
        name: "department_of_missiology_edit",
        meta: {
            middleware: [auth]
        }
    },
    {
        path: "department-guide/:page_id/department-of-pastoral-music",
        component: () =>
            import(
                /* webpackChunkName: "admin/fixedPage" */ "./../pages/page/department-guide/department-of-pastoral-music/Index"
            ),
        name: "department_of_pastoral_music_list",
        meta: {
            middleware: [auth]
        }
    },
    {
        path: "department-guide/:page_id/department-of-pastoral-music/add",
        component: () =>
            import(
                /* webpackChunkName: "admin/fixedPage" */ "./../pages/page/department-guide/department-of-pastoral-music/Form"
            ),
        name: "department_of_pastoral_music_add",
        meta: {
            middleware: [auth]
        }
    },
    {
        path: "department-guide/:page_id/department-of-pastoral-music/edit/:id",
        component: () =>
            import(
                /* webpackChunkName: "admin/fixedPage" */ "./../pages/page/department-guide/department-of-pastoral-music/Form"
            ),
        name: "department_of_pastoral_music_edit",
        meta: {
            middleware: [auth]
        }
    },

    {
        path: "community/:page_id/icu-articles-public-relations",
        component: () =>
            import(
                /* webpackChunkName: "admin/fixedPage" */ "./../pages/page/community/article-publications/Index"
            ),
        name: "ics_articles_list"
    },

    {
        path: "community/:page_id/icu-articles-public-relations/add",
        component: () =>
            import(
                /* webpackChunkName: "admin/fixedPage" */ "./../pages/page/community/article-publications/Form"
            ),
        name: "ics_articles_add"
    },

    {
        path: "community/:page_id/icu-articles-public-relations/edit/:id",
        component: () =>
            import(
                /* webpackChunkName: "admin/fixedPage" */ "./../pages/page/community/article-publications/Form"
            ),
        name: "ics_articles_edit"
    },
    {
        path: "community/:page_id/offline-seminar",
        component: () =>
            import(
                /* webpackChunkName: "admin/fixedPage" */ "./../pages/page/community/offline-seminar/Index"
            ),
        name: "offline_seminar_list"
    },

    {
        path: "community/:page_id/offline-seminar/add",
        component: () =>
            import(
                /* webpackChunkName: "admin/fixedPage" */ "./../pages/page/community/offline-seminar/Form"
            ),
        name: "offline_seminar_add"
    },

    {
        path: "community/:page_id/offline-seminar/edit/:id",
        component: () =>
            import(
                /* webpackChunkName: "admin/fixedPage" */ "./../pages/page/community/offline-seminar/Form"
            ),
        name: "offline_seminar_edit"
    },
    {
        path: "community/:page_id/downloads",
        component: () =>
            import(
                /* webpackChunkName: "admin/fixedPage" */ "./../pages/page/community/download/Index"
            ),
        name: "download_list"
    },

    {
        path: "community/:page_id/downloads/add",
        component: () =>
            import(
                /* webpackChunkName: "admin/fixedPage" */ "./../pages/page/community/download/Form"
            ),
        name: "download_add"
    },
    {
        path: "community/:page_id/downloads/edit/:id",
        component: () =>
            import(
                /* webpackChunkName: "admin/fixedPage" */ "./../pages/page/community/download/Form"
            ),
        name: "download_edit"
    }
];
