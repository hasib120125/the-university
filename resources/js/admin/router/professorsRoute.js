import auth from "../middlewares/auth";
export const professorsRoute = [
    {
        path: 'professors',
        component: () => import(/* webpackChunkName: "admin/professor" */ './../pages/professor/Index'),
        name: "professors",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'professors/add',
        component: () => import(/* webpackChunkName: "admin/professor" */ './../pages/professor/Form'),
        name: "professors_add",
        meta: {
            middleware: [
                auth
            ]
        }
    },
    {
        path: 'professors/edit/:id',
        component: () => import(/* webpackChunkName: "admin/professor" */ './../pages/professor/Form'),
        name: "professors_edit",
        meta: {
            middleware: [
                auth
            ]
        }
    },
];
