import auth from "../middlewares/auth";
export const pageRoutes = [
    {
        path: 'pages',
        component: () => import(/* webpackChunkName: "admin/page" */ './../pages/page/Index'),
        name: "pages",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'pages/add',
        component: () => import(/* webpackChunkName: "admin/page" */ './../pages/page/Form'),
        name: "pages_add",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'pages/edit/:id',
        component: () => import(/* webpackChunkName: "admin/page" */ './../pages/page/Form'),
        name: "pages_edit",
        meta: {
            middleware: [
                auth
            ]
        }
    },
];
