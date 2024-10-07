import auth from "../middlewares/auth";
export const featuresRoutes = [
    {
        path: 'features',
        component: () => import(/* webpackChunkName: "admin/feature" */ './../pages/feature/Index'),
        name: "features",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'features/add',
        component: () => import(/* webpackChunkName: "admin/feature" */ './../pages/feature/Form'),
        name: "features_add",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'features/edit/:id',
        component: () => import(/* webpackChunkName: "admin/feature" */ './../pages/feature/Form'),
        name: "features_edit",
        meta: {
            middleware: [
                auth
            ]
        }
    },
];

