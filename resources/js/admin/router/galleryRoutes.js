import auth from "../middlewares/auth";
export const galleryRoutes = [
    {
        path: 'galleries',
        component: () => import(/* webpackChunkName: "admin/gallery" */ './../pages/gallery/Index'),
        name: "galleries",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'galleries/add',
        component: () => import(/* webpackChunkName: "admin/gallery" */ './../pages/gallery/Form'),
        name: "galleries_add",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'galleries/:id',
        component: () => import(/* webpackChunkName: "admin/gallery" */ './../pages/gallery/Form'),
        name: "galleries_edit",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'galleries/:id/view',
        component: () => import(/* webpackChunkName: "admin/gallery" */ './../pages/gallery/View'),
        name: "galleries_view",
        meta: {
            middleware: [
                auth
            ]
        }
    },
];
