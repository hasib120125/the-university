import auth from "../middlewares/auth";
export const noticesRoutes = [
    {
        path: 'notices',
        component: () => import(/* webpackChunkName: "admin/notice" */ './../pages/notice/Index'),
        name: "notices",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'notices/add',
        component: () => import(/* webpackChunkName: "admin/notice" */ './../pages/notice/Form'),
        name: "notices_add",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'notices/edit/:id',
        component: () => import(/* webpackChunkName: "admin/notice" */ './../pages/notice/Form'),
        name: "notices_edit",
        meta: {
            middleware: [
                auth
            ]
        }
    },
];
