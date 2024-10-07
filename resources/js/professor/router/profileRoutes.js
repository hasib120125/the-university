import auth from "../middlewares/auth";

export const profileRoutes = [
    {
        path: 'profile',
        component: () => import(/* webpackChunkName: "professor/profile" */ './../pages/profile/Index'),
        name: 'profile',
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'profile/edit',
        component: () => import(/* webpackChunkName: "professor/profile" */ './../pages/profile/Form'),
        name: 'profile_edit',
        meta: {
            middleware: [
                auth
            ]
        }
    },
];
