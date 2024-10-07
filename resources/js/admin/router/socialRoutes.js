import auth from "../middlewares/auth";
export const socialRoutes = [
    {
        path: 'socials',
        component: () => import(/* webpackChunkName: "admin/social" */ './../pages/social/Index'),
        name: "socials",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'socials/add',
        component: () => import(/* webpackChunkName: "admin/social" */ './../pages/social/Form'),
        name: "socials_add",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'socials/edit/:id',
        component: () => import(/* webpackChunkName: "admin/social" */ './../pages/social/Form'),
        name: "socials_edit",
        meta: {
            middleware: [
                auth
            ]
        }
    },
];
