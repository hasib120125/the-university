import auth from "../middlewares/auth";
export const slidersRoutes = [
    {
        path: 'sliders',
        component: () => import(/* webpackChunkName: "admin/slider" */ './../pages/slider/Index'),
        name: "sliders",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'sliders/add',
        component: () => import(/* webpackChunkName: "admin/slider" */ './../pages/slider/Form'),
        name: "sliders_add",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'sliders/edit/:id',
        component: () => import(/* webpackChunkName: "admin/slider" */ './../pages/slider/Form'),
        name: "sliders_edit",
        meta: {
            middleware: [
                auth
            ]
        }
    },
];
