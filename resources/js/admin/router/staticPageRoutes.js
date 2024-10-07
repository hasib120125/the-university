import auth from "../middlewares/auth";

export const staticPageRoutes = [
    {
        path: 'static-pages',
        component: () => import(/* webpackChunkName: "admin/static_pages" */ './../pages/static_page/Index'),
        name: "static_pages",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'static-pages/:id',
        component: () => import(/* webpackChunkName: "admin/static_pages" */ './../pages/static_page/Form'),
        name: "static_pages_edit",
        meta: {
            middleware: [
                auth
            ]
        }
    },
];
