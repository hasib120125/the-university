import auth from "../middlewares/auth";
export const popUpRoutes = [
    {
        path: 'popup',
        component: () => import(/* webpackChunkName: "admin/social" */ './../pages/popup/Index'),
        name: "popup",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'popup/add',
        component: () => import(/* webpackChunkName: "admin/social" */ './../pages/popup/Form'),
        name: "popup_add",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'popup/edit/:id',
        component: () => import(/* webpackChunkName: "admin/social" */ './../pages/popup/Form'),
        name: "popup_edit",
        meta: {
            middleware: [
                auth
            ]
        }
    },
];
